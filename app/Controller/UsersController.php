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
        $this->Auth->loginError = "Fel användarnamn eller lösenord. Försök gärna igen.";  
        $this->Auth->authError = "Du har inte rättigheter att se denna sida.";
        $this->Auth->allow(array('login', 'logout', 'add'));
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
            $this->customFlash(__('Fel användarnamn eller lösenord.'), 'danger');
        }

        $this->currentPage = "login";
        $this->set('title_for_layout', 'Logga in');
    }
    
    public function logout() {
        $this->Auth->logout();
        return $this->redirect($this->referer());
    }
    
    public function index() {
        $this->set('users', $this->User->getAll());
        $this->set('title_for_layout', 'Användare');
    }

    public function start() {
        $this->set('title_for_layout', 'Start');
    }

    public function view($name = null) {
        if (!$name) {
            throw new NotFoundException("Ogiltig användare");
        }

        $user = $this->User->getByIdOrName($name);

        if (empty($user)) {
            throw new NotFoundException("Ogiltig användare");
        }
        
        $this->set('user', $user);
        $this->set('title_for_layout', $user['User']['username']);
        
        
    }
   
    public function add() {
        $this->request->data['User']['created_by'] = $this->Auth->loggedIn() ? $this->Auth->user('id') : 1 ;
        $this->request->data['User']['created_date'] = date("Y-m-d-H-i-s");
        $this->request->data['User']['role_id'] = $this->Auth->loggedIn() ? $this->request->data['User']['role_id'] : 4;
        
        if ($this->User->save($this->request->data )) {
            $this->customFlash(__('Användaren har skapats och väntar på att bli godkänd.'));

            if ($this->Auth->loggedIn()){
                $this->logUser('add', $this->User->getLastInsertId(), $this->request->data['User']['username']);           
            }

        } else {
            $this->customFlash(__('Kunde inte skapa användaren.'), 'danger');
            $this->Session->write('validationErrors', array('User' => $this->User->validationErrors, 'mode' => 'create'));
            $this->Session->write('formData', $this->data);
        }
        
        return $this->redirect($this->referer());
    }

    public function edit($id = null) {
        if (!$this->canEditUser) {
            $this->abuse("Not authorized to edit user with id " . $id);
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['User']['updated_by'] = $this->Auth->user('id');
            $this->request->data['User']['updated_date'] = date('c');
            $this->request->data['User']['approved'] = isset($this->request->data['User']['approved']) ? $this->request->data['User']['approved'] : false;

            // If no new password is set don't save a empty password
            if ($this->request->is('put') && !$this->request->data['User']['password']) {
                unset($this->request->data['User']['password']);    
                $this->User->validator()->remove('password');   
                $this->User->validator()->remove('username');  
                $this->User->validator()->remove('confirmPassword');
            }   

            if ($this->User->save($this->request->data)) {
                $this->customFlash(__('Användaren har sparats'));
                $this->logUser('edit', $this->request->data['User']['id']);
            } else {
                $this->customFlash(__('Användaren kunde inte sparas.'), 'danger'); 
                $this->Session->write('validationErrors', array('User' => $this->User->validationErrors, 'mode' => 'update'));
                $this->Session->write('formData', $this->data);
            }
            
            return $this->redirect($this->referer());
        }

        if (!$id) {
            throw new NotFoundException("Ogiltig användare");
        }

        $user = $this->User->getByIdOrName($id); 

        if (empty($user)) {
            throw new NotFoundException("Ogiltig användare");
        }

        if (!$this->request->data) {
            $this->request->data = $user;
        }
        
        $this->set('user', $user);

        $this->renderModal('saveUser', array(
            'setEdit' => true,
            'setModal' => true,
            'setAjax' => true,));
         
    }

    public function delete($id = null) {
        if (!$this->canDeleteUser) {
            $this->abuse("Not authorized to delete user with id " . $id);
            return $this->redirect($this->referer());
        }
        if ($this->request->is('post') || $this->request->is('put')){ 
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
        
        
        if (!$id) {
            throw new NotFoundException("Ogiltig användare");
        }
        
        $user = $this->User->getByIdOrName($id);
        if (empty($user)) {
            throw new NotFoundException("Ogiltig användare");
        }
        if (!$this->request->data) {
            $this->request->data = $user;
        }
        $this->set('user', $user);      
        $this->renderModal('deleteUserModal', array('setAjax' => true));
        
    }

    public function isAuthorized($user) {
        $role = $user['Role']['name'];
        if (($role == 'moderator' || $role == 'contributor' || $role == 'inactive') && in_array($this->action, array('start'))) {
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