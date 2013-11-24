<?php 
/** 
 * Quiz model
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

class Quiz extends AppModel {
    
    
    const NOT_IMPORTANT_POINTS = 1;
    const IMPORTANT_POINTS = 3;
    const VERY_IMPORTANT_POINTS = 9;
    
    public $hasAndBelongsToMany = array(
        'Question' => array(
            'joinTable' => "question_quizzes"
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

    public function calculatePoints($quiz) {
        $answerModel = ClassRegistry::init('Answer');
        $questionModel = ClassRegistry::init('Question');
        $partiesModel = ClassRegistry::init('Party');

        $questionIds = array_map(array($this,"getQuestionIdFromQuiz"), $quiz);
        $answers = $answerModel->getAnswers(null, $questionIds, false, false); 

        $questionModel->recursive = -1;  
        $questions = $questionModel->find('all', array('conditions' => array('Question.id' => $questionIds)));
        $answersMatrix = $answerModel->getAnswersMatrix($questions, $answers);

        $partiesModel->recursive = -1;
        $parties = $partiesModel->find('all', array(
        		'fields' => array('id')
        	));

        $results = array();
        $results['parties'] = array();
        $results['questions'] = array();

        $partiesResult = array();
        $questionsResult = array();

		foreach ($quiz as $qResult) {
            if (empty($qResult['Question'])) continue;

            $questionId = $qResult['Question']['id'];
            $answer = $qResult['Question']['answer'];
            $importance = $qResult['Question']['importance'];

            $answersMatrix[$questionId]['answer'] = $answer;
            $answersMatrix[$questionId]['importance'] = $importance;
        }	

        foreach ($parties as $party) {
            $partyResult = &$partiesResult[$party['Party']['id']];
            $partyResult = array();
            $partyResult['points'] = 0;
            $partyResult['plus_points'] = 0;
            $partyResult['minus_points'] = 0;
            $partyResult['no_questions'] = 0;
            $partyResult['matched_questions'] = 0;
            $partyResult['missmatched_questions'] = 0;
            $partyResult['unanswered_questions'] = 0;
        }

        foreach ($questions as $question) {
            $questionId = $question['Question']['id'];
            $matrixQuestion = $answersMatrix[$questionId];
            $userAnswer = $matrixQuestion['answer'];
            $importanceIndex = $matrixQuestion['importance'];
            $importance = 0;
            
            switch ($importanceIndex) {
                case 1: 
                    $importance = self::NOT_IMPORTANT_POINTS;
                    break;
                case 2:
                    $importance = self::IMPORTANT_POINTS;
                    break;
                case 3:
                    $importance = self::VERY_IMPORTANT_POINTS;
                    break;
                    
            }
            
            $questionsResult[$questionId] = array();
            $questionsResult[$questionId]['title'] = $question['Question']['title'];
            $questionsResult[$questionId]['parties'] = array();

            $results[$questionId] = array();

            foreach ($parties as $party) { 
                $partyId = $party['Party']['id']; 
                $sameAnswer = null; 

                $questionsResult[$questionId]['parties'][$partyId] = array();
                $currentQuestionResult = &$questionsResult[$questionId]['parties'][$partyId];

                $questionsResult[$questionId]['answer'] = $userAnswer;
                $questionsResult[$questionId]['importance'] = $importance;

                if (isset($matrixQuestion['answers'][$partyId])) {
                    $partyAnswer = $matrixQuestion['answers'][$partyId]['Answer']['answer'];
     
                    $currentQuestionResult['answer'] = $partyAnswer;
                    if ($userAnswer !== null && $partyAnswer !== null) {
                        if ($partyAnswer == $userAnswer) {
                            $currentQuestionResult['points'] = $importance;
                            $partiesResult[$partyId]['points'] += $importance;
                            $partiesResult[$partyId]['plus_points'] += $importance;
				            $partiesResult[$partyId]['matched_questions'] += 1;
                        } else {
                            $currentQuestionResult['points'] = -$importance;
                            $partiesResult[$partyId]['points'] -= $importance;
                            $partiesResult[$partyId]['minus_points'] += $importance;
                            $partiesResult[$partyId]['missmatched_questions'] += 1;
                        }
                    } else {
                        $currentQuestionResult['points'] = 0;
                    }
                } else {
                    $partiesResult[$partyId]['unanswered_questions'] += 1;
                    $currentQuestionResult['answer'] = null;
                    $currentQuestionResult['points'] = 0;
                }

                $partiesResult[$partyId]['no_questions'] += 1;
            }
        }

        $result['questions'] = $questionsResult;
        $result['parties'] = $partiesResult;

        return $result;
    }

    public function getQuizById($id) {
        $this->recursive = -1;
        $this->contain(array("CreatedBy", "UpdatedBy", "ApprovedBy"));
        $quiz = $this->find('all', array(
                'conditions' => array(
                        'Quiz.id' => $id
                    ),
                'fields' => array('Quiz.id, Quiz.name, Quiz.created_date, Quiz.updated_date, Quiz.description, 
                                   Quiz.deleted, Quiz.approved, Quiz.created_by, Quiz.approved_by, Quiz.approved_date')
            ));
        return array_pop($quiz);
    }
    
    public function getAllQuizzes($loggedIn) {
        $conditions = array('deleted' => false);
        
        if(!$loggedIn) {
            $conditions['approved'] = true;
        }   

        $this->recursive = -1;
        return $this->find('all', array(
                'conditions' => $conditions
            ));
    }

    public function generateGraphData($partyPoints) {
    	$result = array();
    	$question_agree_rate = array();
    	$points_percentage = array();

    	$maxPoints = null;
    	$totalPoints = 0;
        foreach ($partyPoints as $partyPoint) {
            if ($maxPoints > 0) $maxPoints = $partyPoint['points'];
            if ($partyPoint['points'] > 0) { $totalPoints += $partyPoint['points']; } 
        }

        foreach ($partyPoints as $id => $partyPoint) {
            $questions_to_match = $partyPoint['no_questions'] - $partyPoint['unanswered_questions'];
            $question_agree_rate[$id] = array();
            $points_percentage[$id] = array();

            $range = abs($partyPoint['minus_points']) + $partyPoint['plus_points'];
            if ($range != 0) {
                $question_agree_rate[$id]['result'] = round(($partyPoint['plus_points'] / $range) * 100);
            } else {
                $question_agree_rate[$id]['result'] = 0;
            }

            $question_agree_rate[$id]['range'] = $range;
            $question_agree_rate[$id]['plus_points'] = $partyPoint['plus_points'];
            $question_agree_rate[$id]['minus_points'] = $partyPoint['minus_points'];

            $points_percentage[$id]['result'] = $partyPoint['points'] > 0 ? round(($partyPoint['points'] / $totalPoints) * 100) : 0;
            $points_percentage[$id]['range'] = $totalPoints;
            $points_percentage[$id]['points'] = $partyPoint['points']; 
        }

    	$result['question_agree_rate'] = $question_agree_rate;
    	$result['points_percentage'] = $points_percentage;

    	return $result;
    }

    private function getQuestionIdFromQuiz($quiz) {
        if (!empty($quiz['Question'])) {
            return $quiz['Question']['id'];
        }
    }

    public function generateQuiz($id) {
		$questionModel = ClassRegistry::init('Question');

        $questionModel->recursive = -1;
        $quiz = $questionModel->find('all', array(
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
            )
        );

        if (sizeof($quiz) < 1) {
            throw new InvalidArgumentException('A quiz has to have at least 1 question');
        }

        $quiz["Quiz"] = array(
            'index' => 0,
            'id' => String::uuid(),
            'quiz_id' => $id, 
            'has_answers' => false,
            'questions' => sizeof($quiz)
        );

        return $quiz;
    }
}

?>