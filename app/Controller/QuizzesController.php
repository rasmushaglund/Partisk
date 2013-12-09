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

App::uses('UserLogger', 'Log');

class QuizzesController extends AppController {
    public $helpers = array('Html', 'Form');

    const DEFAULT_IMPORTANCE = 2;
    const QUIZ_VERSION = 2;

    public function beforeFilter() {
        parent::beforeFilter();
        $this->quizSession = $this->Session->read('quizSession');
        $this->Auth->allow(array('next', 'prev', 'results', 'close', 'questions' ,'restart', 'start', 'resume'));
    }

    public function beforeRender() {
        parent::beforeRender();
        $this->set("currentPage", "quiz");
    }

    public function index() {
        if(!$this->Auth->loggedIn()) {
            $quizzes = $this->Quiz->getVisibleQuizzes();
        } else {
            $quizzes = $this->Quiz->getLoggedInQuizzes();
        } 
        
        if (!empty($quiz)) {
            $this->set('quizId', $quiz['Quiz']['id']);
        }
        
        $this->set('quizSession', $this->quizSession);
        $this->set('quizzes', $quizzes);
        $this->set('quizIsDone', $this->quizIsDone());
        $this->set('allQuiz', $this->Quiz->getAllQuiz());
        $this->set('title_for_layout', 'Quiz');
    }

    public function add() {
        if (!$this->canAddQuiz) {
            $this->abuse("Not authorized to add quiz");
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post')) {
            $this->createQuiz($this->request->data);
        }
    }

    private function createQuiz($data) {
        $this->Quiz->create();
        $data['Quiz']['created_by'] = $this->Auth->user('id');
        $data['Quiz']['created_date'] = date('c');
        
        if ($this->Quiz->save($data)) {
            $this->customFlash(__('Quizen har skapats.'));
            $this->logUser('add', $this->Quiz->getLastInsertId(), $data['Quiz']['name']);
        } else {
            $this->customFlash(__('Kunde inte skapa quizen.'), 'danger');            
            $this->Session->write('validationErrors', array('Quiz' => $this->Quiz->validationErrors, 'mode' => 'create'));
            $this->Session->write('formData', $this->data);
        }

        return $this->redirect($this->referer());
    }
    
    public function delete($id) {
        if (!$this->userCanDeleteQuiz($this->Auth->user('id'), $id)) {
            $this->abuse("Not authorized to delete quiz with id " . $id);
            return $this->redirect($this->referer());
        }

        $this->deleteQuiz($id);

        return $this->redirect($this->referer());
     }

    private function deleteQuiz($id) {
        $this->Quiz->set(
            array('id' => $id,
                  'deleted' => true,
                  'updated_by' => $this->Auth->user('id'),
                  'update_date' => date('c')));

        if ($this->Quiz->save()) {
            $this->customFlash(__('Tog bort quizzen med id: %s.', h($id)));
            $this->logUser('delete', $id);
        } else {
            $this->customFlash(__('Kunde inte ta bort Quizen.'), 'danger');
        }
    }

    public function start($id) {
        $quizSession = $this->Quiz->generateQuizSession($id);
        $this->Session->write('quizSession', $quizSession);
        return $this->redirect(array('action' => 'questions'));  
    }

    public function resume($id) {
        $quizSession = $this->quizSession;
        $ableToResumeQuiz = isset($quizSession['QuizSession']) && $quizSession['QuizSession']['quiz_id'] === $id;
        if ($ableToResumeQuiz) {
            return $this->redirect(array('action' => 'questions'));
        } else {
            $this->customFlash(__('Kunde inte fortsätta quizen.'), 'danger');
            return $this->redirect(array('action' => 'index'));      
        }
    }

    public function questions() {
        if ($this->quizIsDone()) {
            return $this->redirect(array('action' => 'results'));   
        }

        $quizSession = $this->quizSession;
        $index = $quizSession['QuizSession']['index'];

        $question = $this->Quiz->Question->getQuestion(array('id' => $quizSession[$index]['Question']['id']));
        $choices = $this->Quiz->Question->getChoicesFromQuestion($question);
        
        $answer = $this->getCurrentAnswer($quizSession, $index);
        $importance = $this->getCurrentImportance($quizSession, $index);
        
        $this->set('question', $question);
        $this->set('answer', $answer);
        $this->set('importance', $importance);
        $this->set('choices', $choices);
        $this->set('quizSession', $quizSession);
        $this->set('title_for_layout', 'Quiz');
    }

