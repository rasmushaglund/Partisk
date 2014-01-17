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
            'className' => 'Answer'
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
        ),
        'QuestionTag'
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

        $id = isset($args['id']) ? $args['id'] : null;
        $deleted = isset($args['deleted']) ? $args['deleted'] : null;
        $approved = isset($args['approved']) ? $args['approved'] : null;
        $tagId = isset($args['tagId']) ? $args['tagId'] : null;
        $fields = isset($args['fields']) ? $args['fields'] : array('id', 'title', 'type', 'approved', 'created_by', 'description', 'deleted');
        $conditions = isset($args['conditions']) ? $args['conditions'] : array();
        $order = isset($args['order']) ? $args['order'] : 'Question.title';
        $limit = isset($args['limit']) ? $args['limit'] : '500';

        $joins = array();

        if (isset($id)) { $conditions['id'] = $id; }
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
			      'Question.id not in (select question_id from question_tags inner join tags on tags.id = tag_id and tags.is_category = true where question_id = Question.id)')
                            );
	   }
        }

        $questions = $this->find('all', array(
            'order' => $order,
            'conditions' => $conditions,
            'joins' => $joins,
            'fields' => $fields,
            'limit' => $limit,
	    'group' => 'Question.id'
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
            'conditions' => array('Question.id' => $id),
            'contain' => array('Answer.deleted' => false, 'Answer.approved' => true),
            'fields' => array('Question.id', 'Question.title', 'Question.description', 'Question.type')
            ));
        return array_pop($questions);
    }

    /*public function getLatest() {
        $result = Cache::read('latest', 'question');
        if (!$result) {
            $this->recursive = -1;
            $result = $this->find('all', array(
                'fields' => 'id, title, approved_date',
                'conditions' => array('deleted' => false, 'approved' => true),
                'limit' => '5',
                'order' => 'approved_date DESC'
            ));
            Cache::write('latest', $result, 'question');
        }
        
        return $result;
    }*/

    public function getByIdOrTitle($id) {
        $result = Cache::read('question_' . $id, 'question');
        if (!$result) {
            
            if (is_numeric($id)) {
                $conditions = array(
                                'Question.id' => $id
                            );
            } else {
                $conditions = array(
                                "Question.title like" => $id
                            );                
            }
            
            $this->recursive = -1;
            $this->contain(array("CreatedBy", "UpdatedBy", "ApprovedBy", "Tag.id", "Tag.name"));
            $this->Tag->virtualFields['number_of_questions'] = 0;
            $questions = $this->find('all', array(
                    'conditions' => $conditions,
                    'contain' => 'Tag.deleted = false',
                    'fields' => array('Question.id, Question.title, Question.created_date, Question.updated_date, Question.description, Question.type, 
                                       Question.deleted, Question.approved, Question.created_by, Question.approved_by, Question.approved_date')
                ));
            $result = array_pop($questions);
            Cache::write('question_' . $id, $result, 'question');
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
                    'fields' => array('Question.id', 'Question.title', 'Question.approved', 'Question.deleted')
                ));
            
            Cache::write('all_questions_list_' . $loggedIn ? 'logged_in' : '', $result, 'question');
        }
        
        return $result;
    }

    public function getQuestionsByQuizId($id) {
        $result = Cache::read('visible_questions', 'question');
        if (!$result) {
            $this->recursive = -1; 
            
            if ($id === 'all') {
                $result = $this->find('all', array(
                    'conditions' => array('deleted' => false, 'approved' => true)));
            } else {
                $result = $this->find('all', array(
                    'conditions' => array('deleted' => false, 'approved' => true),
                    'joins' => array(array(
                                    'table' => 'question_quizzes as QuestionQuiz',
                                    'conditions' => array('QuestionQuiz.quiz_id' => $id,
                                                          'Question.id = QuestionQuiz.question_id')
                                )),
                    'fields' => array('Question.*, QuestionQuiz.id')
                ));
            }
           
            Cache::write('visible_questions', $result, 'question');
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
                    '!Question.deleted',               
                    'Answer.id' => null,                
                    ),
                'joins' => array(
                    array(
                        'table' => 'answers as Answer',
                        'type' => 'left',
                        'conditions' => array(
                            'Answer.question_id = Question.id',
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
        $result = Cache::read('quiz_questions_' . $id, 'question');
        if (!$result) {
            $result = $this->find('all', array(
                'conditions' => array('Question.deleted' => false, 
                                      'Question.approved' => true),
                'fields' => array('Question.id'),
                'joins' => array(
                    array(
                        'table' => 'question_quizzes as QuestionQuiz',
                        'conditions' => array(
                                'QuestionQuiz.quiz_id' => $id,
                                'QuestionQuiz.question_id = Question.id'
                        )
                    )
                 )
             )); 
            Cache::write('quiz_questions_' . $id, $result, 'question');
        }
        
        return $result;
    }
    
    public function getLatestQuestions() {
        $result = Cache::read('latest', 'question');
        if (!$result) {
            $result = $this->getQuestions(array('deleted' => false, 'approved' => true, 'order' => 'approved_date', 'limit' => 5));
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
     
     public function getLoggedInTagQuestions($id) {
        $result = Cache::read('loggedin_tag_questions_' . $id, 'question');
        if (!$result) {
            $result = $this->getQuestions(array('deleted' => false, 'tagId' => $id));
            Cache::write('loggedin_tag_questions_' . $id, $result, 'question');
        }
        
        return $result;
    }
    
    /*public function getByIdOrTitle($id) {
        $result = Cache::read('question_' . $id, 'question');
        if (!$result) {
            
            if (is_numeric($id)) {
                $conditions = array(
                                'Question.id' => $id
                            );
            } else {
                $conditions = array(
                                "Question.title like" => $id
                            );                
            }
            
            $this->recursive = -1;
            $this->contain(array("CreatedBy", "UpdatedBy", "ApprovedBy", "Tag.id", "Tag.name"));
            $this->Tag->virtualFields['number_of_questions'] = 0;
            $questions = $this->find('all', array(
                    'conditions' => $conditions,
                    'contain' => 'Tag.deleted = false',
                    'fields' => array('Question.id, Question.title, Question.created_date, Question.updated_date, Question.description, Question.type, 
                                       Question.deleted, Question.approved, Question.created_by, Question.approved_by, Question.approved_date')
                ));
            $result = array_pop($questions);
            Cache::write('question_' . $id, $result, 'question');
        }
        
        return $result;
    }*/
    
    public function getPopularQuestions() {
        $result = Cache::read('popular_questions', 'question');
        
        if (!$result) {
            $file = new File('../tmp/statistics/popular_questions.txt');
            $data = explode("\n", $file->read(true, 'r'));

            $names = array();
            foreach ($data as $item) {
                $names[] = str_replace("_", " ", urldecode($item));
            }
            
            $this->recursive = -1;
            $result = $this->find('all', array(
                    'conditions' => array('Question.title' => $names, 'Question.approved' => true)
                ));
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