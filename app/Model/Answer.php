<?php 
/** 
 * Answers model
 *
 * Partisk : Political Party Opinion Visualizer
 * Copyright (c) Partisk.nu Team (https://www.partisk.nu)
 *
 * Partisk is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Partisk is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Partisk. If not, see http://www.gnu.org/licenses/.
 *
 * @copyright   Copyright (c) Partisk.nu Team (https://www.partisk.nu)
 * @link        https://www.partisk.nu
 * @package     app.Model
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

class Answer extends AppModel {
	public $validate = array(
        'answer' => array(
            'ruleEmpty' => array(
                'rule' => 'alphaNumeric',
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

    public function getAnswersMatrix($questions, $answers) {
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

        return $answersMatrix;
    }
    
    public function getNotAnswered($partyId){
        
        return $this->Question->find('all',array(
            'conditions' => array(
                '!Question.deleted',
                'Question.approved',                
                'answers.id' => null,                
                ),
            'joins' => array(
                array(
                    'table' => 'answers',
                    'type' => 'left',
                    'conditions' => array(
                        'answers.question_id = Question.id',
                        'answers.party_id' => $partyId                        
                    )
                )
            )
        ));
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

        $fields = array('id', 'party_id', 'answer', 'question_id', 'approved', 'created_by', 'deleted', 'description', 'source');
        $groupBy = 'party_id, question_id';
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
            //$groupBy .= ', question_id';
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
            array_push($fields, 'Question.id, Question.title');
        }

        if (isset($partyId)) {
            $conditions['Answer.party_id'] = $partyId;
        }

        if (isset($tagId)) {
            $conditions['Tag.id'] = $tagId;
            array_push($joins, array('type' => 'inner',
                                     'table' => 'tags as Tag',
                                    'conditions' => array('Tag.id' => $tagId)));
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