<?php
/** 
 * Controller for managing parties
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

class PartiesController extends AppController {
    public $helpers = array('Html', 'Form');

    public $components = array('Session');

    public function beforeRender() {
        parent::beforeRender();
        $this->set("currentPage", "parties");
    }

    public function index() {
        $this->set('parties', $this->Party->getPartiesOrdered());
        $this->set('title_for_layout', 'Partier');
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

        if(!$this->isLoggedIn) {
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
    }

     public function add() {
        if (!$this->canAddParty) {
            $this->abuse("Not authorized to add party");
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
        if (!$this->canDeleteParty) {
            $this->abuse("Not authorized to delete party with id " . $id);
            return $this->redirect($this->referer());
        }

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

     public function all() {
        return $this->Party->getPartiesOrdered();
     }

     public function edit($id = null) {
        if (!$this->canEditParty) {
            $this->abuse("Not authorized to edit party with id " . $id);
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
            
            return $this->redirect($this->referer());
        }

        if (!$id) {
            throw new NotFoundException("Ogiltigt parti");
        }

        $party = $this->Party->getById($id);

        if (empty($party)) {
            throw new NotFoundException("Ogiltigt parti");
        }
        
        if (!$this->request->data) {
            $this->request->data = $party;
        }

        $this->set('party', $party);

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->set('edit', true);
            $this->set('modal', true);
            $this->set('ajax', true);
            $this->render('/Elements/saveParty');
        }
    }

    public function logUser($action, $object_id, $text = "") {
        UserLogger::write(array('model' => 'party', 'action' => $action,
                                'user_id' => $this->Auth->user('id'), 'object_id' => $object_id, 'text' => $text, 'ip' => $this->request->clientIp()));
    }
}

