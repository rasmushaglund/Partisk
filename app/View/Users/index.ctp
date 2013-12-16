<?php
/** 
 * Users view
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

$this->Html->addCrumb('Användare');

?>

<?php if ($current_user) { ?>
<div class="tools">
<?php echo $this->element('saveUser'); ?>
</div>
<?php } ?>

<table class="table">
<?php foreach ($users as $user): ?>
    <tr>
        <th>
            <?php echo $this->Html->link($user['User']['username'],
                                         array('controller' => 'users', 'action' => 'view', 'name' => $user['User']['username'])); ?> 
        </th>
        <?php if ($current_user) { ?>
        <td>
            <?php echo $this->element('userAdminToolbox', array('user' => $user)); ?>
        </td>
        <?php } ?>
    </tr>
    <?php endforeach; ?>
</table>
