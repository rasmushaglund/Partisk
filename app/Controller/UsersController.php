<?php
/** 
 * Controller for managing users
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

class UsersController extends AppController {

    private $currentPage = "users";

    public $components = array('Auth', 'Session');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('login', 'logout'));
    }

    public function beforeRender() {
        parent::beforeRender();
        $this->set("currentPage", $this->currentPage);
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect(array('controller'=>'users', 'action'=>'start'));
            }

            CakeLog::write('abuse', $this->request->clientIp() . ' - Wrong password for user ' . $this->request->data['User']['username']);
            $this->Session->setFlash(__('Invalid username or password, try again'));
        }

        $this->currentPage = "login";
        $this->set('title_for_layout', 'Logga in');
    }
    
    public function logout() {
        $this->Auth->logout();
        return $this->redirect(array('controller'=>'pages', 'action'=>'index'));
    }
    
    public function index() {
        $this->User->recursive = -1;
        $users = $this->User->find('all', array(
            'conditions' => array('deleted' => false),
            'order' => array('username')
        ));
        $this->set('users', $users);

        $this->set('title_for_layout', 'Användare');
    }

    public function start() {
        $this->set('title_for_layout', 'Start');
    }

    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException("Ogiltig användare");
        }

        $this->User->recursive = -1;
        $this->User->contain(array("CreatedBy", "UpdatedBy"));
        $user = $this->User->findById($id);

        if (empty($user)) {
            throw new NotFoundException("Ogiltig användare");
        }

        $this->set('user', $user);
        $this->set('title_for_layout', $user['User']['username']);
    }

    public function add() {
        if (!$this->canAddUser) {
            $this->abuse("Not authorized to add user");
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post')) {
            $this->User->create();
            $this->request->data['User']['created_by'] = $this->Auth->user('id');
            $this->request->data['User']['created_date'] = date('c');
            if ($this->User->save($this->request->data)) {
                $this->customFlash(__('Användaren har skapats.'));
                $this->logUser('add', $this->User->getLastInsertId(), $this->request->data['User']['username']);
            } else {
                $this->customFlash(__('Kunde inte skapa användaren.'), 'danger');
                $this->Session->write('validationErrors', $this->User->validationErrors);
            }

            return $this->redirect($this->referer());
        }
    }

    public function edit($id = null) {
        if (!$this->canEditUser) {
            $this->abuse("Not authorized to edit user with id " . $id);
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['User']['updated_by'] = $this->Auth->user('id');
            $this->request->data['User']['updated_date'] = date('c');

            if ($this->request->is('put') && !$this->request->data['User']['password']) {
                unset($this->request->data['User']['password']);    
            }

            if ($this->User->save($this->request->data)) {
                $this->customFlash(__('Användaren har sparats.'));
                $this->logUser('edit', $this->request->data['User']['id']);
            } else {
                $this->customFlash(__('Användaren kunde inte sparas.')); 
                $this->Session->write('validationErrors', $this->User->validationErrors);
            }
            
            return $this->redirect($this->referer());
        }

        if (!$id) {
            throw new NotFoundException("Ogiltig användare");
        }

        $this->User->recursive = -1;
        $this->User->contain('Role');
        $user = $this->User->findById($id);

        if (empty($user)) {
            throw new NotFoundException("Ogiltig användare");
        }

        if (!$this->request->data) {
            $this->request->data = $user;
        }

        $this->User->recursive = -1;
        $this->set('user', $user);

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->set('edit', true);
            $this->set('modal', true);
            $this->set('ajax', true);
            $this->render('/Elements/saveUser');
        }
    }

    public function delete($object_id) {
        if (!$this->canDeleteUser) {
            $this->abuse("Not authorized to delete user with id " . $id);
            return $this->redirect($this->referer());
        }

        $this->User->set(
            array('id' => $id,
                  'deleted' => true,
                  'updated_by' => $this->Auth->user('id'),
                  'update_date' => date('c')));

        if ($this->User->save()) {
            $this->customFlash(__('Tog bort användaren med id: %s.', h($id)));
            $this->logUser('delete', $id);
        } else {
            $this->customFlash(__('Kunde inte ta bort användaren.'), 'danger');
        }

        return $this->redirect($this->referer());
    }

    public function isAuthorized($user) {
        $role = $user['Role']['name'];

        if ($role == 'moderator' && in_array($this->action, array('start'))) {
            return true;
        }

        if ($role == 'contributor' && in_array($this->action, array('start'))) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    public function logUser($action, $object_id, $text = "") {
        UserLogger::write(array('model' => 'user', 'action' => $action,
                                'user_id' => $this->Auth->user('id'), 'object_id' => $object_id, 'text' => $text, 'ip' => $this->request->clientIp()));
    }
}
?>