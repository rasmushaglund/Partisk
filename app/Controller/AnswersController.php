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

class AnswersController extends AppController {
    public $helpers = array('Html', 'Form', 'Cache');
    public $cacheAction = array(
        "view" => "+999 days",
        "info" => "+999 days");
    
    public $components = array('Session');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('getNumberOfAnswers', 'getAnswersApi'));
    }
    
    public function beforeRender() {
        parent::beforeRender();
        $this->set("currentPage", "questions");
    }
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Ogiltigt svar'));
        }

    	$answer = $this->Answer->getById($id);
        
        if (!$answer) {
            throw new NotFoundException(__('Ogiltigt svar'));
        }
        
        $title = $answer['Question']['title'] . ": " . ucfirst($answer['Answer']['answer']) . " ("
                . ucfirst($answer['Party']['name']) . ")";

        $this->set('answer', $answer);
        $this->set('history', $answer['history']);
        $this->set('title_for_layout', $title);
        $this->set('description_for_layout', $title);
    }

    public function add() {
        if (!$this->Permissions->canAddAnswer()) {
            $this->Permissions->abuse("Not authorized to add answer");
            $this->customFlash("Du har inte tillåtelse att lägga till ett svar.");
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
                $this->Session->write('validationErrors', array('Answer' => $this->Answer->validationErrors, 'mode' => 'create'));
                $this->Session->write('formData', $this->data);
            }
        }

        return $this->redirect($this->referer());
    }

     public function edit($id = null) {
        if (empty($id)) {
            $id = $this->request->data['Answer']['id'];
        }
        
        if (!$this->Permissions->canEditAnswer($id)) {
            $this->Permissions->abuse("Not authorized to edit answer with id " . $id);
            $this->customFlash("Du har inte tillåtelse ändra svaret.");
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
                $this->Session->write('validationErrors', array('Answer' => $this->Question->validationErrors, 'mode' => 'update'));
                $this->Session->write('formData', $this->data);
            }

           return $this->redirect($this->referer());
        }

        if (!$id) {
            throw new NotFoundException("Ogiltigt svar");
        }
        
        $answer = $this->Answer->getById($id);

        if (empty($answer)) {
            throw new NotFoundException("Ogiltigt svar");
        }
        
        if (!$this->request->data) {
            $this->request->data = $answer;
        }

        $this->set('answer', $answer);

        $this->renderModal('saveAnswer', array(
            'setEdit' => true,
            'setModal' => true,
            'setAjax' => true,));
        
     }
     
     public function getNumberOfAnswers() {
        return $this->Answer->getNumberOfAnswers();
     }

     public function delete($id) {
       if (!$this->Permissions->canDeleteAnswer($id)) {
            $this->Permissions->abuse("Not authorized to delete answer with id ". $id);
            $this->customFlash("Du har inte tillåtelse att ta bort svar.");
            return $this->redirect($this->referer());
        }
        if ($this->request->is('post') || $this->request->is('put')) {
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
        
        if (!$id) {
            throw new NotFoundException("Ogiltigt svar");
        }

        $answer = $this->Answer->getById($id);
        if (empty($answer)) {
            throw new NotFoundException('Ogiltigt svar');
        }
        if (!$this->request->data) {
            $this->request->data = $answer;
        }
        $this->set('answer', $answer);
         
        $this->renderModal('deleteAnswerModal', array('setAjax' => true));
        
     }

    public function isAuthorized($user) {
        $role = $user['Role']['name'];

        if (in_array($role, array('moderator', 'contributor')) && in_array($this->action, array('edit', 'add', 'delete', 'status'))) {
            return true;
        }
        
        if ($role == 'inactive' && in_array($this->action, array('status'))) {
            return true;
        }

        return parent::isAuthorized($user);
    }
    
    public function getAnswersApi() {
        debug($this->Answer->getAnswers(array()));
        $this->renderJson($this->Answer->getAnswers(array())); 
        
    }
    
    public function info($id) {
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->set('answer', $this->Answer->getById($id));
            $this->render('/Elements/answerInfo');
        }
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