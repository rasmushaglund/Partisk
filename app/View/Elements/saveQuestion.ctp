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

if ($canAddQuestion) { ?>
	<?php

	$tags = $this->requestAction('tags/all');
	$editMode = isset($edit) && $edit;
	$ajaxMode = isset($ajax) && $ajax;

	if (!isset($categoryId) && isset($question['Question']['category_id'])) {
		$categoryId = $question['Question']['category_id'];
	}

	?>
    <?php echo $this->Bootstrap->create('Question', array('modal' => true, 'label' => $editMode ? "Ändra fråga" : "Lägg till fråga", 
                    'id' => $editMode ? $question['Question']['id'] : null, 'ajax' => $ajaxMode)); ?>
    <?php echo $this->Bootstrap->input('title', array('label' => 'Fråga', 'placeholder' => 'Frågan',
                    'value' => $editMode ? $question['Question']['title'] : '')); ?>
                  
    <?php 
        if ($canAddTag) {
            echo $this->Bootstrap->input('tags', array('label' => 'Taggar', 'placeholder' => 'Frågans taggar',
                    'value' => $editMode ? $question['Question']['tags'] : '')); 
        } ?>

    <?php if ($canApproveQuestion && $editMode) {
        echo $this->Bootstrap->checkbox('approved', array('label' => 'Godkänd', 'type' => 'checkbox',
                    'value' => $editMode ? $question['Question']['approved'] : null)); 
    } ?>
    <?php echo $this->Bootstrap->textarea('description', array('label' => 'Beskrivning av frågan', 
    				'placeholder' => 'Här kan du beskriva frågan mer i detalj',
    				'value' => $editMode ? $question['Question']['description'] : null)); ?>
    <?php echo $this->Bootstrap->end($editMode ? "Uppdatera" : "Skapa", array('modal' => true)); ?>
<?php } ?>