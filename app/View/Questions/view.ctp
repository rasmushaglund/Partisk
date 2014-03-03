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
 * @package     app.View.Questions
 * @license     http://opensource.org/licenses/MIT MIT
 */

$this->Html->addCrumb('Frågor', Router::url(array('controller' => 'questions', 'action' => 'index'), true));
$this->Html->addCrumb(ucfirst($question['Question']['title']));
$deleted = $question['Question']['deleted'];
$approved = $question['Question']['approved'];
?>

<div class="row">
    <div class="col-md-12">
<h1<?php echo $deleted ? ' class="deleted"' : ''; ?>>
<?php echo ucfirst(h($question['Question']['title'])); ?>
<?php echo $this->element('questionAdminToolbox', array('question' => $question)); ?>
</h1>
<?php echo $this->element("share"); ?>
<?php if ($deleted) { ?>
<div class="alert alert-warning">Frågan är borttagen</div>
<?php } ?>
<?php if (!$approved) { ?>
<div class="alert alert-warning">Frågan är ej godkänd</div>
<?php } ?>
<?php if (!$approved) { ?>
<div class="alert alert-warning">Revision 
    <?php echo $question['Question']['id']; ?>
    <?php echo !(int)$question['Question']['updated_date'] ? "(Orginal)":"";?>
</div>
<?php } ?>
                    
<div class="tags">
<?php foreach ($question['Tag'] as $tag): ?>
  <?php echo $this->Html->link('<i class="fa fa-tag"></i> ' . $tag['name'], array('controller' => 'tags', 'action' => 'view', 'name' => $tag['name']), array('class' => 'label label-primary', 'escape' => false)); ?>
<?php endforeach; ?>
</div>
    </div>
</div>
    
<div class="row">
    <div class="col-md-6">

<p><?php echo $question['Question']['description']; ?></p>

<?php if ($this->Permissions->isLoggedIn()) { ?>
<div class="tools">
<?php echo $this->element('saveAnswer', array('questionId' => $question['Question']['id'])); ?>
    <?php if (!$question['Question']['approved']) { ?>
<div class="btn-group">
    <?php echo $this->element('approveQuestionRevision', array('question' => $question['Question'])); ?>
    <?php echo $this->element('deleteQuestionRevision', array('question' => $question['Question'])); ?>
</div>
    <?php } ?>
</div>
<?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">

<table class="table table-bordered table-striped qa-table narrow-table table-hover">
<?php foreach ($answers as $answer): ?>
	<tr>
      <th>
      	<?php echo $this->element('party_header', array('party' => $answer['Party'], 'link' => true, 'title' => true, 'small' => true)); ?>
      </th>
    	<?php 
        echo $this->element('answerTableCell', array('answer' => $answer));
      ?>   	
      <?php if ($this->Permissions->isLoggedIn()) { ?>
            <td>
              <?php echo $this->element('answerAdminToolbox', array('answer' => $answer, 'questionTitle' => $question['Question']['title'])); ?>
            </td>
      <?php } ?>	    
  </tr>
<?php endforeach; ?>
</table>

    </div>
    
    <div class="col-md-6">
        <?php  if ($this->Permissions->isLoggedIn()) { 
            foreach ($revisions as $revision) { 
                    $revisionDate = $revision['Question']['updated_date'];
                    if (!(int)$revisionDate) {
                        $revisionText = "Orginal";
                    } else {
                        $revisionText = $revisionDate;
                    }
                    
                    $alertClass = "warning";
                    $revisionIsCurrent = false;
                    
                    if ($revision['Question']['approved']) {
                        $alertClass = "success";
                    } else if ($revision['Question']['id'] === $question['Question']['id']) {
                        $alertClass = "primary";
                    }
                    
                ?>
                <div class="panel panel-<?php echo $alertClass ?> panel-revision">
                    <div class="panel-heading">
                        <h3 class="panel-title"> 
                            <i><?php echo $this->Html->link("Revision med id " . $revision['Question']['id'] . ", " . $revisionText, array('controller' => 'questions', 'action' => 'view', $revision['Question']['id'])); ?></i></h3>
                    </div>
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <th>Titel</th>
                                    <td><?php echo $revision['Question']['title']; ?></td>
                                </tr>
                                <tr>
                                    <th>Godkänd</th>
                                    <td><?php echo $revision['Question']['approved'] ? "Ja" : "Nej"; ?></td>
                                </tr>
                                <tr>
                                    <th>Borrttagen</th>
                                    <td><?php echo $revision['Question']['deleted'] ? "Ja" : "Nej"; ?></td>
                                </tr>
                                <tr>
                                    <th>Typ</th>
                                    <td><?php echo $revision['Question']['type']; ?></td>
                                </tr>
                                <tr>
                                    <th>Beskrivning</th>
                                    <td><?php echo $revision['Question']['description']; ?></td>
                                </tr>
                                <tr>
                                    <th>Fler frågor kan hittas</th>
                                    <td><?php echo $revision['Question']['done'] ? "Nej" : "Ja"; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <div class="panel-footer">
                        <?php if (!$revision['Question']['approved']) { ?>
                        <div class="btn-group">
                            <?php echo $this->element('approveQuestionRevision', array('question' => $revision['Question'])); ?>
                            <?php echo $this->element('deleteQuestionRevision', array('question' => $revision['Question'])); ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            <?php 
                }
        } ?>
    </div>
</div>

<?php echo $this->element('authorInfo', array('object' => $question, 'model' => 'Question')); ?>