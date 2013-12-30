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

<div class="table table-bordered table-striped qa-table collapsable-table <?php echo isset($fixedHeader) && $fixedHeader ? 'table-with-fixed-header' : '' ?>">
    <div class="table-row table-head">
      <div class="table-header table-header-text">
          <a class="btn btn-link" data-toggle="modal" data-target="#parties-info"><i class="fa fa-info-circle"></i> Info om partier</a>
      </div>
      <?php foreach ($parties as $party): ?>
      <div class="table-header">
        <?php echo $this->element('party_header', array('party' => $party['Party'], 'link' => true, 'small' => false, 
                      'linkClass' => 'popover-hover-link')); ?>
        <div class="popover-data"><?php echo ucfirst($party['Party']['name']); ?></div>
      </div>
      <?php endforeach; ?>
      <?php if ($current_user) { ?>
      <div class="table-header">Verktyg</div>
      <?php } ?>
    </div>
    <?php foreach ($questions as $question): ?>
    <div class="table-row">
      <div class="table-cell table-header table-header-text">
        <?php 
        $notApproved = !$question['Question']['approved'];
        echo $this->Html->link($question['Question']['title'], array('controller' => 'questions', 'action' => 'view', 
            'title' => str_replace(' ', '_', strtolower($question['Question']['title']))),
                array('class' => $notApproved ? 'question-not-approved':''));  
        ?>
      </div>
      <?php foreach ($parties as $party): ?>
      <?php 

        if (isset($answers[$question["Question"]["id"]]) && isset($answers[$question["Question"]["id"]]['answers'][$party["Party"]["id"]])) {
          echo $this->element('answerCell', array('answer' => $answers[$question["Question"]["id"]]['answers'][$party["Party"]["id"]],
                                                  'question' => $question, 'party' => $party['Party']));
        } else { ?>
        <div class="table-cell"></div>
        <?php }?>
      <?php endforeach; ?>
      <?php if ($current_user) { ?>
        <div class="table-cell">
          <div class="tools">
             <?php echo $this->element('questionAdminToolbox', array('question' => $question));  ?>
           </div>
        </div>
      <?php } ?>
    </div>
    <?php endforeach; ?>
</div>