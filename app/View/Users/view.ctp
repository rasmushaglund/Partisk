<?php
/** 
 * User view
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

$this->Html->addCrumb('Användare', Router::url(array('controller' => 'users', 'action' => 'index'), true));
$this->Html->addCrumb($user['User']['username']);

?>

<h1>
  <?php echo $user['User']['username']; ?>
  <?php if ($current_user) { echo $this->element('userAdminToolbox', array('user' => $user)); } ?>
</h1>

<?php echo $this->element('authorInfo', array('object' => $user, 'model' => 'User')); ?>

<p><?php echo $user['User']['description']; ?></p>