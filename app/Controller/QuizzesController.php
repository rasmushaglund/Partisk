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
 * @package     app.Controller
 * @license     http://opensource.org/licenses/MIT MIT
 */

App::uses('AppController', 'Controller');
App::uses('UserLogger', 'Log');

class QuizzesController extends AppController {
    public $helpers = array('Html', 'Form', 'Cache');
    //public $cacheAction = array("results" => "+999 days");
    
    const DEFAULT_IMPORTANCE = 2;
    const QUIZ_VERSION = 2;

    public function beforeFilter() {
        parent::beforeFilter();
        $this->quizSession = $this->Session->read('quizSession');
        $this->Auth->allow(array('next', 'prev', 'results', 'close', 'questions' ,'restart', 'start', 'resume', 'getQuestionSummaryTable'));
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
        //$this->set('allQuiz', $this->Quiz->getAllQuiz());
        $this->set('description_for_layout', 'Testa dig själv. Vilket parti passar dig?');
        $this->set('title_for_layout', 'Quiz');
    }

    public function add() {
        if (!$this->Permissions->canAddQuiz()) {
            $this->Permissions->abuse("Not authorized to add quiz");
            $this->customFlash("Du har inte tillåtelse att lägga till en quiz.");
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
        if (!$this->Permissions->canDeleteQuiz($id)) {
            $this->Permissions->abuse("Not authorized to delete quiz with id " . $id);
            $this->customFlash("Du har inte tillåtelse att ta bort quizen.");
            return $this->redirect($this->referer());
        }
        if ($this->request->is('post') || $this->request->is('put')){ 
            $this->deleteQuiz($id);

            return $this->redirect($this->referer());
        }
        
        if (!$id) {
            throw new NotFoundException("Ogiltig quiz");
        }

        $quiz = $this->Quiz->getById($id);
        
        if (empty($quiz)) {
            throw new NotFoundException("Ogiltig quiz");
        }
        if (!$this->request->data) {
            $this->request->data = $quiz;
        }
        $this->set('quiz', $quiz);       
        $this->renderModal('deleteQuizModal', array('setAjax' => true));

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
        return $this->redirect("/quiz/fr%C3%A5gor");  
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
        
        $question = $this->Quiz->Question->getQuestionWithAnswers($quizSession[$index]['Question']['id']);
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
                $this->saveAnswers($quizSession);
                return $this->redirect(array('action' => 'results', $quizSession['QuizSession']['id']));    
            } else {
                $this->Session->write('quizSession', $quizSession);
		return $this->redirect("/quiz/fr%C3%A5gor");
            }
        } else {
            return $this->redirect(array('action' => 'index'));
        }
    }
    
    private function saveAnswers($session) {
        $tempQuizId = String::uuid();
        $answers = array();
        foreach ($session as $key => $question) {
            if (is_numeric($key)) {
                $answers[$key] = array(
                    "id" => String::uuid(),
                    "question_id" => $question['Question']['id'],
                    "answer" => $question['Question']['answer'],
                    "temp_quiz_id" => $tempQuizId,
                    "date" => date('Y-m-d'),
                    "importance" => $question['Question']['importance']
                );
            }
        }
        $this->loadModel('QuizAnswer');
        $this->QuizAnswer->saveAll($answers);
    }
    
    public function getQuestionSummaryTable($questionId) {
        $this->cacheAction = "+999 days";
        $this->layout = 'ajax';
        $this->autoRender=false;
        
        $quizSession = $this->quizSession;
        
        $this->loadModel('Party');
        
        $this->set('question', $quizSession['QuizSession']['points']['questions'][$questionId]);
        $this->set('parties', $this->Party->getPartiesHash());
        $this->render('/Elements/quizQuestionSummary');
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
        
        $winners = $this->getWinnersByResult($quizResults);
        
        $this->loadModel('Party');
        $parties = $this->Party->getPartiesHash();
        
        $this->set('quiz', $quiz);
        $this->set('guid', $guid);
        $this->set('quizSession', $quizSession);
        $this->set('quizResults', $quizResults);
        $this->set('parties', $parties);
        $this->set('winners', $winners);
        $this->set('description_for_layout', $this->getWinnersDescription($winners, $parties));
        $this->set('title_for_layout', 'Resultat');
    }
    
    private function getWinnersDescription($winners, $parties) {
        if (sizeof($winners) > 0) {
            $first = true;
            $result = "";
            
            foreach ($winners as $key => $value) {
                $party = ucfirst($parties[$key]['name']);
                if ($first) {
                    $first = false;
                } else {
                    $result .= ", ";
                }
                
                $result .= $party . ": " . $value . "%";
                
            }
            return $result;
        } else {
            return "Baserat på dina svar matchar du inget parti :(";
        }
    }
    
    private function getWinnersByResult($result) {
        $data = json_decode($result['QuizResult']['data']);
        
        $results = array();
        foreach ($data->points_percentage as $key => $value) {
            if ($value->result > 0) {
                $results[$key] = $value->result;
            }
        }
        arsort($results);
        return $results;
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

        //return $this->redirect(array('action' => 'questions'));
	return $this->redirect("/quiz/fr%C3%A5gor");
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
        $availableQuestions = $this->Quiz->Question->getAvailableQuizQuestions($id);
        $this->set('questions', $questions);
        $this->set('quiz', $this->Quiz->getById($id));
        $this->set('availableQuestions', $availableQuestions);
    }

    public function overview() {
        $this->loadModel('QuizResult');
        $this->set('results', $this->QuizResult->getQuizResults());
    }

    public function addQuestion() {
        if (!$this->Permissions->canEditQuiz()) {
            $this->Permissions->abuse("Not authorized to edit quiz");
            $this->customFlash("Du har inte tillåtelse att lägga till en fråga till quizen.");
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
            
            Cache::clear(false, 'quiz');
            Cache::clear(false, 'question');

            return $this->redirect($this->referer());
        }
    }
    
    public function edit($id = null) {
        if (!$this->Permissions->canEditQuiz($id)) {
            $this->Permissions->abuse("Not authorized to edit quiz with id " . $id);
            $this->customFlash("Du har inte tillåtelse att ändra quizen.");
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->saveQuiz($this->request->data);
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

        $this->renderModal('saveQuiz', array(
            'setEdit' => true,
            'setModal' => true,
            'setAjax' => true,));

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

    public function deleteQuestion($id = null) {
        if (!$this->Permissions->canEditQuiz()) {
            $this->Permissions->abuse("Not authorized to delete relation between question and quiz with id " . $id);
            $this->customFlash("Du har inte tillåtelse att ta bort frågor i denna quiz.");
            return $this->redirect($this->referer());
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->loadModel('QuestionQuiz');

            if ($this->QuestionQuiz->delete($id)) {
                $this->customFlash(__('Tog bort frågan i quizen med id: %s.', h($id)));
                $this->logUser('delete', $id);
            } else {
                $this->customFlash(__('Kunde inte ta bort frågan som hör till quizen.'), 'danger');
            }
            
            Cache::clear(false, 'quiz');
            Cache::clear(false, 'question');
            return $this->redirect($this->referer());
        }
        
        if (!$id) {
            throw new NotFoundException("Ogiltig quiz");
        }
        
        $this->set('quizQuestion', $id);  
        
        $this->renderModal('deleteQuizQuestionModal', array('setAjax' => true));
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