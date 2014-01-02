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

class AppController extends Controller {
    var $helpers = array('Session');

    var $isLoggedIn = false;
    var $isAdmin = false;
    var $canAddQuestion = false;
    var $canAddAnswer = false;
    var $canAddTag = false;
    var $canAddParty = false;
    var $canAddUser = false;
    var $canAddQuiz = false;
    var $canEditQuestion = false;
    var $canEditUser = false;
    var $canEditTag = false;
    var $canEditParty = false;
    var $canEditAnswer = false;
    var $canEditQuiz = false;
    var $canDeleteAnswer = false;
    var $canDeleteTag = false;
    var $canDeleteQuestion = false;
    var $canDeleteParty = false;
    var $canDeleteUser = false;
    var $canDeleteQuiz = false;
    var $canApproveQuestion = false;
    var $canApproveAnswer = false;
    var $canApproveQuiz = false;
    var $canApproveUser = false;

    public $components = array(
        'Session',
        'Auth'
    );

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
        $this->setAccess($this->Auth->user());
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

        $this->set('current_user', $this->Auth->user());
        $this->setAccessInView($this->Auth->user());
        $this->set("currentPage", "default");
    }

    private function setAccess($user) {
        $role = $user['Role']['name'];

        if (in_array($role, array('contributor', 'moderator', 'admin'))) {
            $this->isLoggedIn = true;
            $this->canAddQuestion = true;
            $this->canAddAnswer = true;
        }

        if (in_array($role, array('moderator', 'admin'))) {
            $this->canDeleteTag = true;
            $this->canDeleteQuestion = true;
            $this->canDeleteAnswer = true;
            $this->canAddTag = true;
            $this->canEditQuestion = true;
            $this->canEditTag = true;
            $this->canEditAnswer = true;
            $this->canApproveQuestion = true;
            $this->canApproveAnswer = true;
            $this->canEditQuiz = true;
            $this->canAddQuiz = true;
            $this->canApproveQuiz = true;
        }

        if ($role == 'admin') {
            $this->canAddParty = true;
            $this->canEditParty = true;
            $this->canDeleteParty = true;
            $this->canAddUser = true;
            $this->canEditUser = true;
            $this->canDeleteUser = true;
            $this->canDeleteQuiz = true;
            $this->canApproveUser = true;
            $this->isAdmin = true;
        } 
    }

    private function setAccessInView($user) {
        $this->set('canEditQuestion', $this->canEditQuestion);
        $this->set('isLoggedIn', $this->isLoggedIn);
        $this->set('isAdmin', $this->isAdmin);
        $this->set('canAddQuestion', $this->canAddQuestion);
        $this->set('canEditQuestion', $this->canEditQuestion);
        $this->set('canApproveQuestion', $this->canApproveQuestion);
        $this->set('canAddAnswer', $this->canAddAnswer);
        $this->set('canEditAnswer', $this->canEditAnswer);
        $this->set('canApproveAnswer', $this->canApproveAnswer);
        $this->set('canDeleteAnswer', $this->canDeleteAnswer);
        $this->set('canDeleteTag', $this->canDeleteTag);
        $this->set('canDeleteQuestion', $this->canDeleteQuestion);
        $this->set('canAddTag', $this->canAddTag);
        $this->set('canEditTag', $this->canEditTag);
        $this->set('canAddParty', $this->canAddParty);
        $this->set('canEditParty', $this->canEditParty);
        $this->set('canDeleteParty', $this->canDeleteParty);
        $this->set('canAddUser', $this->canAddUser);
        $this->set('canEditUser', $this->canEditUser);
        $this->set('canDeleteUser', $this->canDeleteUser);
        $this->set('canAddQuiz', $this->canAddQuiz);
        $this->set('canEditQuiz', $this->canEditQuiz);
        $this->set('canDeleteQuiz', $this->canDeleteQuiz);
        $this->set('canApproveQuiz', $this->canApproveQuiz);
        $this->set('canApproveUser', $this->canApproveUser);
    }

    public function customFlash($message, $status = 'success') {
            $this->Session->setFlash(__($message), 'flash', array('status' => $status));
    }

    public function isAuthorized($user) {
        $role = $user['Role']['name'];

        if ($role === 'admin') {
            return true;
        }


        $this->abuse("Not authorized to access view");

        if ($this->request->is('ajax')) {
            die;
        }
        
        return false;
    }

    public function abuse($message) {
        $url = $this->request->url;
        $this->customFlash(__('Du har inte tillåtelse att göra det du just försökte göra.'), "danger");
        CakeLog::write('abuse', $this->request->clientIp() . ', User:' . $this->Auth->user('username') . 
                       ', Url:' . $url . ', Referer:' . $this->referer() . ", Message:" . $message);
    }

    

    public function userCanEditQuestion($userId, $question = null) {
        return $this->userCanModifyQuestion($userId, $question, "edit");
    }

    public function userCanDeleteQuestion($userId, $question = null) {
        return $this->userCanModifyQuestion($userId, $question, "delete");
    }

    private function userCanModifyQuestion($userId, $question, $type) {
        if (!isset($question['Question'])) {
            $this->loadModel('Question');
            $question = $this->Question->getByIdOrTitle($question);
            
        }
        

        if ($question['Question']['created_by'] == $userId && $question['Question']['approved'] == 0) {
            return true;
        }

        if ($type == "edit") {
            return $this->canEditQuestion;
        } else {
            return $this->canDeleteQuestion;
        }
    }

    public function userCanEditAnswer($userId, $answer = null) {
        return $this->userCanModifyAnswer($userId, $answer, "edit");
    }

    public function userCanDeleteAnswer($userId, $answer = null) {
        return $this->userCanModifyAnswer($userId, $answer, "delete");
    }

    private function userCanModifyAnswer($userId, $answer = null, $type) {
        if (!isset($answer['Answer'])) {
            $this->loadModel('Answer');
            $answer = $this->Answer->getById($answer);
        }

        if ($answer['Answer']['created_by'] == $userId && $answer['Answer']['approved'] == 0) {
            return true;
        }

        if ($type == "edit") {
            return $this->canEditAnswer;
        } else {
            return $this->canDeleteAnswer;
        }
    }

    public function userCanEditQuiz($userId, $quiz = null) {
        return $this->userCanModifyQuiz($userId, $quiz, "edit");
    }

    public function userCanDeleteQuiz($userId, $quiz = null) {
        return $this->userCanModifyQuiz($userId, $quiz, "delete");
    }

    private function userCanModifyQuiz($userId, $quiz = null, $type) {
        if (!isset($quiz['Quiz'])) {
            $this->loadModel('Quiz');
            $quiz = $this->Quiz->getById($quiz);
        }

        if ($quiz['Quiz']['created_by'] == $userId && $quiz['Quiz']['approved'] == 0) {
            return true;
        }

        if ($type == "edit") {
            return $this->canEditQuiz;
        } else {
            return $this->canDeleteQuiz;
        }
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
}
