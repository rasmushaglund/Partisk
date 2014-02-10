<?php
/** 
 * Welcome page
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
 * @package     app.View.Pages
 * @license     http://www.gnu.org/licenses/ GPLv2
 */
 ?>

<div class="row">
	<div class="col-md-6">
		<h2>Partisk.nu</h2>
		<p>Välkommen till Partisk.nu med den stora uppgiften att hjälpa er att hitta rätt bland alla partiers åsikter. 
		Här kan du söka runt bland 
		<?php echo $this->Html->link('frågor/svar',
		                  array('controller' => 'questions', 'action' => 'index')); ?> och dessutom göra en 
		<?php echo $this->Html->link('quiz',
		                  array('controller' => 'quiz', 'action' => 'index')); ?> för att se hur mycket du håller med olika partier.</p>
        <?php echo $this->Html->link('<i class="fa fa-success"></i> Testa dig nu!', array('controller' => 'quizzes', 'action' => 'index'),
                  array('class' => 'btn btn-success btn-xl', 'escape' => false)); ?>
	</div>

	<div class="col-md-6">
		<h2>Senaste frågorna</h2>
		<ul>
		<?php foreach ($questions as $question): ?>
		    <li>
		        <?php echo $this->Html->link($question['Question']['title'],
		                  array('controller' => 'questions', 'action' => 'view', $question['Question']['id'])); ?>
		    </li>
		 <?php endforeach; ?>
		 </ul>
	 </div>
 </div>
