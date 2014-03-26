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
            echo $this->Html->link($question['Question']['title'], array('controller' => 'questions', 'action' => 'view', $question['Question']['revision_id'])); ?>
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
            echo $this->Html->link($question['Question']['title'], array('controller' => 'questions', 'action' => 'view', $question['Question']['revision_id'])); ?>
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
            echo $this->Html->link($question['Question']['title'], array('controller' => 'questions', 'action' => 'view', $question['Question']['revision_id'])); ?>
            </td></tr>
    <?php }
    } ?>
</table>
<?php } ?>