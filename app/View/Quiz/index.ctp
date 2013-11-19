<?php
/** 
 * Quiz index view
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
 * @package     app.View.Quiz
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

$this->Html->addCrumb('Quiz');

?>

<h1>Quiz</h1>
<p>Här kan du testa dig på de frågor som lagts in på Partisk.nu och få en indikation på vilka partier du håller med mest i olika frågor.</p>
<br />
<?php if ($ongoingQuiz) {
	if ($quizIsDone) {
		echo $this->Html->link('<i class="fa fa-bar-chart-o"></i> Till resultatet', array('controller' => 'quiz', 'action' => 'results', $quizId), 
				array('class' => 'btn btn-success', 'escape' => false)); 
	} else {
		echo $this->Html->link('<i class="fa fa-repeat"></i> Fortsätt quizen', array('controller' => 'quiz', 'action' => 'questions'), 
				array('class' => 'btn btn-info', 'escape' => false)); 
	}
	echo $this->Html->link('<i class="fa fa-refresh"></i> Starta om quizen', array('controller' => 'quiz', 'action' => 'restart'), 
				array('class' => 'btn btn-danger', 'escape' => false)); 
} else {
	echo $this->Html->link('<i class="fa fa-check-square-o"></i> Starta quizen', array('controller' => 'quiz', 'action' => 'questions'), 
				array('class' => 'btn btn-info', 'escape' => false)); 
}
?>

