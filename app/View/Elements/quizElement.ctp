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
 * @package     app.View.Elements
 * @license     http://opensource.org/licenses/MIT MIT
 */
?>

<h2><?php echo $quiz['Quiz']['name']; ?>
<span class="no-questions">(<?php echo $quiz['Quiz']['questions']; ?> frågor)</span>
</h2>
<p><?php echo $quiz['Quiz']['description']; ?></p>
<?php 
$quizInSession = !empty($quizSession) && $quizSession['QuizSession']['quiz_id'] == $quiz['Quiz']['id'];

if ($quizInSession) { 
    if (!isset($quizSession['QuizSession']['done']) || !$quizSession['QuizSession']['done']) {
        echo $this->Html->link('<i class="fa fa-repeat"></i> Fortsätt quizen', 
                                array('controller' => 'quizzes', 'action' => 'resume', 'id' => $quizSession['QuizSession']['quiz_id']), 
                                array('class' => 'btn btn-info', 'escape' => false)); 
    }

    echo $this->Html->link('<i class="fa fa-refresh"></i> Starta om quizen', 
                                array('controller' => 'quizzes', 'action' => 'restart', 'id' => $quizSession['QuizSession']['quiz_id']), 
                                array('class' => 'btn btn-danger', 'escape' => false)); 

} else { 
    echo $this->Html->link('<i class="fa fa-check-square-o"></i> Starta quizen', 
                            array('controller' => 'quizzes', 'action' => 'start', 'id' => $quiz['Quiz']['id']), 
                            array('class' => 'btn btn-info', 'escape' => false)); 
}

if ($adminTools) {
    echo $this->element('administerQuiz', array('quiz' => $quiz['Quiz'])); 
    echo $this->element('editQuiz', array('quiz' => $quiz['Quiz']));
    echo $this->element('deleteQuiz', array('quiz' => $quiz['Quiz'])); 
}
?>