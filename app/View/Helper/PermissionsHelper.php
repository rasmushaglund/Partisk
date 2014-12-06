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

App::uses('AppHelper', 'View/Helper');
App::uses('Permissions', 'Utils');

class PermissionsHelper extends AppHelper {
    
    private function checkPermission($controller, $action) { return Permissions::checkPermission($controller, $action); }
    public function isLoggedIn() { return Permissions::isLoggedIn(); }
    public function getUser($field = null) { return Permissions::getUser($field); }
    public function isAdmin() { return Permissions::isAdmin(); }
        
    public function canAddQuestion() { return Permissions::canAddQuestion(); }
    public function canAddAnswer() { return Permissions::canAddAnswer(); }
    public function canAddTag() { return Permissions::canAddTag(); }
    public function canAddParty() { return Permissions::canAddParty(); }
    public function canAddUser() { return Permissions::canAddUser(); }
    public function canAddQuiz() { return Permissions::canAddQuiz(); }
    public function canEditUser() { return Permissions::canEditUser(); }
    public function canEditTag() { return Permissions::canEditTag(); }
    public function canEditParty() { return Permissions::canEditParty(); }
    public function canDeleteTag() { return Permissions::canDeleteTag(); }
    public function canDeleteParty() { return Permissions::canDeleteParty(); }
    public function canDeleteUser() { return Permissions::canDeleteUser(); }
    public function canApproveQuestion() { return Permissions::canApproveQuestion(); }
    public function canApproveAnswer() { return Permissions::canApproveAnswer(); }
    public function canApproveQuiz() { return Permissions::canApproveQuiz(); }
    public function canApproveUser() { return Permissions::canApproveUser(); }
    public function canEditQuiz($quiz = null) { return Permissions::canEditQuiz($quiz); }
    public function canDeleteQuiz($quiz = null) { return Permissions::canDeleteQuiz($quiz); }    
    public function canEditQuestion($question = null) { return Permissions::canEditQuestion($question); }
    public function canDeleteQuestion($question = null) { return Permissions::canDeleteQuestion($question);}
    public function canEditAnswer($answer = null) { return Permissions::canEditAnswer($answer); }
    public function canDeleteAnswer($answer = null) { return Permissions::canDeleteAnswer($answer); }
}
        
?>