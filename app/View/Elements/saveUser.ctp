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
 * @package     app.View.Elements
 * @license     http://opensource.org/licenses/MIT MIT
 */

if ($canAddUser) { ?>
	<?php

    $roles = $this->requestAction('roles/all');

	$editMode = isset($edit) && $edit;
	$ajaxMode = isset($ajax) && $ajax;

    if (!isset($roleId) && isset($user['User']['role_id'])) {
        $roleId = $user['User']['role_id'];
    }

	?>

    <?php echo $this->Bootstrap->create('User', array('modal' => true, 'label' => $editMode ? "Ändra användare" : "Lägg till användare", 
                    'id' => $editMode ? $user['User']['id'] : null, 'ajax' => $ajaxMode, 'editMode' => $editMode)); ?>
    <?php if ($editMode) { ?>
        <div class="input text form-group">
        <label>Användarnamn</label>
        <p><?php echo $user['User']['username']; ?></p>
        </div>
    <?php } else {
            echo $this->Bootstrap->input('username', array('label' => 'Användarnamn', 'placeholder' => 'Användarens namn', 
                            'value' => null)); 
        }
    ?>
    <?php echo $this->Bootstrap->input('fullname', 
                array('label' => 'Namn' , 'placeholder' => 'För- och Efternamn', 'value' => $editMode ? $user['User']['fullname'] : null)); ?>
    <?php echo $this->Bootstrap->input('email', array('label' => 'E-postadress', 'placeholder' => 'Användarens E-postadress', 'value' => $editMode ? $user['User']['email'] : null)); ?>
    <?php echo $this->Bootstrap->input('password', array('label' => $editMode?'Nytt lösenord':'Lösenord',  'placeholder' => 'Användarens lösenord',
        'type' => 'password')); ?>
    <?php echo $this->Bootstrap->input('confirmPassword', array('label' => $editMode?'Bekräfta nytt lösenord':'Bekräfta lösenord',  'placeholder' => 'Bekräfta användarens lösenord',
        'type' => 'password')); ?>
    <?php if ($canApproveUser && $editMode) {
        echo $this->Bootstrap->checkbox('approved', array('label' => 'Aktiverad', 'type' => 'checkbox',
                    'value' => $editMode ? $user['User']['approved'] : null)); 
    } ?>
    <?php echo $this->Bootstrap->dropdown('role_id', 'Role', array('label' => 'Roll', 'options' => $roles, 
                    'selected' => isset($roleId) ? $roleId : null)); ?>
    <?php echo $this->Bootstrap->textarea('description', array('label' => 'Presentation',  
                    'placeholder' => 'Här kan du skriva in en kort presentation om användaren', 
                    'value' => $editMode ? $user['User']['description'] : null)); ?>
    <?php echo $this->Bootstrap->end($editMode ? "Uppdatera" : "Skapa", array('modal' => true)); ?>
<?php } ?>