<?php
/** 
 * Controller for managing the application
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

class AppController extends Controller {

    var $helpers = array('Session');

    var $isLoggedIn = false;
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
        /*$this->Auth->authenticate = 'Blowfish';
        
        $this->Auth->scope = array('User.deleted' => false, 'User.approved' => true);*/
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
        } 
    }

    private function setAccessInView($user) {
        $this->set('canEditQuestion', $this->canEditQuestion);
        $this->set('isLoggedIn', $this->isLoggedIn);
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
            $this->Question->recursive = -1;
            $questions = $this->Question->find('all', array(
                    'fields' => array('created_by', 'approved'),
                    'conditions' => array('id' => $question)
                ));

            $question = array_pop($questions);
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
            $this->Answer->recursive = -1;
            $answers = $this->Answer->find('all', array(
                    'fields' => array('created_by', 'approved'),
                    'conditions' => array('id' => $answer)
                ));
            $answer = array_pop($answers);
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
            $this->Quiz->recursive = -1;
            $quizzes = $this->Quiz->find('all', array(
                    'fields' => array('created_by', 'approved'),
                    'conditions' => array('id' => $quiz)
                ));
            $quiz = array_pop($quizzes);
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
}
