<?php
/** 
 * Controller for managing tags
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

class TagsController extends AppController {
    public $helpers = array('Html', 'Form');

    public $components = array('Session');

    public function beforeRender() {
        parent::beforeRender();
        $this->set("currentPage", "tags");
    }

    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException("Ogiltig tagg");
        }

        $tag = $this->Tag->getById($id);
        if (empty($tag)) {
            throw new NotFoundException("Ogiltig tagg");
        }

        //$conditions = array('deleted' => false, 'tagId' => $id);

        if(!$this->isLoggedIn) {
            //$conditions['approved'] = true;
            $questions = $this->Tag->Question->getVisibleTagQuestions($id);
        } else {
            $questions = $this->Tag->Question->getLoggedInTagQuestions($id);
        }

        //$questions = $this->Tag->Question->getQuestions($conditions);
        
        $this->loadModel('Party');
        $parties = $this->Party->getPartiesOrdered();

        $this->loadModel('Answer');
        $answers = $this->Answer->getAnswers(array('tagId' => $id, 'includeParty' => true));
        $answersMatrix = $this->Answer->getAnswersMatrix($questions, $answers);
        
        $this->set('tag', $tag);
        $this->set('questions', $questions);
        $this->set('parties', $parties);
        $this->set('answers', $answersMatrix);
        $this->set('title_for_layout', ucfirst($tag['Tag']['name']));
    }

    public function index() {
         if(!$this->isLoggedIn) {
            $tags = $this->Tag->getAllApprovedTags();
        } else {
            $tags = $this->Tag->getAllTags();
        }
        
        $this->set('tags', $tags);
        $this->set('title_for_layout', 'Taggar');
    }   

    public function add() {
        if (!$this->canAddTag) {
            $this->abuse("Not authorized to add tag");
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post')) {
            $this->Tag->create();
            $this->request->data['Tag']['created_by'] = $this->Auth->user('id');
            $this->request->data['Tag']['created_date'] = date('c');
            if ($this->Tag->save($this->request->data)) {
                $this->customFlash(__('Taggen är skapad.'));
                $this->logUser('add', $this->Tag->getLastInsertId(), $this->request->data['Tag']['name']);
            } else {
                $this->customFlash(__('Kunde inte skapa taggen.'), 'danger');        
                $this->Session->write('validationErrors', array('Tag' => $this->Tag->validationErrors, 'mode' => 'create'));
                $this->Session->write('formData', $this->data);
            }

            return $this->redirect($this->referer());
        }
    }

    public function delete($id) {
        
        if (!$this->canDeleteTag) {
            $this->abuse("Not authorized to delete tag with id " . $id);
            return $this->redirect($this->referer());
        }
        if ($this->request->is('post') || $this->request->is('put')){
            $this->Tag->set(
                array('id' => $id,
                      'deleted' => true,
                      'updated_by' => $this->Auth->user('id'),
                      'update_date' => date('c')));

            if ($this->Tag->save()) {
                $this->customFlash(__('Tog bort taggen med id: %s.', h($id)));
                $this->logUser('delete', $id);
            } else {
                $this->customFlash(__('Kunde inte ta bort taggen.'), 'danger');
            }

            return $this->redirect($this->referer());
        }
        
        
        if (!$id) {
            throw new NotFoundException("Ogiltig tagg");
        }
        
        $tag = $this->Tag->getById($id);
        
        
        $this->setModel($tag, 'tag');

        
        $this->renderModal('deleteTagModal', array('setAjax' => true));

        
        
    }

     public function all() {
        return $this->Tag->getAll();
     }

     public function edit($id = null) { 
        if (!$this->canEditTag) {
            $this->abuse("Not authorized to edit tag with id " . $id);
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Tag']['updated_by'] = $this->Auth->user('id');
            $this->request->data['Tag']['updated_date'] = date('c');
            if ($this->Tag->save($this->request->data)) {
                $this->customFlash(__('Taggen har sparats.'));
                $this->logUser('edit', $this->request->data['Tag']['id']);
            } else {
                $this->customFlash(__('Taggen kunde inte sparas.'), 'danger'); 
                $this->Session->write('validationErrors', array('Tag' => $this->Tag->validationErrors, 'mode' => 'update'));
                $this->Session->write('formData', $this->data);
            }
            
            return $this->redirect($this->referer());
        }
        
        if (!$id) {
            throw new NotFoundException("Ogiltig tagg");
        }
        
        $tag = $this->Tag->getById($id);

        if (empty($tag)) {
            throw new NotFoundException("Ogiltig kategori");
        }
        
        if (!$this->request->data) {
            $this->request->data = $tag;
        }

        $this->set('tag', $tag);

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->set('edit', true);
            $this->set('modal', true);
            $this->set('ajax', true);
            $this->render('/Elements/saveTag');
        }
    }

    public function isAuthorized($user) {
        $role = $user['Role']['name'];

        if ($role == 'moderator' && in_array($this->action, array('edit', 'add', 'delete'))) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    public function logUser($action, $object_id, $text = "") {
        UserLogger::write(array('model' => 'category', 'action' => $action,
                                'user_id' => $this->Auth->user('id'), 'object_id' => $object_id, 'text' => $text, 'ip' => $this->request->clientIp()));
    }
}

?>