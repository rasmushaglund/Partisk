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
 * @package     app.View.Quizzes
 * @license     http://opensource.org/licenses/MIT MIT
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