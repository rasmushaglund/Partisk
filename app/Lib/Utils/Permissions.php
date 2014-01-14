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
 * @package     app.View.Helper
 * @license     http://opensource.org/licenses/MIT MIT
 */

App::uses('CakeLog', 'CakeRequest');
App::import('Model', 'Question');
App::import('Model', 'Quiz');
App::import('Model', 'Answer');

class Permissions {
    public static function checkPermission($controller, $action) {
        $user = AuthComponent::user();
        $role = $user['Role']['name'];
        
        if ($role === 'admin') { 
            return true; 
        } else if ($role === 'moderator') {
            return in_array($controller, array('tag', 'question', 'quiz', 'answer'));
        } else if ($role === 'contributor') {
            return $action === 'add' && ($controller === 'question' || $controller === 'answer');
        }
        
        Permissions::abuse("Not authorized to access view");

        $request = new CakeRequest();
        if ($request->is('ajax')) { die; }
        
        return false;
    }

    public static function isLoggedIn() {
        return AuthComponent::user();
    }

    public static function getUser($field = null) {
        return AuthComponent::user($field);
    }
    
    public static function isAdmin() { 
        $user = AuthComponent::user();
        return $user['Role']['name'] === 'admin';
    }
    
    public static function canAddQuestion() { return Permissions::checkPermission('question', 'add'); }
    public static function canAddAnswer() { return Permissions::checkPermission('answer', 'add'); }
    public static function canAddTag() { return Permissions::checkPermission('tag', 'add'); }
    public static function canAddParty() { return Permissions::checkPermission('party', 'add'); }
    public static function canAddUser() { return Permissions::checkPermission('user', 'add'); }
    public static function canAddQuiz() { return Permissions::checkPermission('quiz', 'add'); }
    public static function canEditUser() { return Permissions::checkPermission('user', 'edit'); }
    public static function canEditTag() { return Permissions::checkPermission('tag', 'edit'); }
    public static function canEditParty() { return Permissions::checkPermission('party', 'edit'); }
    public static function canDeleteTag() { return Permissions::checkPermission('tag', 'delete'); }
    public static function canDeleteParty() { return Permissions::checkPermission('party', 'delete'); }
    public static function canDeleteUser() { return Permissions::checkPermission('user', 'delete'); }
    public static function canApproveQuestion() { return Permissions::checkPermission('question', 'approve'); }
    public static function canApproveAnswer() { return Permissions::checkPermission('answer', 'approve'); }
    public static function canApproveQuiz() { return Permissions::checkPermission('quiz', 'approve'); }
    public static function canApproveUser() { return Permissions::checkPermission('user', 'approve'); }
   
    public static function canEditQuiz($quiz = null) {
        if ($quiz !== null) {
            return Permissions::canModifyQuiz($quiz, "edit");
        } else {
            return Permissions::checkPermission('quiz', 'edit');
        }
    }

    public static function canDeleteQuiz($quiz = null) {
        if ($quiz !== null) {
            return Permissions::canModifyQuiz($quiz, "delete");
        } else {
            return Permissions::checkPermission('quiz', 'delete'); 
        }
    }    
    
    public static function canEditQuestion($question = null) {
        if ($question !== null) {
            return Permissions::canModifyQuestion($question, "edit");
        } else {
            return Permissions::checkPermission('question', 'edit');
        }
    }

    public static function canDeleteQuestion($question = null) {
        if ($question !== null) {
            return Permissions::canModifyQuestion($question, "delete");
        } else {
            return Permissions::checkPermission('question', 'delete');
        }
    }
    
    public static function canEditAnswer($answer = null) {
        if ($answer !== null) {
            return Permissions::canModifyAnswer($answer, "edit");
        } else  {
            return Permissions::checkPermission('answer', 'edit');
        }
    }

    public static function canDeleteAnswer($answer = null) {
        if ($answer !== null) {
            return Permissions::canModifyAnswer($answer, "delete");
        } else  {
            return Permissions::checkPermission('answer', 'delete');
        }
    }

    public static function canModifyQuestion($question, $type) {
        $userId = AuthComponent::user('id');
        
        if (!isset($question['Question'])) {
            $questionModel = new Question();
            $question = $questionModel->getByIdOrTitle($question);
        }
        
        if ($question['Question']['created_by'] == $userId && $question['Question']['approved'] == 0) {
            return true;
        }

        if ($type == "edit") {
            return Permissions::canEditQuestion();
        } else {
            return Permissions::canDeleteQuestion();
        }
    }
    
    public static function canModifyAnswer($answer, $type) {
        $userId = AuthComponent::user('id');
        
        if (!isset($answer['Answer'])) {
            $answerModel = new Answer();
            $answer = $answerModel->getById($answer);
        }

        if ($answer['Answer']['created_by'] == $userId && $answer['Answer']['approved'] == 0) {
            return true;
        }

        if ($type == "edit") {
            return Permissions::canEditAnswer();
        } else {
            return Permissions::canDeleteAnswer();
        }
    }
   
    public static function canModifyQuiz($quiz, $type) {
        $userId = AuthComponent::user('id');
        
        if (!isset($quiz['Quiz'])) {
            $quizModel = new Quiz();
            $quiz = $quizModel->getById($quiz);
        }

        if ($quiz['Quiz']['created_by'] == $userId && $quiz['Quiz']['approved'] == 0) {
            return true;
        }

        if ($type == "edit") {
            return Permissions::canEditQuiz();
        } else {
            return Permissions::canDeleteQuiz();
        }
    }
    
    public static function abuse($message) {
        $request = new CakeRequest();
        
        $url = $request->url;
        //$this->customFlash(__('Du har inte tillåtelse att göra det du just försökte göra.'), "danger");
        CakeLog::write('abuse', $request->clientIp() . ', User:' . AuthComponent::user('username') . 
                       ', Url:' . $url . ', Referer:' . $request->referer() . ", Message:" . $message);
    }
}
        
?>