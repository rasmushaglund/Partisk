<?php 
/** 
 * Answer cell view
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

$answerClass = null;

$answerHtml = $this->Html->link($answer['Answer']['answer'],
      array('controller' => 'answers', 'action' => 'view', $answer['Answer']['id']), array('escape' => false, 'class' => 'popover-link'));

$notApproved = !$answer['Answer']['approved'];

if($answer['Answer']['answer'] == "ja") { $answerClass = 'class="table-cell yes"'; } 
else if($answer['Answer']['answer'] == "nej") { $answerClass = 'class="table-cell no"'; } 
else { $answerClass = 'class="table-cell"'; }?>

<div <?php echo $answerClass ?>>
  <div class="party-answer"><?php echo $this->element('party_header', array('party' => $party, 'link' => true, 'small' => true, 'title' => true)); ?></div>
  <span class="popover-link<?php echo $notApproved?' answer-not-approved':''; ?>" 
        data-id="<?php echo $answer['Answer']['id']; ?>" href="#"><?php 
    echo $answer['Answer']['answer'];
  ?></span>
</div>