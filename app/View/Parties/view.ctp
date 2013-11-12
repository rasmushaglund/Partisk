<?php
/** 
 * Party view
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
 * @package     app.View.Parties
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

$this->Html->addCrumb('Partier', '/parties/');
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

<?php echo $this->element('authorInfo', array('object' => $party, 'model' => 'Party')); ?>

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