    public function next() {
        if ($this->quizIsDone()) {
            return $this->redirect(array('action' => 'results'));   
        }

        if ($this->request->is('post')) {
            $quizSession = $this->quizSession;
            $index = $quizSession['QuizSession']['index'];

            $quizSession[$index]['Question'] = $this->attachQuestionData($this->request->data, 
                                                                  $quizSession[$index]['Question']);
                                                   
            $index++;
            $quizSession['QuizSession']['index'] = $index;
            $quizSession['QuizSession']['has_answers'] = 
                    $quizSession['QuizSession']['has_answers'] || 
                    $this->request->data['QuizSession']['answer'] !== 'NO_OPINION';
            
            if ($quizSession['QuizSession']['index'] >= $quizSession['QuizSession']['questions']) {
                $quizSession['QuizSession']['done'] = true;
                $quizSession['QuizSession']['saved'] = false;
                $this->Session->write('quizSession', $quizSession);
                return $this->redirect(array('action' => 'results', $quizSession['QuizSession']['id']));    
            } else {
                $this->Session->write('quizSession', $quizSession);
                return $this->redirect(array('action' => 'questions'));
            }
        } else {
            return $this->redirect(array('action' => 'index'));
        }
    }
    
    private function attachQuestionData($data, $question) {
        $question['answer'] = null;
        $question['importance'] = null;

        if (isset($data['QuizSession'])) {
            $answer = $data['QuizSession']['answer'];
            $question['answer'] = ($answer === 'NO_OPINION' ? null : $answer);
            $question['importance'] = $data['QuizSession']['importance'];
        }
        
        return $question;
    }

