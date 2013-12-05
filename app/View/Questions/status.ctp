<?php
/** 
 * Questions user status view
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
 * @package     app.View.Tags
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

$this->Html->addCrumb('Frågor');
$this->Html->addCrumb('Status');

?>

<h2>Frågor som väntar på att godkännas</h2>
<?php if (sizeof($questions) == 0) { ?>
<p>Du har inga frågor som väntar på att godkännas</p>
<?php } else { ?>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Fråga</th>
            <th>Verktyg</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($questions as $question) { 
        if (!$question['Question']['approved'] && !$question['Question']['deleted']) { ?>
            <tr><td><?php 
            echo $this->Html->link($question['Question']['title'], array('controller' => 'questions', 'action' => 'view', $question['Question']['id'])); ?>
            </td>
            <td><?php echo $this->element('questionAdminToolbox', array('question' => $question));  ?></td>
            </tr>
    <?php }
    } ?>
    </tbody>
</table>
<?php } ?>

<h2>Godkända frågor</h2>
<?php if (sizeof($questions) == 0) { ?>
<p>Du har inga ej godkända frågor</p>
<?php } else { ?>
<table class="table table-bordered table-striped">
    <?php foreach ($questions as $question) { 
        if ($question['Question']['approved'] && !$question['Question']['deleted']) { ?>
            <tr><td><?php 
            echo $this->Html->link($question['Question']['title'], array('controller' => 'questions', 'action' => 'view', $question['Question']['id'])); ?>
            </td></tr>
    <?php }
    } ?>
</table>
<?php } ?>

<h2>Borttagna frågor</h2>
<?php if (sizeof($questions) == 0) { ?>
<p>Du har inga borttagna frågor</p>
<?php } else { ?>
<table class="table table-bordered table-striped">
    <?php foreach ($questions as $question) { 
        if ($question['Question']['deleted']) { ?>
            <tr><td><?php 
            echo $this->Html->link($question['Question']['title'], array('controller' => 'questions', 'action' => 'view', $question['Question']['id'])); ?>
            </td></tr>
    <?php }
    } ?>
</table>
<?php } ?>