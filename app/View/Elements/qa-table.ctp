<?php
/** 
 * Question Answer table view
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

  <table class="table table-bordered table-striped table-fixed-header qa-table">
  <thead class="header">
    <tr>
      <th>
        <?php if (isset($label)) { ?>
          <h3><?php echo $label; ?></h3> 
        <?php } ?>
      </th>
      <?php foreach ($parties as $party): ?>
      <th>
        <?php echo $this->element('party_header', array('party' => $party['Party'], 'link' => true, 'small' => false)); ?>
      </th>
      <?php endforeach; ?>
      <?php if ($current_user) { ?>
      <th>Status</th>
      <th>Verktyg</th>
      <?php } ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($questions as $question): ?>
    <tr>
      <th class="table-header-text">
        <?php 
        echo $this->Html->link($question['Question']['title'], array('controller' => 'questions', 'action' => 'view', $question['Question']['id']));  
        ?>
      </th>
      <?php foreach ($parties as $party): ?>
      <?php 

        if (isset($answers[$question["Question"]["id"]]) && isset($answers[$question["Question"]["id"]]['answers'][$party["Party"]["id"]])) {
          echo $this->element('answerCell', array('answer' => $answers[$question["Question"]["id"]]['answers'][$party["Party"]["id"]]));
        } else { ?>
          <td></td>
        <?php }?>
      <?php endforeach; ?>
      <?php if ($current_user) { ?>
        <td>
          <p><?php echo $question['Question']['approved'] ? "Godkänd" : "Ej godkänd"; ?></p>
        </td>
        <td>
          <div class="tools">
             <?php echo $this->element('questionAdminToolbox', array('question' => $question));  ?>
           </div>
        </td>
      <?php } ?>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>