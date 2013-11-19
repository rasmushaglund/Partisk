<?php 
/** 
 * Save question view
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

if ($canEditQuiz) { ?>
	<?php

    $questions = $this->requestAction('questions/all');

	?>

    <?php echo $this->Bootstrap->create('Quiz', array('modal' => true, 'label' => "Lägg till fråga till quiz", 'action' => 'addQuestion')); ?>
    <?php echo $this->Bootstrap->hidden('quiz_id', array('value' => $quizId)); ?>
    <?php echo $this->Bootstrap->dropdown('question_id', 'Question', array('label' => 'Fråga', 'options' => $questions, 'titleField' => 'title')); ?>
    <?php echo $this->Bootstrap->end("Lägg till", array('modal' => true)); ?>
<?php } ?>