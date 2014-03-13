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

$this->Html->addCrumb('Answer');
$this->Html->addCrumb('Status');
?>

<h2>Ej godkända svar</h2>
<?php if (sizeof($answers) == 0) { ?>
<p>Du har inga svar som väntar på att godkännas</p>
<?php } else { ?>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Fråga</th>
            <th>Parti</th>
            <th>Svar</th>
            <th>Verktyg</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($answers as $answer) {
            if (!$answer['Answer']['approved'] && !$answer['Answer']['deleted']) {
                ?>
                <tr>
                    <td><?php echo $this->Html->link($answer['Question']['title'], array('controller' => 'questions', 'action' => 'view', $answer['Question']['id'])); ?></td>
                    <td><?php echo $this->Html->link($answer['Party']['name'], array('controller' => 'parties', 'action' => 'view', $answer['Party']['id'])); ?></td>
                    <?php echo $this->element('answerTableCell', array('answer' => $answer,
                        'question' => $answer));
                    ?>
                    <td><?php echo $this->element('answerAdminToolbox', array('answer' => $answer, 'questionTitle' => $answer['Question']['title'])); ?></td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
<?php } ?>

<h2>Godkända svar</h2>
<?php if (sizeof($answers) == 0) { ?>
<p>Du har inga godkända svar</p>
<?php } else { ?>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Fråga</th>
            <th>Parti</th>
            <th>Svar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($answers as $answer) {
            if ($answer['Answer']['approved'] && !$answer['Answer']['deleted']) {
                ?>
                <tr>
                    <td>
        <?php echo $this->Html->link($answer['Question']['title'], array('controller' => 'questions', 'action' => 'view', $answer['Question']['id'])); ?>
                    </td>
                    <td><?php echo $this->Html->link($answer['Party']['name'], array('controller' => 'parties', 'action' => 'view', $answer['Party']['id'])); ?>
                    </td>
                    <?php echo $this->element('answerTableCell', array('answer' => $answer,
                        'question' => $answer));
                    ?>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
<?php } ?>

<h2>Borttagna svar</h2>
<?php if (sizeof($answers) == 0) { ?>
<p>Du har inga borttagna svar</p>
<?php } else { ?>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Fråga</th>
            <th>Parti</th>
            <th>Svar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($answers as $answer) {
            if ($answer['Answer']['deleted']) {
                ?>
                <tr>
                    <td>
        <?php echo $this->Html->link($answer['Question']['title'], array('controller' => 'questions', 'action' => 'view', $answer['Question']['id'])); ?>
                    </td>
                    <td><?php echo $this->Html->link($answer['Party']['name'], array('controller' => 'parties', 'action' => 'view', $answer['Party']['id'])); ?>
                    </td>
                <?php echo $this->element('answerTableCell', array('answer' => $answer,
                    'question' => $answer));
                ?>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
<?php } ?>