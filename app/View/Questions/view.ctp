<?php
/** 
 * Question view
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
 * @package     app.View.Questions
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

$this->Html->addCrumb('Frågor', '/questions/');
$this->Html->addCrumb($question['Question']['title']);
$deleted = $question['Question']['deleted'];
?>

<h1<?php echo $deleted ? ' class="deleted"' : ''; ?>>
<?php echo ucfirst(h($question['Question']['title'])); ?>
<?php echo $this->element('questionAdminToolbox', array('question' => $question)); ?>
</h1>
<?php if ($deleted) { ?>
<p class="deleted">(Borttagen)</p>
<?php } ?>
<div class="tags">
<?php foreach ($question['Tag'] as $tag): ?>
  <?php echo $this->Html->link($tag['name'], array('controller' => 'tags', 'action' => 'view', $tag['id']), array('class' => 'btn btn-success btn-xs')); ?>
<?php endforeach; ?>
</div>
<?php echo $this->element('authorInfo', array('object' => $question, 'model' => 'Question')); ?>

<p><?php echo $question['Question']['description']; ?></p>

<?php if ($current_user) { ?>
<div class="tools">
<?php echo $this->element('saveAnswer', array('questionId' => $question['Question']['id'])); ?>
</div>
<?php } ?>

<table class="table table-bordered table-striped qa-table narrow-table">
<?php foreach ($answers as $answer): ?>
	<tr>
      <th>
      	<?php echo $this->element('party_header', array('party' => $answer['Party'], 'link' => true, 'title' => true, 'small' => true)); ?>
      </th>
    	<?php 
        echo $this->element('answerTableCell', array('answer' => $answer));
      ?>   	
      <?php if ($current_user) { ?>
            <td>
              <?php echo $this->element('answerAdminToolbox', array('answer' => $answer, 'questionTitle' => $question['Question']['title'])); ?>
            </td>
      <?php } ?>	    
  </tr>
<?php endforeach; ?>
</table>
