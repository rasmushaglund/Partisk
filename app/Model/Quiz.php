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
	var $useTable = false;

	const QUIZ_MISSMATCHED_ANSWER_POINTS = 0;
	const QUIZ_NO_ANSWER_POINTS = 1;
	const QUIZ_MATCHED_ANSWER_POINTS = 2;

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
            $partyResult['no_questions'] = 0;
            $partyResult['matched_questions'] = 0;
            $partyResult['missmatched_questions'] = 0;
            $partyResult['unanswered_questions'] = 0;
        }

        foreach ($questions as $question) {
            $questionId = $question['Question']['id'];
            $matrixQuestion = $answersMatrix[$questionId];
            $userAnswer = $matrixQuestion['answer'];
            $importance = $matrixQuestion['importance'];

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
                            $currentQuestionResult['points'] = self::QUIZ_MATCHED_ANSWER_POINTS * $importance;
                            $partiesResult[$partyId]['points'] += self::QUIZ_MATCHED_ANSWER_POINTS * $importance;
				            $partiesResult[$partyId]['matched_questions'] += 1;
                        } else {
                            $currentQuestionResult['points'] = self::QUIZ_MISSMATCHED_ANSWER_POINTS;
                            $partiesResult[$partyId]['points'] += self::QUIZ_MISSMATCHED_ANSWER_POINTS;
                            $partiesResult[$partyId]['missmatched_questions'] += 1;
                        }
                    } else {
                        $currentQuestionResult['points'] = self::QUIZ_NO_ANSWER_POINTS;
                        $partiesResult[$partyId]['points'] += self::QUIZ_NO_ANSWER_POINTS;
                    }
                } else {
                    $partiesResult[$partyId]['unanswered_questions'] += 1;
                    $currentQuestionResult['answer'] = null;
                    $currentQuestionResult['points'] = self::QUIZ_NO_ANSWER_POINTS;
                    $partiesResult[$partyId]['points'] += self::QUIZ_NO_ANSWER_POINTS;
                }

                $partiesResult[$partyId]['no_questions'] += 1;
            }
        }

        $result['questions'] = $questionsResult;
        $result['parties'] = $partiesResult;

        return $result;
    }

    public function generateGraphData($partyPoints) {
    	$result = array();
    	$question_agree_rate = array();
    	$points_percentage = array();

    	$maxPoints = null;
    	$totalPoints = 0;
		
		foreach ($partyPoints as $partyPoint) {
    		if ($maxPoints == null || $partyPoint['points'] > $maxPoints) $maxPoints = $partyPoint['points'];
    		if ($partyPoint['points'] > 0) { $totalPoints += $partyPoint['points']; } 
    	}

    	foreach ($partyPoints as $id => $partyPoint) {
    		$questions_to_match = $partyPoint['no_questions'] - $partyPoint['unanswered_questions'];

    		if ($questions_to_match != 0) {
    			$question_agree_rate[$id] = round(($partyPoint['matched_questions'] / $questions_to_match) * 100);
    		} else {
    			$question_agree_rate[$id] = 0;
    		}

    		$points_percentage[$id] = $partyPoint['points'] >= 0 ? round(($partyPoint['points'] / $totalPoints) * 100) : 0;
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

    public function generateQuiz() {
		$questionModel = ClassRegistry::init('Question');

        $questionModel->recursive = -1;
        $quiz = $questionModel->find('all', array(
                'conditions' => array('Question.deleted' => false, 
                                      'Question.approved' => true),
                'fields' => array('Question.id')
            )
        );

        $quiz["Quiz"] = array(
            'index' => 0,
            'id' => String::uuid(),
            'questions' => sizeof($quiz)
        );

        return $quiz;
    }
}

?>