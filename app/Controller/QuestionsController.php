<?php
/** 
 * Controller for managing questions
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
App::uses('AppController', 'Controller');
App::uses('UserLogger', 'Log');

class QuestionsController extends AppController {
    public $helpers = array('Html', 'Form');

    public $components = array('Session');

    public function beforeRender() {
        parent::beforeRender();
        $this->set("currentPage", "questions");
    }

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
        $this->loadModel('Party');
        $this->loadModel('Answer');

        $conditions = array('deleted' => false);

        if(!$this->isLoggedIn) {
            $conditions['approved'] = true;
        }   

        $questions = $this->Question->getQuestions($conditions);
        $parties = $this->Party->getPartiesOrdered();
        
        $questionIds = $this->Question->getIdsFromModel('Question', $questions);
        $partyIds = $this->Party->getIdsFromModel('Party', $parties);

        $answers = $this->Answer->getAnswers(array('partyId' => $partyIds, 'questionId' => $questionIds));
        $answersMatrix = $this->Answer->getAnswersMatrix($questions, $answers);
        
        $this->set('questions', $questions);
        $this->set('parties', $parties);
        $this->set('answers', $answersMatrix);
        $this->set('title_for_layout', 'Frågor');
    }

    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Ogiltig fråga'));
        }

        $question = $this->Question->getQuestionById($id);

        if (empty($question)) {
            throw new NotFoundException("Ogiltig fråga");
        }

        $answers = $this->Question->Answer->getAnswers(array('questionId' => $id, 'includeParty' => true));

        $this->set('question', $question);
        $this->set('answers', $answers);
        $this->set('title_for_layout', ucfirst($question['Question']['title']));
     }

     public function add() {
        if (!$this->canAddQuestion) {
            $this->abuse("Not authorized to add question");
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post')) {
            $this->createQuestion($this->request->data);
            return $this->redirect($this->referer());
        }
     }

     public function delete($id) {
        if (!$this->userCanDeleteQuestion($this->Auth->user('id'), $id)) {
            $this->abuse("Not authorized to delete question with id " . $id);
            return $this->redirect($this->referer());
        }

        $this->deleteQuestion($id);

        return $this->redirect($this->referer());
     }

     public function edit($id = null) {
        if (!$this->userCanEditQuestion($this->Auth->user('id'), $id)) {
            $this->abuse("Not authorized to edit question with id " . $id);
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->saveQuestion($this->request->data);
            return $this->redirect($this->referer());
        } 

        if (!$id) {
            throw new NotFoundException("Ogiltig fråga");
        }

        $question = $this->Question->getQuestionById($id);

        if (empty($question)) {
            throw new NotFoundException("Ogiltig fråga");
        }

        $question['Question']['tags'] = $this->Question->Tag->getTagStringByQuestionid($id);

        $this->set('question', $question);

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->set('edit', true);
            $this->set('modal', true);
            $this->set('ajax', true);
            $this->render('/Elements/saveQuestion');
        }
    }

    public function all() {
        return $this->Question->getAllQuestionsList();
    }

    public function isAuthorized($user) {
        $role = $user['Role']['name'];

        if ($role == 'moderator' && in_array($this->action, array('edit', 'add', 'delete'))) {
            return true;
        }

        if ($role == 'contributor' && in_array($this->action, array('edit', 'add', 'delete'))) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    private function createQuestion($data) {
        $this->Question->create();
        $data['Question']['created_by'] = $this->Auth->user('id');
        $data['Question']['created_date'] = date('c');
        $data['Question']['type'] = "YESNO";

        if ($this->Question->save($data)) {
            $this->addTags($data, $this->Question->getLastInsertId());
            $this->customFlash(__('Frågan skapad.'));
            $this->logUser('add', $this->Question->getLastInsertId(), $data['Question']['title']);
        } else {
            $this->customFlash(__('Kunde inte skapa frågan.'), 'danger');
            $this->Session->write('validationErrors', array('Question' => $this->Question->validationErrors));
            $this->Session->write('formData', $this->data);
        }
    }

    private function saveQuestion($data) {
        $id = $data['Question']['id'];
        $this->Question->Tag->addTags($data, $id);

        $data['Question']['updated_by'] = $this->Auth->user('id');
        $data['Question']['updated_date'] = date('c');

        if (isset($data['Question']['approved'])) {
            $data['Question']['approved'] = true;
            $data['Question']['approved_by'] = $this->Auth->user('id');
            $data['Question']['approved_date'] = date('c');
        } else {
            $data['Question']['approved'] = false;
        }

        if ($this->Question->save($data)) {
            $this->customFlash(__('Frågan har uppdaterats.'));
            $this->logUser('edit', $id);
        } else {
            $this->customFlash(__('Kunde inte uppdatera frågan.'), 'danger');
            $this->Session->write('validationErrors', array('Question' => $this->Question->validationErrors));
            $this->Session->write('formData', $this->data);
        }
    }

    private function deleteQuestion($id) {
        $this->Question->set(
            array('id' => $id,
                  'deleted' => true,
                  'updated_by' => $this->Auth->user('id'),
                  'update_date' => date('c')));

        if ($this->Question->save()) {
            $this->customFlash(__('Tog bort frågan med id: %s.', h($id)));
            $this->logUser('delete', $id);
        } else {
            $this->customFlash(__('Kunde inte ta bort frågan.'), 'danger');
        }
    }

    public function logUser($action, $object_id, $text = "") {
        UserLogger::write(array('model' => 'question', 'action' => $action,
                                'user_id' => $this->Auth->user('id'), 'object_id' => $object_id, 'text' => $text, 'ip' => $this->request->clientIp()));
    }
}

?>