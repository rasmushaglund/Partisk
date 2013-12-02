<?php
/** 
 * Controller for managing answers
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

class AnswersController extends AppController {
    public $helpers = array('Html', 'Form');

    public $components = array('Session');

    public function beforeRender() {
        parent::beforeRender();
        $this->set("currentPage", "questions");
    }
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Ogiltigt svar'));
        }

    	$this->Answer->recursive = 1;
        $this->Answer->contain(array("CreatedBy", "UpdatedBy", 'ApprovedBy', 'Party', 'Question'));
        $answer = $this->Answer->findById($id);

        $this->Answer->Question->recursive = -1;
        $this->Answer->contain();
        $history = $this->Answer->find('all',array(
                'conditions' => array(
                    'Answer.deleted' => false,
                    'party_id' => $answer['Party']['id'],
                    'question_id' => $answer['Answer']['question_id']),
                'fields' => array('Answer.*'),
                'order' => 'Answer.date DESC'
            )
        );
        
        if (!$answer) {
            throw new NotFoundException(__('Ogiltigt svar'));
        }

        $this->set('answer', $answer);
        $this->set('history', $history);
        $this->set('title_for_layout', ucfirst($answer['Party']['name']) . " / " . $answer['Question']['title'] . " / " . 
            ucfirst($answer['Answer']['answer']));
    }

    public function add() {
        if (!$this->canAddAnswer) {
            $this->abuse("Not authorized to add answer");
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post')) {
            $this->Answer->create();
            $this->request->data['Answer']['created_by'] = $this->Auth->user('id');
            $this->request->data['Answer']['created_date'] = date('c');
            if ($this->Answer->save($this->request->data)) {
                $this->customFlash(__('Svaret skapat.'));
                $this->logUser('add', $this->Answer->getLastInsertId(), $this->request->data['Answer']['answer']);
            } else {
                $this->customFlash(__('Kunde inte skapa svaret.'), 'danger');
                $this->Session->write('validationErrors', array('Answer' => $this->Answer->validationErrors));
                $this->Session->write('formData', $this->data);
            }
        }

        return $this->redirect($this->referer());
    }

     public function edit($id = null) {
        if (empty($id)) {
            $id = $this->request->data['Answer']['id'];
        }

        if (!$this->userCanEditAnswer($this->Auth->user('id'), $id)) {
            $this->abuse("Not authorized to edit answer with id " . $id);
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Answer']['updated_by'] = $this->Auth->user('id');
            $this->request->data['Answer']['updated_date'] = date('c');
            
            if (isset($this->request->data['Answer']['approved'])) {
                $this->request->data['Answer']['approved'] = true;
                $this->request->data['Answer']['approved_by'] = $this->Auth->user('id');
                $this->request->data['Answer']['approved_date'] = date('c');
            } else {
                $this->request->data['Answer']['approved'] = false;
            }
            
            if ($this->Answer->save($this->request->data)) {
                $this->customFlash(__('Svaret har uppdaterats.'));
                $this->logUser('edit', $id);
            } else {
                $this->customFlash(__('Kunde inte uppdatera svaret.'), 'danger');
            }

           return $this->redirect($this->referer());
        }

        if (!$id) {
            throw new NotFoundException("Ogiltigt svar");
        }

        $answer = $this->Answer->findById($id);

        if (empty($answer)) {
            throw new NotFoundException("Ogiltigt svar");
        }
        
        if (!$this->request->data) {
            $this->request->data = $answer;
        }

        $this->Answer->recursive = 1;
        $this->Answer->Party->recursive = -1;
        $this->Answer->Question->recursive = -1;
        $this->set('answer', $answer);

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->set('edit', true);
            $this->set('modal', true);
            $this->set('ajax', true);
            $this->render('/Elements/saveAnswer');
        }
     }

     public function delete($id) {
        if (!$this->userCanDeleteAnswer($this->Auth->user('id'), $id)) {
            $this->abuse("Not authorized to delete answer with id ". $id);
            return $this->redirect($this->referer());
        }

        $this->Answer->set(
            array('id' => $id,
                  'deleted' => true,
                  'updated_by' => $this->Auth->user('id'),
                  'update_date' => date('c')));

        if ($this->Answer->save()) {
            $this->customFlash(__('Tog bort svaret med id: %s.', h($id)));
            $this->logUser('delete', $id);
        } else {
            $this->customFlash(__('Kunde inte ta bort svaret.'), 'danger');
        }

        return $this->redirect($this->referer());
     }

    public function isAuthorized($user) {
        $role = $user['Role']['name'];

        if (in_array($role, array('moderator', 'contributor')) && in_array($this->action, array('edit', 'add', 'delete', 'status'))) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    public function logUser($action, $object_id, $text = "") {
        UserLogger::write(array('model' => 'answer', 'action' => $action,
                                'user_id' => $this->Auth->user('id'), 'object_id' => $object_id, 'text' => $text, 'ip' => $this->request->clientIp()));
    }
    
    public function status() {
        $answers = $this->Answer->getUserAnswers($this->Auth->user('id'));
        $this->set('answers', $answers);
    }
}

?>