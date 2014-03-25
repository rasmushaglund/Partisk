<?php 
/**
 * Copyright 2013-2014 Partisk.nu Team
 * https://www.partisk.nu/
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * 
 * @copyright   Copyright 2013-2014 Partisk.nu Team
 * @link        https://www.partisk.nu
 * @package     app.Model
 * @license     http://opensource.org/licenses/MIT MIT
 */

class Question extends AppModel {
    public $validate = array(
        'title' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Du måste ange en titel'
            )
        )
    );

    public $hasMany = array(
        'Answer' => array(
            'className' => 'Answer',
            'foreignKey' => false,
            'finderQuery' => 'select Answer.* from answers Answer where Answer.question_id in (select question_id from questions where id = {$__cakeID__$})'
        )
    );

    public $belongsTo = array(
        'CreatedBy' => array(
            'className' => 'User', 
            'foreignKey' => 'created_by',
            'fields' => array('id', 'username')
        ),
        'UpdatedBy' => array(
            'className' => 'User',
            'foreignKey' => 'updated_by',
            'fields' => array('id', 'username')
        ),
        'ApprovedBy' => array(
            'className' => 'User',
            'foreignKey' => 'approved_by',
            'fields' => array('id', 'username')
        )
	);

    public $hasAndBelongsToMany = array(
        'Tag'=> array(
            'joinTable' => "question_tags"
            ),
        'Quiz'=> array(
            'joinTable' => "question_quizzes"
            )
    );

    // TODO: Handle all answer types here (like YESNO)
    public function getChoicesFromQuestion($question) {
        $result = array();

        if ($question['Question']['type'] == 'CHOICE') {
            $choices = array();
        
            foreach ($question['Answer'] as $answer) {
                $choices[$answer['answer']] = $answer['answer'];
            }

            ksort($choices);
            
            $result['NO_OPINION'] = 'ingen åsikt';
            foreach ($choices as $choice) {
                $result[$choice] = $choice;
            }
        }

        return $result;
    }

    public function getQuestions($args) {
        $this->recursive = -1; 

        $id = isset($args['question_id']) ? $args['question_id'] : null;
        $deleted = isset($args['deleted']) ? $args['deleted'] : null;
        $approved = isset($args['approved']) ? $args['approved'] : null;
        $tagId = isset($args['tagId']) ? $args['tagId'] : null;
        $fields = isset($args['fields']) ? $args['fields'] : array('question_id', 'id', 'title', 'type', 'approved', 'created_by', 'description', 'deleted', 'done');
        $conditions = isset($args['conditions']) ? $args['conditions'] : array();
        $order = isset($args['order']) ? $args['order'] : 'Question.title';
        $limit = isset($args['limit']) ? $args['limit'] : '5000';

        $joins = array();

        if (isset($id)) { $conditions['question_id'] = $id; }
        if (isset($approved)) { $conditions['approved'] = $approved; }
        if (isset($deleted)) { $conditions['deleted'] = $deleted; }
        if (isset($partyId)) { $conditions['party_id'] = $partyId; }

        if (isset($tagId)) {
	   if ($tagId > 0 ) {
            array_push($joins, array(
                                'table' => 'question_tags as QuestionTag',
                                'conditions' => array('QuestionTag.tag_id' => $tagId,
                                                      'Question.id = QuestionTag.question_id')
                            ));
           } else {
            array_push($conditions, array(
			      'Question.id not in (select question_id from question_tags inner join tags on tags.id = question_tags.tag_id and tags.is_category = true where question_tags.question_id = Question.id and Question.approved = true)')
                            );
	   }
        }

        $questions = $this->find('all', array(
            'order' => $order,
            'conditions' => $conditions,
            'joins' => $joins,
            'fields' => $fields,
            'limit' => $limit,
	    'group' => 'Question.question_id'
            ));
        
        return $questions;
    }
    
    public function getQuestion($args) {
        $questions = $this->getQuestions($args);
        return !empty($questions) ? array_pop($questions) : null; 
    }
    
    public function getQuestionWithAnswers($id) {   
        $this->recursive = -1;
        $this->contain(array('Answer.answer', 'Answer.id'));
        $questions = $this->find('all', array(
            'conditions' => array('Question.question_id' => $id),
            'contain' => array('Answer.deleted' => false, 'Answer.approved' => true),
            'fields' => array('Question.question_id', 'Question.title', 'Question.description', 'Question.type')
            ));
        return array_pop($questions);
    }

    public function getByIdOrTitle($id, $onlyApproved = true, $entityId = false, $isId = false) {
        $result = Cache::read('question_' . $id, 'question');
        if (!$result) {
            
            if (is_numeric($id) || $isId) {
                if ($entityId) {
                    $conditions = array(
                                    'Question.id' => $id
                                );
                } else {
                    $conditions = array(
                                    'Question.question_id' => $id
                                );
                }
            } else {
                $conditions = array(
                                "Question.title like" => $id
                            );                
            }
            
            if ($onlyApproved) {
                $conditions['Question.approved'] =  true;
            }
            
            $this->recursive = -1;
            $this->contain(array("CreatedBy", "UpdatedBy", "ApprovedBy"));
            $this->Tag->virtualFields['number_of_questions'] = 0;
            $questions = $this->find('all', array(
                    'conditions' => $conditions,
                    'fields' => array('Question.id, Question.question_id, Question.title, Question.version, Question.created_date, Question.updated_date, Question.description, Question.type, 
                                       Question.deleted, Question.approved, Question.created_by, Question.approved_by, Question.approved_date, Question.done'),
                    'order' => 'Question.version'
                ));
            $question = array_pop($questions);
            
            if (!empty($question)) {
                $this->Tag->recursive = -1;
                $question['Tag'] = Set::extract('/Tag/.', $this->Tag->getQuestionTags($question['Question']['id']));
            }
            
            $result = $question;
            Cache::write('question_' . $id, $result, 'question');
        }
        
        return $result;
    }
    
    public function getRevisions($id, $date = 0) {
        $result = Cache::read('revisions', 'question');
        if (!$result) {
            
            $this->recursive = -1;
            $this->contain(array("CreatedBy", "UpdatedBy", "ApprovedBy"));
            $this->Tag->virtualFields['number_of_questions'] = 0;
            $result = $this->find('all', array(
                    'conditions' => array(
                                'Question.question_id' => $id,
                                "Question.updated_date >= " => $date
                            ),
                    'fields' => array('Question.id, Question.question_id, Question.title, Question.version, Question.created_date, Question.updated_date, Question.description, Question.type, 
                                       Question.deleted, Question.approved, Question.created_by, Question.approved_by, Question.approved_date, Question.done'),
                    'order' => 'Question.updated_date desc'
                ));
            Cache::write('revisions', $result, 'question');
        }
        
        return $result;
    } 
    
    public function getRevision($id) {
        $result = Cache::read('revision_' . $id, 'question');
        if (!$result) {
            
            $this->recursive = -1;
            $this->contain(array("CreatedBy", "UpdatedBy", "ApprovedBy", "Tag.id", "Tag.name"));
            $this->Tag->virtualFields['number_of_questions'] = 0;
            $revisions = $this->find('all', array(
                    'conditions' => array(
                                'Question.id' => $id
                            )));
            $result = array_pop($revisions);
            Cache::write('revision_' . $id, $result, 'question');
        }
        
        return $result;
    }

    public function getAllQuestionsList($loggedIn = false) {
        $result = Cache::read('all_questions_list_' . $loggedIn ? 'logged_in' : '', 'question');
        if (!$result) {
            if (!$loggedIn) {
                $conditions = array('Question.deleted' => false, 'Question.approved' => true);
            } else {
                $conditions = array();
            }

            $result = $this->getQuestions(array(
                    'conditions' => $conditions,
                    'fields' => array('Question.question_id', 'Question.id', 'Question.title', 'Question.approved', 'Question.deleted'),
                    'groupBy' => 'Question.question_id'
                ));
            
            Cache::write('all_questions_list_' . $loggedIn ? 'logged_in' : '', $result, 'question');
        }
        
        return $result;
    }
    public function getNoDescription(){
        $results = Cache::read('no_description', 'question');
        
        if(!$results){
            $results = $this->getQuestions(array(
                'deleted' => false, 
                'conditions' => array('description' => ""),
                'fields' => array('Question.title'),
                ));
            Cache::write('no_description', $results, 'question');          
        }

        return $results;       
    } 
    public function getNotApproved(){
        $results = Cache::read('not_approved', 'question');
        
        if(!$results){
            $results = $this->getQuestions(array(
                'approved' => false, 
                'deleted' => false,
                'fields' => array('Question.title'),
                ));
            Cache::write('not_approved', $results, 'question');  
        }
        
        return $results;
    }
    
    public function getNewRevisions(){
        return $this->query("SELECT * 
                    FROM questions Question, questions q
                    WHERE q.question_id = Question.question_id
                    AND q.approved = 
                    TRUE AND Question.approved = 
                    FALSE AND Question.updated_date > q.updated_date
                    group by Question.question_id");
    }
    
    public function getQuestionsByQuizId($id) {
       $result = Cache::read('quiz_questions_by_quiz_' . $id, 'question');
       if (!$result) {
            $this->recursive = -1; 
         

                $result = $this->find('all', array(
                    'conditions' => array('deleted' => false, 'approved' => true),
                    'joins' => array(array(
                                    'table' => 'question_quizzes as QuestionQuiz',
                                    'conditions' => array('QuestionQuiz.quiz_id' => $id,
                                                          'Question.question_id = QuestionQuiz.question_id')
                                )),
                    'fields' => array('Question.*, QuestionQuiz.id'),
                    'group' => 'Question.question_id'
                ));
           
          Cache::write('quiz_questions_by_quiz_' . $id, $result, 'question');
        }
        
        return $result;
    }
    
    public function getUserQuestions($userId) {
        $this->recursive = -1;
        return $this->find('all', array(
           'conditions' => array('created_by' => $userId) 
        ));
    }
    
    public function getVisibleQuestions() {
        $result = Cache::read('visible_questions', 'question');
        if (!$result) {
            $result = $this->getQuestions(array('deleted' => false, 'approved' => true));
            Cache::write('visible_questions', $result, 'question');
        }
        
        return $result;
    }
    
    public function getLoggedInQuestions() {
        $result = Cache::read('loggedin_questions', 'question');
        if (!$result) {
            $result = $this->getQuestions(array('deleted' => false));
            Cache::write('loggedin_questions', $result, 'question');
        }
        
        return $result;
    }
    
    public function getAllVisibleQuestionIds() {
        $result = Cache::read('visible_question_ids', 'question');
        if (!$result) {
            $result = $this->find('all', array(
                 'conditions' => array('Question.deleted' => false, 
                                       'Question.approved' => true),
                 'fields' => array('Question.id')
                ));
            Cache::write('visible_question_ids', $result, 'question');
        }
        
        return $result;
    }
    
    public function searchQuestion($what, $loggedIn = false) {
        $loggedInString = isset($loggedIn) && $loggedIn ? 'logged_in_' : '';
        $result = Cache::read('search_' . $loggedInString . $what, 'question');
        if (strlen($what) < 3) {
            $result = array();
            Cache::write('search_' . $loggedInString . $what, $result, 'question');
            return $result;
        }
        
        if (!$result) {
            $conditions = array('title LIKE' => "%$what%",
                                      'deleted' => false);
            
            if (!$loggedIn) {
                $conditions['approved'] = true;
            }
            
            $this->recursive = -1;	            
            $questions = $this->find('list', array(
                'conditions' => $conditions,
                'fields' => array('title'),
                'limit' => '5'
            ));
            
            $result = array();
            
            foreach ($questions as $key=>$value) {
                $result[] = array('key' => $key, 'value' => $value);
            }
            
            if (sizeof($result) == 0) {
                $result = array(array('value' => 'Ingen fråga matchade ditt svar'));
            }
            
            Cache::write('search_' . $loggedInString . $what, $result, 'question');
        }
        return $result;
    }
    
  


    public function getNotAnswered($partyId){
        $result = Cache::read('not_ansered_' . $partyId, 'question');
        if (!$result) {
            $this->recursive = -1;
            $result = $this->find('all',array(
                'conditions' => array(
                    'Question.deleted' => false,
                    'Question.approved' => true,
                    'Answer.id' => null,                
                    ),
                'joins' => array(
                    array(
                        'table' => 'answers as Answer',
                        'type' => 'left',
                        'conditions' => array(
                            'Answer.question_id = Question.question_id',
                            'Answer.party_id' => $partyId
                        )
                    )
                ),
                'order' => array('Question.title')
            ));
            Cache::write('not_ansered_' . $partyId, $result, 'question');
        }
        
        return $result;
    }
     
    public function getAllQuizQuestions($id) {
        $result = Cache::read('all_quiz_questions_' . $id, 'question');
        if (!$result) {
            $result = $this->find('all', array(
                'conditions' => array('Question.deleted' => false, 
                                      'Question.approved' => true),
                'fields' => array('Question.question_id'),
                'joins' => array(
                    array(
                        'table' => 'question_quizzes as QuestionQuiz',
                        'conditions' => array(
                                'QuestionQuiz.quiz_id' => $id,
                                'QuestionQuiz.question_id = Question.question_id'
                        )
                    )
                 )
             )); 
            Cache::write('all_quiz_questions_' . $id, $result, 'question');
        }
        
        return $result;
    }
    
    public function getAvailableQuizQuestions($quizId) {
    	$this->recursive = -1;
        $result = $this->find('all', array(
            'conditions' => array('Question.deleted' => false, 
                                  'Question.approved' => true,
                                  "Question.question_id not in (select question_id from question_quizzes as QuestionQuiz where quiz_id = $quizId)"),
            'fields' => array('Question.question_id', 'Question.id',
                              'Question.title', '1 < (select count(distinct party_id) from answers where question_id = Question.question_id and approved) as multiple_answers'),
            'order' => 'multiple_answers desc, Question.title',
            'group' => 'Question.question_id'
         )); 
        return $result;
    }
    
    public function getLatestQuestions() {
        $result = Cache::read('latest', 'question');
        if (!$result) {
            $result = $this->getQuestions(array('deleted' => false, 'approved' => true, 'order' => 'approved_date desc', 'limit' => 5));
            Cache::write('latest', $result, 'question');
        }
        
        return $result;
    }
    
    public function getVisibleTagQuestions($id) {
         $result = Cache::read('visible_tag_questions_' . $id, 'question');
         if (!$result) {
	     $result = $this->getQuestions(array('deleted' => false, 'approved' => true, 'tagId' => $id));
	     
             Cache::write('visible_tag_questions_' . $id, $result, 'question');
         }
         
         return $result;
     }
     
    public function getTagQuestions($id) {
         $result = Cache::read('tag_questions_' . $id, 'question');
         if (!$result) {
	     $result = $this->getQuestions(array('deleted' => false, 'approved' => true, 'tagId' => $id, 
                 'fields' => array('id')));
	     
             Cache::write('tag_questions_' . $id, $result, 'question');
         }
         
         return $result;
     }
     
     public function getLoggedInTagQuestions($id) {
        $result = Cache::read('loggedin_tag_questions_' . $id, 'question');
        if (!$result) {
            $result = $this->getQuestions(array('deleted' => false, 'tagId' => $id));
            Cache::write('loggedin_tag_questions_' . $id, $result, 'question');
        }
        
        return $result;
    }
    
    public function getNumberOfQuestions() {
       $result = Cache::read('number_of_questions', 'question');
        
        if (!$result) {
            $this->recursive = -1;
            $result = $this->find('count', array(
                    'conditions' => array('approved' => true)
                ));
            Cache::write('number_of_questions', $result, 'question');
        }
        
        return $result; 
    }
    
    public function getPopularQuestions() {
        $result = Cache::read('popular_questions', 'question');
        
        if (!$result) {
            // Hottest questions last 14 days 
           $result = $this->query("SELECT Question.* , SUM( a.importance ) AS points
                            FROM questions Question, quiz_answers a
                            WHERE Question.question_id = a.question_id
                            and Question.approved = true and Question.deleted = false 
                            and a.date > DATE_ADD(CURDATE(), INTERVAL -14 DAY)
                            GROUP BY Question.question_id
                            ORDER BY points DESC 
                            LIMIT 5");
            Cache::write('popular_questions', $result, 'question');
        }
        
        return $result;
    }
    
    public function afterSave($created, $options = array()) {
        parent::afterSave($created, $options);
        Cache::clear(false, 'question');
    }
    
    public function afterDelete() {
        parent::afterDelete();
        Cache::clear(false, 'question');
        Cache::clear(false, 'tag');
    }
}

?>