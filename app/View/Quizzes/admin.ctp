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

$this->Html->addCrumb('Quiz', '/quizzes/');
$this->Html->addCrumb(ucfirst($quiz['Quiz']['name']));
?>

<?php if ($this->Permissions->isLoggedIn()) { ?>
	<div class="tools">
            <?php
            if ($this->Permissions->canEditQuiz()) { 
                echo $this->Bootstrap->create('Quiz', array('modal' => true, 'label' => "Lägg till fråga till quiz", 'action' => 'addQuestion'));
                echo $this->Bootstrap->hidden('quiz_id', array('value' => $quiz['Quiz']['id']));
                echo $this->Bootstrap->dropdown('question_id', 'Question', array('label' => 'Fråga', 'options' => $availableQuestions, 'titleField' => 'title'));
                echo $this->Bootstrap->end("Lägg till", array('modal' => true));
            } ?>
	</div>

<?php } ?>

<table class="table table-bordered table-striped">
<?php if (!empty($questions)) { 
	foreach ($questions as $question) { ?>
	<tr><td><?php echo $this->Html->link($question['Question']['title'], array('controller' => 'questions', 'action' => 'view', 
            $question['Question']['id'])); ?></td>
            <td><?php echo $this->element('deleteQuizQuestion', array('questionQuiz' => $question['QuestionQuiz'])); ?></td>
        </tr>	
<?php }
} ?>
</table>

