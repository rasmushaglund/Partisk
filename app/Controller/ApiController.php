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

class ApiController extends Controller {
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
    
    public function index() {
        return $this->redirect(array('action' => 'info', 'version' => Configure::read('apiVersion')));
    }
    
    public function info($version) {
        $this->set('version', $version);
        $this->render("/Api/$version/index"); 
    }
}
