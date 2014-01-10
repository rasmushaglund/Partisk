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


class PartiesController extends AppController {
    public $helpers = array('Html', 'Form', 'Cache');
    public $cacheAction = array(
        "index" => "+999 days",
        "view" => "+999 days",
        "notAnswered" => "+999 days",
        "all" => "+999 days");

    public $components = array('Session');

    public function beforeRender() {
        parent::beforeRender();
        $this->set("currentPage", "parties");
    }
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('notAnswered'));
    }

    public function index() {
        $this->set('parties', $this->Party->getPartiesOrdered());
        $this->set('title_for_layout', 'Partier');
        $this->set('description_for_layout', 'Partier');
    }

    public function view($name = null) { 
        $name = $this->deSlugUrl($name);
        
        if (!$name) {
            throw new NotFoundException("Ogiltigt parti");
        }
       
        $party = $this->Party->getByIdOrName($name);

        if (empty($party)) {
            throw new NotFoundException("Ogiltigt parti");
        }
                    
        $conditions = array('deleted' => false);

        if(!$this->Permissions->isLoggedIn()) {
            $questions = $this->Party->Answer->Question->getVisibleQuestions();
        } else {
            $questions = $this->Party->Answer->Question->getLoggedInQuestions();
        }
                   
        $questionIds = array();

        foreach ($questions as $question) {
            array_push($questionIds, $question['Question']['id']);  
        }

        $party["Answer"] = $this->Party->Answer->getAnswers(array('partyId' => $party['Party']['id'], 'questionId' => $questionIds, 'includeParty' => true, 
                        'includeQuestion' => true));
            
        $this->set('party', $party);
        $this->set('title_for_layout', ucfirst($party['Party']['name']));
        $this->set('description_for_layout', ucfirst($party['Party']['name']));
    }
    
    public function notAnswered($name) {
        $name = $this->deSlugUrl($name);
        
        if (!$name) {
            throw new NotFoundException("Ogiltigt parti");
        }
       
        $party = $this->Party->getByIdOrName($name);

        if (empty($party)) {
            throw new NotFoundException("Ogiltigt parti");
        }
        
        $questions = $this->Party->Answer->Question->getNotAnswered($party['Party']['id']);  
        
        $this->set('questions', $questions);
        $this->set('party', $party);
        $this->set('title_for_layout', ucfirst($party['Party']['name']));
    }

     public function add() {
        if (!$this->Permissions->canAddParty()) {
            $this->Permissions->abuse("Not authorized to add party");
            $this->customFlash("Du har inte tillåtelse att lägga till ett parti.");
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post')) {
            $this->Party->create();
            $this->request->data['Party']['created_by'] = $this->Auth->user('id');
            $this->request->data['Party']['created_date'] = date('c');
            if ($this->Party->save($this->request->data)) {
                $this->customFlash(__('Partiet skapat.'));
                $this->logUser('add', $this->Party->getLastInsertId(), $this->request->data['Party']['name']);
            } else {
                $this->customFlash(__('Kunde inte skapa partiet.'), 'danger');
                $this->Session->write('validationErrors', array('Party' => $this->Party->validationErrors, 'mode' => 'create'));
                $this->Session->write('formData', $this->data);
            }

            return $this->redirect($this->referer());
        }
     }

     public function delete($id = null) {
        if (!$this->Permissions->canDeleteParty()) {
            $this->Permissions->abuse("Not authorized to delete party with id " . $id);
            $this->customFlash("Du har inte tillåtelse att ta bort ett parti.");
            return $this->redirect($this->referer());
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Party->set(
                array('id' => $id,
                      'deleted' => true,
                      'updated_by' => $this->Auth->user('id'),
                      'update_date' => date('c')));

            if ($this->Party->save()) {
                $this->customFlash(__('Tog bort partiet med id: %s.', h($id)));
                $this->logUser('delete', $id);
            } else {
                $this->customFlash(__('Kunde inte ta bort partiet.'), 'danger');
            }

            return $this->redirect($this->referer());
        }
        
        if (!$id) {
            throw new NotFoundException("Ogiltigt parti");
        }

        $party = $this->Party->getByIdOrName($id);
        
        if (empty($party)) {
            throw new NotFoundException("Ogiltigt parti");
        }
        if (!$this->request->data) {
            $this->request->data = $party;
        }
        $this->set('party', $party);  
             
        $this->renderModal('deletePartyModal', array('setAjax' => true));
     }

     public function all() {
        return $this->Party->getPartiesOrdered();
     }

     public function edit($id = null) {
        if (!$this->Permissions->canEditParty()) {
            $this->Permissions->abuse("Not authorized to edit party with id " . $id);
            $this->customFlash("Du har inte tillåtelse att ändra ett parti.");
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Party']['updated_by'] = $this->Auth->user('id');
            $this->request->data['Party']['updated_date'] = date('c');

            if ($this->Party->save($this->request->data)) {
                $this->customFlash(__('Partiet har sparats.'));
                $this->logUser('edit', $this->request->data['Party']['id']);
            } else {
                $this->customFlash(__('Partiet kunde inte sparas.'), 'danger'); 
                $this->Session->write('validationErrors', array('Party' => $this->Party->validationErrors, 'mode' => 'update'));
                $this->Session->write('formData', $this->data);
            }
            
            return $this->redirect(array('controller' => 'parties', 'action' => 'index'));
        }

        if (!$id) {
            throw new NotFoundException("Ogiltigt parti");
        }

        $party = $this->Party->getByIdOrName($id);

        if (empty($party)) {
            throw new NotFoundException("Ogiltigt parti");
        }
        
        if (!$this->request->data) {
            $this->request->data = $party;
        }

        $this->set('party', $party);
        
        $this->renderModal('saveParty', array(
            'setEdit' => true,
            'setModal' => true,
            'setAjax' => true,));
   
    }

    public function logUser($action, $object_id, $text = "") {
        UserLogger::write(array('model' => 'party', 'action' => $action,
                                'user_id' => $this->Auth->user('id'), 'object_id' => $object_id, 'text' => $text, 'ip' => $this->request->clientIp()));
    }
}