    public function results($guid = null) {
        $quizSession = $this->getQuizSession($guid);
        
        if (empty($quizSession) && empty($guid) || empty($guid)) {
            return $this->redirect(array('controller' => 'quizzes','action' => 'index'));
        }
        
        if (!empty($quizSession) && isset($quizSession['QuizSession']['has_answers']) &&
                !$quizSession['QuizSession']['has_answers']) {
            $this->Session->delete('quizSession');
            $this->customFlash(__('Du har inte svarat på någon fråga i quizen, försök igen.'), 'danger');
            return $this->redirect(array('action' => 'index'));      
        }
      
        if (!empty($quizSession) && $quizSession['QuizSession']['done'] && !$quizSession['QuizSession']['saved']) {
            $quizResults = $this->getNewQuizResults($guid, $quizSession);
            $quizResults['QuizResult']['data'] = $quizSession['QuizSession']['data'];
            $quizSession['QuizSession']['saved'] = true;
            $this->Session->write('quizSession', $quizSession);
            $quiz = $this->getQuiz($quizSession);
        } else {
            $quizResults = $this->getQuizResults($guid);
            $quiz = $quizResults;
        }
        
        if (empty($quizResults) && empty($quizResults)) {
            $this->customFlash(__('Kunde inte hitta quizen.'), 'danger');
            return $this->redirect(array('controller' => 'quizzes','action' => 'index'));
        }

        if (intval($quizResults['QuizResult']['version']) !== intval(self::QUIZ_VERSION)) {
            $this->customFlash(__('Denna Quiz är inte längre tillgänglig på grund av att poängsystemet ändrat så pass mycket sedan 
                                   resultatet genererades. Gör gärna om testet igen för att få ett nytt resultat.
                                   Vi ber om ursäkt för besväret. Sidan är fortfarande under kraftig uppbygnad och vi gör snabbt ändringar
                                   för att förbättra sidan med den feedback vi får in.'), 'danger');
            return $this->redirect(array('controller' => 'quizzes','action' => 'index'));
        }
        
        $this->loadModel('Party');
        $parties = $this->Party->getPartiesHash();
        
        $this->set('quiz', $quiz);
        $this->set('quizSession', $quizSession);
        $this->set('quizResults', $quizResults);
        $this->set('parties', $parties);
        $this->set('title_for_layout', 'Resultat');
    }
    
    private function getQuiz($quizSession) {
        $this->Quiz->recursive = -1;

        if ($quizSession['QuizSession']['quiz_id'] === 'all') {
            $quiz = $this->Quiz->getAllQuiz();
        } else {
            $quiz = $this->Quiz->findById($quizSession['QuizSession']['quiz_id']);
        }
        
        return $quiz;
    }
    
    private function getQuizSession($guid) {
        $quizSession = $this->quizSession;
        $quizInSession = isset($quizSession['QuizSession']) && isset($quizSession['QuizSession']['id'])
                && $quizSession['QuizSession']['id'] == $guid;
        
        if ($quizInSession) {
            $points = $this->Quiz->calculatePoints($quizSession);
            $quizSession['QuizSession']['points'] = $points;

            $generatedData = $this->Quiz->generateGraphData($points['parties']);
            $quizSession['QuizSession']['data'] = json_encode($generatedData);
            
            return $quizSession;
        }
        
    }
    
    private function getQuizResults($guid) {
        $this->loadModel('QuizResult');
        return $this->QuizResult->getById($guid);
    }
    
    private function getNewQuizResults($guid, $quizSession) {
        $this->loadModel('QuizResult');
        $this->QuizResult->save(array('id' => $guid, 'data' => $quizSession['QuizSession']['data'], 
                                      'version' => self::QUIZ_VERSION,
                                      'quiz_id' => $quizSession['QuizSession']['quiz_id']));
        $quizResults = array();
        $quizResults['QuizResult'] = array('version' => self::QUIZ_VERSION,
                                           'created' => date('c'));
        
        return $quizResults;
    }

    public function prev() {
        if ($this->quizIsDone()) {
            return $this->redirect(array('action' => 'results'));   
        }

        $index = $this->quizSession['QuizSession']['index'];

        if ($index >= 0) {
            $index--;
            $this->quizSession['QuizSession']['index'] = $index;
            $this->Session->write('quizSession', $this->quizSession);
        }

        return $this->redirect(array('action' => 'questions'));
    }

    public function close() {
        $this->Session->delete('quizSession');
        return $this->redirect(array('controller' => 'quizzes','action' => 'index'));
    }

    public function restart($id) {
        $this->Session->delete('quizSession');
        return $this->redirect(array('controller' => 'quizzes','action' => 'start', $id));
    }

    private function quizIsDone($id = null) {
        $quizSession = $this->quizSession;
        return isset($quizSession['QuizSession']) && isset($quizSession['QuizSession']['done']) && 
            $quizSession['QuizSession']['done'] && $id == null || $quizSession['QuizSession']['id'] == $id;
    }
    
    private function getCurrentAnswer($quizSession, $index) {
        $answer = null;

        if (isset($quizSession[$index]['Question']['answer'])) {
            $answer = $quizSession[$index]['Question']['answer'];
        }

        return $answer;
    }

    private function getCurrentImportance($quizSession, $index) {
        $importance = self::DEFAULT_IMPORTANCE;

        if (isset($quizSession[$index]['Question']['importance'])) {
            $importance = $quizSession[$index]['Question']['importance'];
        }

        return $importance;
    }

    public function admin($id) {
        $this->Quiz->recursive = -1;
        $questions = $this->Quiz->Question->getQuestionsByQuizId($id);
        $this->set('questions', $questions);
        $this->set('quiz', $this->Quiz->getById($id));
    }

    public function overview() {
        $this->loadModel('QuizResult');
        $this->set('results', $this->QuizResult->getQuizResults());
    }

    // TODO: remove the nasty conversion from Quiz to QuestionQuiz
    // TODO: Log something meaninful in logUser
    public function addQuestion() {
        if (!$this->canEditQuiz) {
            $this->abuse("Not authorized to edit quiz");
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post')) {
            $this->loadModel('QuestionQuiz');
            $this->QuestionQuiz->create();
            $data = array();
            $data['QuestionQuiz'] = $this->request->data['Quiz'];
            if ($this->QuestionQuiz->save($data)) {
                $this->customFlash(__('Frågan har lagts till i quizen.'));
                $this->logUser('add', $this->QuestionQuiz->getLastInsertId(), "");
            } else {
                $this->customFlash(__('Kunde inte lägga till frågan till quizen.'), 'danger');
                $this->Session->write('validationErrors', $this->QuestionQuiz->validationErrors);
                $this->Session->write('formData', $this->data);
            }

            return $this->redirect($this->referer());
        }
    }
    
    public function edit($id = null) {
        if (!$this->userCanEditQuiz($this->Auth->user('id'), $id)) {
            $this->abuse("Not authorized to edit quiz with id " . $id);
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->saveQuiz($this->request->data)) {
                $this->customFlash(__('Quizzen har sparats.'));
                $this->logUser('edit', $this->request->data['Quiz']['id']);
            } else {
                $this->customFlash(__('Quizzen kunde inte sparas.'), 'danger'); 
                $this->Session->write('validationErrors', array('Quiz' => $this->Quiz->validationErrors, 'mode' => 'update'));
                $this->Session->write('formData', $this->data);   
            }
            return $this->redirect($this->referer());
        } 

        if (!$id) {
            throw new NotFoundException("Ogiltig quiz");
        }

        $quiz = $this->Quiz->getById($id);

        if (empty($quiz)) {
            throw new NotFoundException("Ogiltig quiz");
        }

        $this->set('quiz', $quiz);

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->set('edit', true);
            $this->set('modal', true);
            $this->set('ajax', true);
            $this->render('/Elements/saveQuiz');
        }
    }

