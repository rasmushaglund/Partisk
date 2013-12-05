<?php
/** 
 * Quiz user status view
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

$this->Html->addCrumb('Quiz');
$this->Html->addCrumb('Status');

?>

<h2>Ej godkända quizzer</h2>
<?php if (sizeof($quizzes) == 0) { ?>
<p>Du har inga quizzer som väntar på att godkännas</p>
<?php } else { ?>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <td>Quiz</td>
            <td>Verktyg</td>
        </tr>
    </thead>
    <?php foreach ($quizzes as $quiz) { 
        if (!$quiz['Quiz']['approved'] && !$quiz['Quiz']['deleted']) { ?>
            <tr>
                <td>
                    <?php echo $this->Html->link($quiz['Quiz']['name'], array('controller' => 'quizzes', 'action' => 'admin', $quiz['Quiz']['id'])); ?>
                </td>
                <td>
                    <?php
                    echo $this->element('administerQuiz', array('quiz' => $quiz['Quiz'])); 
    echo $this->element('editQuiz', array('quiz' => $quiz['Quiz']));
    echo $this->element('deleteQuiz', array('quiz' => $quiz['Quiz'])); 
    ?>
                </td>
            </tr>
    <?php }
    } ?>
</table>
<?php } ?>

<h2>Godkända quizzer</h2>
<?php if (sizeof($quizzes) == 0) { ?>
<p>Du har inga godkända quizzer</p>
<?php } else { ?>
<table class="table table-bordered table-striped">
    <?php foreach ($quizzes as $quiz) { 
        if ($quiz['Quiz']['approved'] && !$quiz['Quiz']['deleted']) { ?>
            <tr><td><?php 
            echo $this->Html->link($quiz['Quiz']['name'], array('controller' => 'quizzes', 'action' => 'admin', $quiz['Quiz']['id'])); ?>
            </td></tr>
    <?php }
    } ?>
</table>
<?php } ?>

<h2>Borttagna quizzer</h2>
<?php if (sizeof($quizzes) == 0) { ?>
<p>Du har inga borttagna quizzer</p>
<?php } else { ?>
<table class="table table-bordered table-striped">
    <?php foreach ($quizzes as $quiz) { 
        if ($quiz['Quiz']['deleted']) { ?>
            <tr><td><?php 
            echo $this->Html->link($quiz['Quiz']['name'], array('controller' => 'quizzes', 'action' => 'admin', $quiz['Quiz']['id'])); ?>
            </td></tr>
    <?php }
    } ?>
</table>
<?php } ?>