<?php
/** 
 * Answer view
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
 * @package     app.View.Answers
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

$this->Html->addCrumb('Frågor', '/questions/');
$this->Html->addCrumb($answer['Question']['title'], '/questions/view/' . $answer['Question']['id']);
$this->Html->addCrumb(ucfirst($answer['Party']['name']), '/parties/view/' . $answer['Party']['id']);
$this->Html->addCrumb($answer['Answer']['answer']);

$deleted = $answer['Answer']['deleted'];

?>

<h1<?php echo $deleted ? ' class="deleted"' : ''; ?>><?php echo $this->element('party_header', array('party' => $answer['Party'], 'link' => true, 'title' => false)); ?>
<?php echo $answer['Question']['title']; ?>: <?php echo ucfirst(h($answer['Answer']['answer'])); ?>
<?php if ($current_user) {
  echo $this->element('answerAdminToolbox', array('answer' => $answer, 'questionTitle' => $answer['Question']['title']));
} ?>
</h1>
<?php if ($deleted) { ?>
<p class="deleted">(Borttagen)</p>
<?php } ?>

<?php echo $this->element('authorInfo', array('object' => $answer, 'model' => 'Answer')); ?>

<p><?php echo $answer['Answer']['description']; ?></p>

<b>Källa:</b> 
<?php 
	if (filter_var($answer['Answer']['source'], FILTER_VALIDATE_URL)) {
		echo "<a href='" . $answer['Answer']['source'] . "'>" . $answer['Answer']['source'] . "</a>";
	} else {
		echo $answer['Answer']['source']; 
	}
?> <i>(<?php echo date('Y-m-d', strtotime($answer['Answer']['date'])); ?>)</i>

<?php if ($current_user) { ?>
  <div class="tools">
<?php echo $this->element('saveAnswer', array('partyId' => $answer['Party']['id'], 'questionId' => $answer['Question']['id'])); ?>
  </div>
<?php } ?>

<?php if (sizeof($history) > 1) { ?>
<div class="history">
<h3>Historik</h3>
<table class="table table-bordered table-striped">	
<?php foreach ($history as $historicAnswer): ?>
	<tr <?php if ($answer['Answer']['id'] == $historicAnswer['Answer']['id']) { echo 'class = "success"'; } ?>>
      <th>
      	<?php echo date('Y-m-d', strtotime($historicAnswer['Answer']['date'])); ?>
      </th>
      <td>
      	<?php echo $this->Html->link($historicAnswer['Answer']['answer'],
                  array('controller' => 'answers', 'action' => 'view', $historicAnswer['Answer']['id'])); ?>      	
      </td>
      <?php if ($current_user) { ?>
      <td>
        <?php echo $this->element('answerAdminToolbox', array('answer' => $historicAnswer, 'questionTitle' => $answer['Question']['title'])); ?>
      </td>
      <?php } ?>
    </tr>
<?php endforeach; ?>
</table>
</div>
<?php } ?>