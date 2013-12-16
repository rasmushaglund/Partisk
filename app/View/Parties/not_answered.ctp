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

$this->Html->addCrumb('Partier', Router::url(array('controller' => 'parties', 'action' => 'index'), true));
$this->Html->addCrumb(ucfirst($party['Party']['name']), Router::url(array('controller' => 'parties', 'action' => 'view', 
                    'name' => str_replace(' ', '_', strtolower($party['Party']['name']))), true));
$this->Html->addCrumb('Frågor utan svar');

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

<?php
  if (!empty($questions)) {
    $chunks = array_chunk($questions, ceil(sizeof($questions) / 2));
?>
  <div class="row">
    <?php if (isset($chunks[0])) { ?>
    <div class="col-md-6">
        <table class="table table-bordered table-striped">
        <?php foreach ($chunks[0] as $question) { ?>
            <tr><td><?php echo $this->Html->link($question['Question']['title'], array('controller' => 'questions', 'action' => 'view', 
                'title' => str_replace(' ', '_', strtolower($question['Question']['title'])))); ?></td></tr>
        <?php } ?>
        </table>
    </div>
    <?php } if (isset($chunks[1])) { ?>
    <div class="col-md-6">
        <table class="table table-bordered table-striped">
        <?php foreach ($chunks[1] as $question) { ?>
            <tr><td><?php echo $this->Html->link($question['Question']['title'], array('controller' => 'questions', 'action' => 'view', 
                'title' => str_replace(' ', '_', strtolower($question['Question']['title'])))); ?></td></tr>
        <?php } ?>
        </table>
    </div>
    <?php } ?>
  </div>

<?php } ?>
