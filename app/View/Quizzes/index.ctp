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
<?php if ($current_user) { ?>
    <div class="tools">
    <?php echo $this->element('saveQuiz'); ?>
    </div>
<?php } ?>

<p>Här kan du testa dig på de frågor som lagts in på Partisk.nu och få en indikation på vilka partier du 
    håller med mest i olika frågor.</p><br />

<ul class="list-unstyled">
<?php foreach ($quizzes as $quiz) { ?>
    <li>
    	<?php echo $this->element('quizElement', array('quizSession' => $quizSession, 'quiz' => $quiz, 
                                                       'adminTools' => true)); ?>			
    </li>
<?php } ?>
    <li>
        <?php 
    	echo $this->element('quizElement', array('quizSession' => $quizSession, 'quiz' => $allQuiz, 
                                                 'adminTools' => false)); ?>
    </li>
</ul>

