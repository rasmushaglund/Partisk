<?php
/** 
 * Parties view
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

$this->Html->addCrumb('Partier');
?>

<?php if ($current_user) { ?>
<div class="tools">
  <?php echo $this->element('saveParty'); ?>
</div>
<?php } ?>

<table class="table party-table table-striped data-table">
    <thead>
        <th></th>
        <th>Parti</th>
        <th>Bästa resultat av senaste EU- och riksdagsval</th>
        <th>Resultat senaste riksdagsval (2010)</th>
        <th>Resultat senaste EU-val (2009)</th>
        <?php if ($isLoggedIn) { ?>
        <th>Verktyg</th>
        <?php } ?>
    </thead>
    <tbody>
        <?php foreach ($parties as $party): ?>
        <tr>
            <th>
            <?php echo $this->element('party_header', array('party' => $party['Party'], 'link' => true, 'small' => true, 'title' => false)); ?>
            </th>
            <td>
            <?php echo $this->Html->link(ucfirst($party['Party']['name']),
                array('controller' => 'parties', 'action' => 'view', $party['Party']['id'])); ?> 
            </td>
            <td><i class="percent"><?php echo round($party['Party']['best_result'], 1); ?>%</i></td>
            <td><i class="percent"><?php echo round($party['Party']['last_result_parliment'], 1); ?>%</i></td>
            <td><i class="percent"><?php echo round($party['Party']['last_result_eu'], 1); ?>%</i></td>
            <?php if ($isLoggedIn) { ?>
            <td>
                <?php echo $this->element('partyAdminToolbox', array('party' => $party)); ?>
            </td>
            <?php } ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a class="btn btn-link" data-toggle="modal" data-target="#parties-info"><i class="fa fa-info-circle"></i> Info om partier</a>