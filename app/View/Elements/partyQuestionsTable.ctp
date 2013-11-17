<?php
/** 
 * Party questions table view
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

<table class="table table-bordered table-striped narrow-table">
<?php foreach ($answers as $answer): ?>
    <tr>
      <th>
        <?php echo $this->Html->link($answer['Question']['title'],
                  array('controller' => 'questions', 'action' => 'view', $answer['Question']['id'])); ?>
      </th>
      <?php echo $this->element('answerCell', array('answer' => $answer, 
                          'question' => $answer)); ?>
      <?php if ($current_user) { ?>
        <td>
          <p><?php echo $answer['Answer']['approved'] ? "Godkänd" : "Ej godkänd"; ?></p>
        </td>
        <td>
          <?php echo $this->element('answerAdminToolbox', array('answer' => $answer, 'questionTitle' => $answer['Question']['title'])); ?>
        </td>
      <?php } ?>
    </tr>
 <?php endforeach; ?>
 </table>