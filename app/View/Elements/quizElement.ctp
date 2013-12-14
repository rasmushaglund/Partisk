<?php 
/** 
 * Quiz buttons view
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
 * @package     app.View.Elements
 * @license     http://www.gnu.org/licenses/ GPLv2
 */
?>

<h2><?php echo $quiz['Quiz']['name']; ?>
<span class="no-questions">(<?php echo $quiz['Quiz']['questions']; ?> frågor)</span>
</h2>
<p><?php echo $quiz['Quiz']['description']; ?></p>
<?php 
$quizInSession = !empty($quizSession) && $quizSession['QuizSession']['quiz_id'] == $quiz['Quiz']['id'];

if ($quizInSession) { 
    if (isset($quizSession['QuizSession']['done']) && $quizSession['QuizSession']['done']) {
        echo $this->Html->link('<i class="fa fa-bar-chart-o"></i> Till resultatet', 
                                array('controller' => 'quizzes', 'action' => 'results', $quizSession['QuizSession']['id']), 
                                array('class' => 'btn btn-success', 'escape' => false)); 
    } else {
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