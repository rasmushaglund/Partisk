<?php
/** 
 * Controller for managing quiz related pages
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
 * @package     app.Controller
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

class QuizController extends AppController {
    public $helpers = array('Html', 'Form');

    const DEFAULT_IMPORTANCE = 2;

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('next', 'prev', 'results', 'close', 'questions' ,'restart'));
    }

    public function beforeRender() {
        parent::beforeRender();
        $this->set("currentPage", "quiz");
    }

    public function index() {
        $quiz = $this->Session->read('quiz');

        if (!empty($quiz)) {
            $this->set('quizId', $quiz['Quiz']['id']);
        }

        $this->set('ongoingQuiz', !empty($quiz));
        $this->set('quizIsDone', $this->quizIsDone());
        $this->set('title_for_layout', 'Quiz');
    }

    public function questions() {
        if ($this->quizIsDone()) {
            return $this->redirect(array('action' => 'results'));   
        }

        $quiz = $this->Session->read('quiz');

        if (!isset($quiz) || !isset($quiz['Quiz'])) {
            $quiz = $this->Quiz->generateQuiz();
            $this->Session->write('quiz', $quiz);
        }

        $index = $quiz['Quiz']['index'];

        $this->loadModel('Question');
        $questions = $this->Question->getQuestions(array('id' => $quiz[$index]['Question']['id']));
        $question = array_pop($questions);
        $choices = $this->Question->getChoicesFromQuestion($question);

        $answer = $this->getCurrentAnswer($quiz, $index);
        $importance = $this->getCurrentImportance($quiz, $index);
        
        $this->set('question', $question);
        $this->set('answer', $answer);
        $this->set('importance', $importance);
        $this->set('choices', $choices);
        $this->set('quiz', $quiz);
        $this->set('title_for_layout', 'Frågor');
    }

    public function next() {
        if ($this->quizIsDone()) {
            return $this->redirect(array('action' => 'results'));   
        }

        if ($this->request->is('post')) {
            $quiz = $this->Session->read('quiz');
            $index = $quiz['Quiz']['index'];

            $quiz[$index]['Question']['answer'] = null;
            $quiz[$index]['Question']['importance'] = null;

            if (isset($this->request->data['Quiz'])) {
                $answer = $this->request->data['Quiz']['answer'];
                $quiz[$index]['Question']['answer'] = ($answer === 'NO_OPINION' ? null : $answer);
                $quiz[$index]['Question']['importance'] = $this->request->data['Quiz']['importance'];
            }

            $index++;

            $quiz['Quiz']['index'] = $index;

            if ($quiz['Quiz']['index'] >= $quiz['Quiz']['questions']) {
                $quiz['Quiz']['done'] = true;
                $this->Session->write('quiz', $quiz);
                return $this->redirect(array('action' => 'results', $quiz['Quiz']['id']));    
            } else {
                $this->Session->write('quiz', $quiz);
                return $this->redirect(array('action' => 'questions'));
            }
        }
    }

    public function results($guid = null) {
        $quiz = $this->Session->read('quiz');

        if (empty($quiz) && empty($guid) || empty($guid)) {
            return $this->redirect(array('controller' => 'quiz','action' => 'index'));
        }

        $this->loadModel('QuizResult');
        $this->loadModel('Party');

        $quizResult = $this->QuizResult->findById($guid);
        $quiz = $this->Session->read('quiz');

        $ownQuiz = false;
        $data = null;

        if (isset($quiz['Quiz']) && $quiz['Quiz']['id'] == $guid) {
            $points = $this->Quiz->calculatePoints($quiz);
            $this->set('points', $points);
            $ownQuiz = true;

            $generatedData = $this->Quiz->generateGraphData($points['parties']);
            $data = json_encode($generatedData);
        }

        if (!empty($quizResult)) {
            $data = $quizResult['QuizResult']['data'];
        }

        if (empty($quizResult) && !empty($guid) && !empty($data)) {
            $this->QuizResult->save(array('id' => $guid, 'data' => $data));
        }

        $this->Party->recursive = -1;
        $parties = $this->Party->getPartiesHash();

        $this->set('data', $data);
        $this->set('parties', $parties);
        $this->set('ownQuiz', $ownQuiz);
        $this->set('title_for_layout', 'Resultat');
    }

    public function prev() {
        if ($this->quizIsDone()) {
            return $this->redirect(array('action' => 'results'));   
        }

        $quiz = $this->Session->read('quiz');
        $index = $quiz['Quiz']['index'];

        if ($index >= 0) {
            $index--;
            $quiz['Quiz']['index'] = $index;
            $this->Session->write('quiz', $quiz);
        }

        return $this->redirect(array('action' => 'questions'));
    }

    public function close() {
        $this->Session->delete('quiz');
        return $this->redirect(array('controller' => 'quiz','action' => 'index'));
    }

    public function restart() {
        $this->Session->delete('quiz');
        return $this->redirect(array('controller' => 'quiz','action' => 'questions'));
    }

    private function quizIsDone() {
        $quiz = $this->Session->read('quiz');
        return isset($quiz['Quiz']) && isset($quiz['Quiz']['done']) && $quiz['Quiz']['done'];
    }
    
    private function getCurrentAnswer($quiz, $index) {
        $answer = null;

        if (isset($quiz[$index]['Question']['answer'])) {
            $answer = $quiz[$index]['Question']['answer'];
        }

        return $answer;
    }

    private function getCurrentImportance($quiz, $index) {
        $importance = self::DEFAULT_IMPORTANCE;

        if (isset($quiz[$index]['Question']['importance'])) {
            $importance = $quiz[$index]['Question']['importance'];
        }

        return $importance;
    }
}

?>