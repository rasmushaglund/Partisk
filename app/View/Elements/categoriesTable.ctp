<?php
/** 
 * Categories table view
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

<table class="table table-bordered table-striped">
<?php foreach ($categories as $category): ?>
    <tr>
        <td>
        	<?php $oneQuestion = $category['Category']['number_of_questions'] == 1; ?>
			<?php echo $this->Html->link(ucfirst($category['Category']['name']),
                            array('controller' => 'categories', 'action' => 'view', $category['Category']['id'])); ?> 
            <?php echo $this->element('categoryAdminToolbox', array('category' => $category)); ?>
            <span class="description">(<?php echo $category['Category']['number_of_questions']; ?>st 
            <?php echo $oneQuestion ? 'fråga' : 'frågor'; ?>)</span>
        </td>
    </tr>
    <?php endforeach; ?>
</table>