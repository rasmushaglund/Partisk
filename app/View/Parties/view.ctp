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
 * @package     app.View.Parties
 * @license     http://opensource.org/licenses/MIT MIT
 */

$this->Html->addCrumb('Partier', Router::url(array('controller' => 'parties', 'action' => 'index'), true));
$this->Html->addCrumb(ucfirst($party['Party']['name']));

$answers = $party['Answer'];
$deleted = $party['Party']['deleted'];

?>

<h1<?php echo $deleted ? ' class="deleted"' : ''; ?>>
  <?php echo $this->element('party_header', array('party' => $party['Party'], 'link' => true, 'title' => true)); ?>
  <?php if ($current_user) { echo $this->element('partyAdminToolbox', array('party' => $party)); } ?> 
</h1>
<?php if ($deleted) { ?>
<p class="deleted">(Borttagen)</p>
<?php } ?>

<p><a href="<?php echo $party['Party']['website'];?>"><?php echo $party['Party']['website'];?></a></p>
<p><?php echo $party['Party']['description']; ?></p>
 
<?php if ($current_user) { ?>
<div class="tools">
<?php  echo $this->element('saveQuestion'); 
  echo $this->element('saveAnswer', array('partyId' => $party['Party']['id'])); ?>
</div>
<?php } ?>

<?php
  if (!empty($answers)) {
    $chunks = array_chunk($answers, ceil(sizeof($answers) / 2));
?>
  <div class="row">
    <?php if (isset($chunks[0])) { ?>
    <div class="col-md-6">
      <?php echo $this->element('partyQuestionsTable', array('answers' => $chunks[0])); ?>
    </div>
    <?php } if (isset($chunks[1])) { ?>
    <div class="col-md-6">
      <?php echo $this->element('partyQuestionsTable', array('answers' => $chunks[1])); ?>
    </div>
    <?php } ?>
  </div>

<?php } ?>

<div class="row">
    <div class="col-md-6">
<?php 
   echo $this->Html->link('<i class="fa fa-question-circle"></i> Visa ej besvarade frågor', array('controller' => 'parties', 'action' => 'notAnswered', 
       'name' => str_replace(' ', '_', strtolower($party['Party']['name']))), array('class' => 'btn btn-s btn-info', 'escape' => false));          
?>
    </div>
</div>


<?php echo $this->element('authorInfo', array('object' => $party, 'model' => 'Party')); ?>