<?php
/**
 * Copyright 2013-2014 Partisk.nu Team
 * https://www.partisk.nu/
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * 
 * @copyright   Copyright 2013-2014 Partisk.nu Team
 * @link        https://www.partisk.nu
 * @package     app.View.Elements
 * @license     http://opensource.org/licenses/MIT MIT
 */
?>

<div class="table table-bordered table-striped qa-table collapsable-table table-with-fixed-header table-hover">
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
      <?php if ($this->Permissions->isLoggedIn()) { ?>
      <div class="table-header">Verktyg</div>
      <?php } ?>
    </div>
    <?php foreach ($questions as $question): ?>
    <div class="table-row">
      <div class="table-cell table-header table-header-text">
        <?php 
        $notApproved = !$question['Question']['approved'];
        echo $this->Html->link($question['Question']['title'], array('controller' => 'questions', 'action' => 'view', 
            'title' => $this->Url->slug($question['Question']['title'])),
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
      <?php if ($this->Permissions->isLoggedIn()) { ?>
        <div class="table-cell">
          <div class="tools">
             <?php echo $this->element('questionAdminToolbox', array('question' => $question));  ?>
           </div>
        </div>
      <?php } ?>
    </div>
    <?php endforeach; ?>
</div>