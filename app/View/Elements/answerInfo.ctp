<?php 
/** 
 * Info about one answer view
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
 * @package     app.View.Elements
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

?>
<?php if (!$answer['Answer']['approved']) { ?>
<p class="answer-not-approved">Ej godkänd</p>
<?php } ?>
<b><?php echo $this->Html->link($answer['Question']['title'], array('controller' => 'questions', 'action' => 'view', $answer['Question']['id']));?></b>:
<?php echo $this->Html->link($answer['Answer']['answer'],
                array('controller' => 'answers', 'action' => 'view', 'id' => $answer['Answer']['id']), array('escape' => false, 'class' => 'popover-link')); ?>
<p class="popover-description"><?php echo $answer['Answer']['description']; ?></p>
<a href="<?php echo $answer['Answer']['source']; ?>">Källa</a>
<?php echo $this->element('answerAdminToolbox', array('answer' => $answer, 'questionTitle' => $answer['Question']['title'])); ?>

