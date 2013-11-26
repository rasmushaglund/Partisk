<?php
/** 
 * Answer user status view
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
 * @package     app.View.Tags
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

$this->Html->addCrumb('Answer');
$this->Html->addCrumb('Status');

?>

<h2>Ej godkända svar</h2>
<table class="table table-bordered table-striped">
    <?php foreach ($answers as $answer) { 
        if (!$answer['Answer']['approved'] && !$answer['Answer']['deleted']) { ?>
            <tr>
                <td>
                    <?php echo $this->Html->link($answer['Question']['title'], array('controller' => 'questions', 'action' => 'view', $answer['Question']['id'])); ?>
                </td>
                <td><?php 
                    echo $this->Html->link($answer['Answer']['answer'], array('controller' => 'answers', 'action' => 'view', $answer['Answer']['id'])); ?>
                </td>
                <td>
                    <?php echo $this->element('answerAdminToolbox', array('answer' => $answer, 'questionTitle' => $answer['Question']['title'])); ?>
                </td>
            </tr>
    <?php }
    } ?>
</table>

<h2>Godkända svar</h2>
<table class="table table-bordered table-striped">
    <?php foreach ($answers as $answer) { 
        if ($answer['Answer']['approved'] && !$answer['Answer']['deleted']) { ?>
            <tr>
                <td>
                    <?php echo $this->Html->link($answer['Question']['title'], array('controller' => 'questions', 'action' => 'view', $answer['Question']['id'])); ?>
                </td>
                <td><?php 
                    echo $this->Html->link($answer['Answer']['answer'], array('controller' => 'answers', 'action' => 'view', $answer['Answer']['id'])); ?>
                </td>
                <td>
                    <?php echo $this->element('answerAdminToolbox', array('answer' => $answer, 'questionTitle' => $answer['Question']['title'])); ?>
                </td>
            </tr>
    <?php }
    } ?>
</table>

<h2>Borttagna svar</h2>
<table class="table table-bordered table-striped">
    <?php foreach ($answers as $answer) { 
        if ($answer['Answer']['deleted']) { ?>
            <tr>
                <td>
                    <?php echo $this->Html->link($answer['Question']['title'], array('controller' => 'questions', 'action' => 'view', $answer['Question']['id'])); ?>
                </td>
                <td><?php 
                    echo $this->Html->link($answer['Answer']['answer'], array('controller' => 'answers', 'action' => 'view', $answer['Answer']['id'])); ?>
                </td>
                <td>
                    <?php echo $this->element('answerAdminToolbox', array('answer' => $answer, 'questionTitle' => $answer['Question']['title'])); ?>
                </td>
            </tr>
    <?php }
    } ?>
</table>