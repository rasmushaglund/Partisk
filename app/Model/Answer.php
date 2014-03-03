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

class Answer extends AppModel {
	public $validate = array(
        'answer' => array(
            'ruleEmpty' => array(
                'rule' => array('notEmpty'),
                'allowEmpty' => false,
                'message' => 'Du måste skriva ett svar')
        ),
        'question_id' => array(
            'ruleEmpty' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => 'Du måste välja en fråga')
        ),
        'party_id' => array(
            'ruleEmpty' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => 'Du måste välja ett parti')
        ),
        'source' => array(
            'ruleEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Du måste ange källa')
        ),
        'date' => array(  
            'ruleDate' => array(
                'rule' => 'date',
                'message' => 'Du måste ange ett datum för källan'
            )
        ) 
    );
    
    public $belongsTo = array(
        'Party',
        'Question',
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

    public function getAnswersMatrix($questions, $answers, $minAnswers = 0) {
        $answersMatrix = array();

        foreach ($answers as $answer) {
            $questionId = $answer['Answer']["question_id"];
            $partyId = $answer['Answer']["party_id"];
            
            if (!isset($answersMatrix[$questionId])) {
                $answersMatrix[$questionId] = array();
            }

            if (!isset($answersMatrix[$questionId]['answers'])) {
                $answersMatrix[$questionId]['answers'] = array();
                $answersMatrix[$questionId]['answers'][$partyId] = array();
            }

            // If there are more than 1 answer, take the newest
            if (isset($answersMatrix[$questionId]['answers'][$partyId]['Answer']['date'])) {
                if ($answer['Answer']['date'] < $answersMatrix[$questionId]['answers'][$partyId]['Answer']['date']) {
                    continue;
                }
            } 

            $answersMatrix[$questionId]["hasAnswers"] = true;
            $answersMatrix[$questionId]['answers'][$partyId] = $answer;
        }
        
        if ($minAnswers > 0) {
            foreach ($answersMatrix as $key => $value) {
                if (sizeof($answersMatrix[$key]['answers']) < $minAnswers) {
                    unset($answersMatrix[$key]);
                }
            }
        }
        
        return $answersMatrix;
    }
   
    public function getAnswers($args) {
        $tagId = isset($args['tagId']) ? $args['tagId'] : null;
        $partyId = isset($args['partyId']) ? $args['partyId'] : null;
        $questionId = isset($args['questionId']) ? $args['questionId'] : null;
        $deleted = isset($args['deleted']) ? $args['deleted'] : null;
        $approved = isset($args['approved']) ? $args['approved'] : null;
        $includeParty = isset($args['includeParty']) ? $args['includeParty'] : false;
        $includeQuestion = isset($args['includeQuestion']) ? $args['includeQuestion'] : false; 
        $includeBestResult = isset($args['includeBestResult']) ? $args['includeBestResult'] : false;

        $fields = array('id', 'party_id', 'answer', 'Answer.question_id', 'approved', 'created_by', 'deleted', 'description', 'source');
        $groupBy = 'party_id, Answer.question_id';
        $order = '';
        $contain = array();

        $conditions = array('Answer.deleted' => false);
        
        if (isset($deleted)) { $conditions['Answer.deleted'] = $deleted; }
        if (isset($approved)) { $conditions['Answer.approved'] = $approved; }

        $joins = array(
                    array('type' => 'inner',
                    'table' => '(select max(date) as latest, b.id, b.party_id, b.question_id from answers b where b.deleted = false 
                                 group by b.party_id, b.question_id)',
                    'alias' => 'current',
                    'conditions' => array(
                            'Answer.question_id = current.question_id',
                            'Answer.party_id = current.party_id',
                            'current.latest = Answer.date'
                        )
                    ));

        if ($includeParty) {
            array_push($contain, 'Party');
            array_push($fields, 'Party.id, Party.name, (greatest(Party.last_result_parliment, Party.last_result_eu)) as Party__best_result');
            $conditions['Party.deleted'] = false;
            $order = 'Party__best_result DESC';
        }

        if ($includeBestResult) {
            array_push($fields, 'Question.best_result');
            $order = 'best_result DESC';
        }

        if ($includeQuestion) {
            array_push($contain, 'Question');
            $order = 'Question.title';
            array_push($fields, 'Question.question_id, Question.title', 'Question.done');
        }

        if (isset($partyId)) {
            $conditions['Answer.party_id'] = $partyId;
        }

        if (isset($tagId)) {
            array_push($joins, array('type' => 'inner',
                                     'table' => 'question_tags as QuestionTag',
                                    'conditions' => array('QuestionTag.tag_id' => $tagId, 'QuestionTag.question_id = Answer.question_id')));
        }

        if (isset($questionId)) {
            $conditions['Answer.question_id'] = $questionId;
        }

        $this->contain($contain);

        return $this->find('all', array(
                'conditions' => $conditions,
                'fields' => $fields,
                'group' => $groupBy,
                'joins' => $joins,
                'order' => $order
            )
        );
    }
     
    public function getNumberOfAnswers() {
       $result = Cache::read('number_of_answers', 'answers');
        
        if (!$result) {
            $this->recursive = -1;
            $result = $this->find('count', array(
                    'conditions' => array('approved' => true)
                ));
            Cache::write('number_of_answers', $result, 'answer');
        }
        
        return $result; 
    }
    
    public function getUserAnswers($userId) {
        $this->recursive = -1;
        $this->contain(array('Question', 'Party'));
        return $this->find('all', array(
           'conditions' => array('Answer.created_by' => $userId)
        ));
    }
    
    public function getById($id) {
        $result = Cache::read('answer_' . $id, 'answer');
        if (!$result) {
            $this->recursive = 1;
            $this->contain(array("CreatedBy", "UpdatedBy", 'ApprovedBy', 'Party', 'Question'));
            $result = $this->findById($id);
            
            $this->Question->recursive = -1;
            $this->contain();
            $result['history'] = $this->find('all',array(
                    'conditions' => array(
                        'Answer.deleted' => false,
                        'party_id' => $result['Party']['id'],
                        'question_id' => $result['Answer']['question_id']),
                    'fields' => array('Answer.*'),
                    'order' => 'Answer.date DESC'
                )
            );
            Cache::write('answer_' . $id, $result, 'answer');
        }
        
        return $result;
    }
    
    public function afterSave($created, $options = array()) {
        parent::afterSave($created, $options);
        Cache::clear(false, 'answer');
    }
    
    public function afterDelete() {
        parent::afterDelete();
        Cache::clear(false, 'answer');
    }
}

?>