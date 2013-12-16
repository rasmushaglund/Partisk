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

$this->Html->addCrumb('Quiz', array('controller' => 'quizzes', 'action' => 'index'));
$this->Html->addCrumb('Översikt');

?>

<h1>Senaste sparade quiz</h1>
<br />
<table class="table table-striped">
<thead>
	<tr>
	<td>GUID</td>
	<td>Version</td>
	<td>Quiz id</td>
	<td>Skapad</td>
	</tr>
</thead>
<tbody>
<?php foreach ($results as $result) { ?>
<tr>
<td><?php echo $this->Html->link($result['QuizResult']['id'],
		                  array('controller' => 'quizzes', 'action' => 'results', 'guid' => $result['QuizResult']['id'])); ?></td>
<td><?php echo $result['QuizResult']['version']; ?></td>
<td><?php echo $result['QuizResult']['quiz_id']; ?></td>
<td><?php echo $result['QuizResult']['created']; ?></td>
</tr>
<?php } ?>
</tbody>
</table>