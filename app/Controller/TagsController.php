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

class TagsController extends AppController {
    public $helpers = array('Html', 'Form', 'Cache', 'Permissions');
    public $cacheAction = array(
        "index" => "+999 days",
        "view" => "+999 days",
        "all" => "+999 days");

    public $components = array('Session');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('getIndexVars', 'getViewVars'));
    }

    public function beforeRender() {
        parent::beforeRender();
        $this->set("currentPage", "tags");
    }

    public function view($name = null) {
        if (!$name) {
            throw new NotFoundException("Ogiltig tagg");
        }

        $tag = $this->Tag->getByIdOrName($name);
        if (empty($tag)) {
            throw new NotFoundException("Ogiltig tagg");
        }

        if(!$this->Permissions->isLoggedIn()) {
             $questions = $this->Tag->Question->getVisibleTagQuestions($tag['Tag']['id']);
         } else {
             $questions = $this->Tag->Question->getLoggedInTagQuestions($tag['Tag']['id']);
         }
        
        $this->loadModel('Party');
        $parties = $this->Party->getPartiesOrdered();

        $this->loadModel('Answer');
        $answers = $this->Answer->getAnswers(array('tagId' => $tag['Tag']['id'], 'includeParty' => true));
        $answersMatrix = $this->Answer->getAnswersMatrix($questions, $answers);
        
        $this->set('tag', $tag);
        $this->set('questions', $questions);
        $this->set('parties', $parties);
        $this->set('answers', $answersMatrix);
        $this->set('description_for_layout', 'Frågor för taggen  ' . ucfirst($tag['Tag']['name']));
        $this->set('title_for_layout', ucfirst($tag['Tag']['name']));
    }

    public function index() {
        if(!$this->isLoggedIn) {
             $tags = $this->Tag->getAllApprovedTags();
        } else {
             $tags = $this->Tag->getAllTags();
        }
        
        $this->set('tags', $tags);
        $this->set('description_for_layout', 'Alla taggar');
        $this->set('title_for_layout', 'Taggar');
    }

    public function add() {
        if (!$this->Permissions->canAddTag()) {
            $this->Permissions->abuse("Not authorized to add tag");
            $this->customFlash("Du har inte tillåtelse att lägga till en tagg.");
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
        
        if (!$this->Permissions->canDeleteTag()) {
            $this->Permissions->abuse("Not authorized to delete tag with id " . $id);
            $this->customFlash("Du har inte tillåtelse att ta bort taggen.");
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
        
        $tag = $this->Tag->getByIdOrName($id);
        if (empty($tag)) {
            throw new NotFoundException("Ogiltig tagg");
        }
        if (!$this->request->data) {
            $this->request->data = $tag;
        }
        $this->set('tag', $tag);  
            
        $this->renderModal('deleteTagModal', array('setAjax' => true));
    }

     public function all() {
        return $this->Tag->getAllList();
     }

     public function edit($id = null) { 
        if (!$this->Permissions->canEditTag()) {
            $this->Permissions->abuse("Not authorized to edit tag with id " . $id);
            $this->customFlash("Du har inte tillåtelse att ändra taggen.");
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
            
            return $this->redirect(array('controller' => 'tags', 'action' => 'index'));
        }
        
        if (!$id) {
            throw new NotFoundException("Ogiltig tagg");
        }
        
        $tag = $this->Tag->getByIdOrName($id);

        if (empty($tag)) {
            throw new NotFoundException("Ogiltig kategori");
        }
        
        if (!$this->request->data) {
            $this->request->data = $tag;
        }

        $this->set('tag', $tag);

        $this->renderModal('saveTag', array(
            'setEdit' => true,
            'setModal' => true,
            'setAjax' => true,));
         
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