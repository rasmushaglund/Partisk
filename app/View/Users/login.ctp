<?php
/** 
 * User login page
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
 * @package     app.View.Users
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

$this->Html->addCrumb('Logga in');

?>

<form action="<?php Router::url(array('controller' => 'users', 'action' => 'login')); ?>" class="alert alert-info form-box" id="UserLoginForm" method="post" accept-charset="utf-8" role="form">
     <div style="display:none;">
     <input type="hidden" name="_method" value="POST"></div>    
     <legend>Logga in</legend>
     <div class="form-group">
     <label for="UserUsername">Användarnamn</label>
     <input name="data[User][username]" maxlength="50" type="text" id="UserUsername" required="required" class="form-control"></div>
     <div class="form-group">
     <label for="UserPassword">Lösenord</label>
     <input name="data[User][password]" type="password" id="UserPassword" required="required" class="form-control"></div>    
     <input type="submit" value="Logga in" class="btn btn-default">
</form>