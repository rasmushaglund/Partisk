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
 * @package     app.View.Answers
 * @license     http://opensource.org/licenses/MIT MIT
 */

$this->Html->addCrumb('Frågor', Router::url(array('controller' => 'questions', 'action' => 'index'), true));
$this->Html->addCrumb($answer['Question']['title'], Router::url(array('controller' => 'questions', 'action' => 'view', 
                    'title' => $this->Url->slug($answer['Question']['title'])), true));
$this->Html->addCrumb(ucfirst($answer['Party']['name']), Router::url(array('controller' => 'parties', 'action' => 'view', 
                    'name' => $this->Url->slug($answer['Party']['name'])), true));
$this->Html->addCrumb($answer['Answer']['answer']);

$deleted = $answer['Answer']['deleted'];

?>
<div class="row">
    <div class="col-md-12">
<h1<?php echo $deleted ? ' class="deleted"' : ''; ?>>
<?php echo $answer['Question']['title']; ?>
<?php if ($this->Permissions->isLoggedIn()) {
  echo $this->element('answerAdminToolbox', array('answer' => $answer, 'questionTitle' => $answer['Question']['title']));
} ?>
</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
<h2><?php echo $this->element('party_header', array('party' => $answer['Party'], 'link' => true, 'title' => true)); ?>
    <span class="party-answer">: <?php echo ucfirst(h($answer['Answer']['answer'])); ?></span></h2>
<?php echo $this->element("share"); ?>
<?php if ($deleted) { ?>
<p class="deleted">(Borttagen)</p>
<?php } ?>

<p><?php echo $answer['Answer']['description']; ?></p>

<?php 
	if (filter_var($answer['Answer']['source'], FILTER_VALIDATE_URL)) {
		echo "Källa: <a href='" . $answer['Answer']['source'] . "'> " . $answer['Answer']['source'] . "</a>";
	} else {
		echo "Källa: " . $answer['Answer']['source']; 
	}
?> <i class="source"><?php echo date('Y-m-d', strtotime($answer['Answer']['date'])); ?></i>

<?php if ($this->Permissions->isLoggedIn()) { ?>
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
      <?php if ($this->Permissions->isLoggedIn()) { ?>
      <td>
        <?php echo $this->element('answerAdminToolbox', array('answer' => $historicAnswer, 'questionTitle' => $answer['Question']['title'])); ?>
      </td>
      <?php } ?>
    </tr>
<?php endforeach; ?>
</table>
</div>
<?php } ?>
</div>
</div>

<?php echo $this->element('authorInfo', array('object' => $answer, 'model' => 'Answer')); ?>