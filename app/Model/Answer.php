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
    public $actsAs = array('Containable');

	public $validate = array(
        'answer' => array(
            'rule' => 'notEmpty'
        ),
        'question_id' => array(
            'rule' => 'notEmpty'
        ),
        'party_id' => array(
            'rule' => 'notEmpty'
        ),
        'source' => array(
            'rule' => 'notEmpty'
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

    public function getAnswers($args) {
        
        $partyId = isset($args['partyId']) ? $args['partyId'] : null;
        $questionId = isset($args['questionId']) ? $args['questionId'] : null;
        $includeParty = isset($args['includeParty']) ? $args['includeParty'] : false;
        $includeQuestion = isset($args['includeQuestion']) ? $args['includeQuestion'] : false; 
        $includeQuestion = isset($args['includeQuestion']) ? $args['includeQuestion'] : false; 
        $includeBestResult = isset($args['includeBestResult']) ? $args['includeBestResult'] : false;

        $fields = array('id', 'party_id', 'answer', 'question_id', 'approved', 'created_by');
        $groupBy = 'party_id';
        $order = '';

        $conditions = array(array('Answer.deleted' => false));

        if ($includeParty) {
            //$this->contain(array('Party'));
            array_push($fields, 'Party.id, Party.name, (greatest(Party.last_result_parliment, Party.last_result_eu)) as Party__best_result');
            $groupBy = 'question_id, ' . $groupBy;
            array_push($conditions, array('Party.deleted' => false));
            $order = 'Party__best_result DESC';
        }

        if ($includeBestResult) {
            array_push($fields, 'Question.best_result');
            $order = 'best_result DESC';
        }

        if ($includeQuestion) {
            //$this->contain(array('Question'));
            $order = 'Question.title';
            array_push($fields, 'Question.id, Question.title');
        }

        if (isset($partyId)) {
            array_push($conditions, array('Answer.party_id' => $partyId));
        }

        if (isset($questionId)) {
            array_push($conditions, array('Answer.question_id' => $questionId));
        }
        return $this->find('all', array(
                'conditions' => $conditions,
                'fields' => $fields,
                'groupBy' => $groupBy,
                'joins' => array(
                    array('type' => 'inner',
                    'table' => '(select max(date) as latest, b.id, b.party_id, b.question_id from answers b where b.deleted = false
                                 group by b.party_id, b.question_id)',
                    'alias' => 'current',
                    'conditions' => array(
                            'Answer.question_id = current.question_id',
                            'Answer.party_id = current.party_id',
                            'current.latest = Answer.date'
                        )
                    )),
                'order' => $order
            )
        );
    }
}

?>