    private function saveQuiz($data) {
        $id = $data['Quiz']['id'];

        $data['Quiz']['updated_by'] = $this->Auth->user('id');
        $data['Quiz']['updated_date'] = date('c');

        if (isset($data['Quiz']['approved'])) {
            $data['Quiz']['approved'] = true;
            $data['Quiz']['approved_by'] = $this->Auth->user('id');
            $data['Quiz']['approved_date'] = date('c');
        } else {
            $data['Quiz']['approved'] = false;
        }

        if ($this->Quiz->save($data)) {
            $this->customFlash(__('Quizen har uppdaterats.'));
            $this->logUser('edit', $id);
        } else {
            $this->customFlash(__('Kunde inte uppdatera quizen.'), 'danger');            
            $this->Session->write('validationErrors', array('Quiz' => $this->Quiz->validationErrors));
            $this->Session->write('formData', $this->data);
        }
    }

    public function deleteQuestion($id) {
        if (!$this->canEditQuiz) {
            $this->abuse("Not authorized to delete relation between question and quiz with id " . $id);
            return $this->redirect($this->referer());
        }

        $this->loadModel('QuestionQuiz');

        if ($this->QuestionQuiz->delete($id)) {
            $this->customFlash(__('Tog bort frågan i quizen med id: %s.', h($id)));
            $this->logUser('delete', $id);
        } else {
            $this->customFlash(__('Kunde inte ta bort frågan som hör till quizen.'), 'danger');
        }

        return $this->redirect($this->referer());
    }

    public function isAuthorized($user) {
        $role = $user['Role']['name'];

        if ($role == 'moderator' && in_array($this->action, array('admin', 'deleteQuestion', 'addQuestion', 'add', 'delete', 'status'))) {
            return true;
        }
        
        if ($role == 'contributor' && in_array($this->action, array('status'))) {
            return true;
        }
        
        if ($role == 'inactive' && in_array($this->action, array('status'))) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    public function logUser($action, $object_id, $text = "") {
        UserLogger::write(array('model' => 'quiz', 'action' => $action,
                                'user_id' => $this->Auth->user('id'), 'object_id' => $object_id, 'text' => $text, 'ip' => $this->request->clientIp()));
    }
    
    public function status() {
        $this->set('quizzes', $this->Quiz->getUserQuizzes($this->Auth->user('id')));
    }
}

?>