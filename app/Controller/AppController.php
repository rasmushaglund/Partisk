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

App::uses('Permissions', 'Utils');
App::uses('Url', 'Utils');

class AppController extends Controller {
    public $helpers = array('Session', 'Permissions', 'Url');

    public $components = array(
        'Session',
        'Auth'
    );

    protected $Permissions; 
    
    public function beforeFilter() {
        // Enable Blowfish hashing with salt
        $this->Auth->authenticate = array(
            AuthComponent::ALL => array(
                'userModel' => 'User',
                'scope' => array(
                        'User.approved' => 1,
                        'User.deleted' => 0
                )
            ),
            'Blowfish'
        );

        $this->Auth->authorize = 'Controller';
        $this->Auth->allow(array('index', 'view', 'all', '/', 'info'));
        $this->set("currentPage", "default");
        $this->set("description_for_layout", "");
        
        $this->Permissions = new Permissions();
        $this->Url = new Url();
    }
    
    public function isAuthorized($user) {
        $role = $user['Role']['name'];

        if ($role === 'admin') {
            return true;
        }

        $this->Permissions->abuse("Not authorized to access view");
        $this->customFlash("Du har inte tillåtelse att se denna sida.");

        if ($this->request->is('ajax')) {
            die;
        }
        
        return false;
    }

    public function beforeRender() {
        if ($this->Session->check('validationErrors')) {
            $this->set('validationErrors', $this->Session->read('validationErrors'));
            $this->Session->delete('validationErrors');
        }
        
        if ($this->Session->check('formData')) {
            $this->set('formData', $this->Session->read('formData'));
            $this->Session->delete('formData');
        }
    }
    
    public function customFlash($message, $status = 'success') {
            $this->Session->setFlash(__($message), 'flash', array('status' => $status));
    }
    
    protected function deSlugUrl($url) {
        return str_replace('_', ' ', $url);
    }

    protected function renderModal($modalView, $args = null){   
        if ($args == null) {
            $args = array();
        }
        
        if (!isset($args['setEdit'])) {
            $args['setEdit'] = false;
        }      
        if (!isset($args['setModal'])) {
            $args['setModal'] = false;
        }
        if (!isset($args['setAjax'])) {
            $args['setAjax'] = false;
        }
                
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->set('edit', $args['setEdit']);
            $this->set('modal', $args['setModal']);
            $this->set('ajax', $args['setAjax']);
            $this->render('/Elements/' . $modalView);
        }      
    }
    
    public function renderJson($data) {  
        $this->cacheAction = "+999 days";
        $this->layout = 'ajax';
        $this->autoRender=false;
        $this->set('data', json_encode($data));
        $this->render('/Elements/json');        
    }
    
    // http://stackoverflow.com/questions/6826106/generate-random-string
    public function randomString($length = 40) {
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $str = "";    

        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        return $str;
    }
}
