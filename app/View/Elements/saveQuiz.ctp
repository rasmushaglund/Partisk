<?php 
/** 
 * Save answer view
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

if ($canAddQuiz) { ?>
    <?php

    $editMode = isset($edit) && $edit;
    $ajaxMode = isset($ajax) && $ajax;

    ?>

    <?php echo $this->Bootstrap->create('Quiz', array('modal' => true, 'label' => $editMode ? "Ändra quiz" : "Skapa ny quiz", 
                    'id' => $editMode ? $quiz['Quiz']['id'] : null, 'ajax' => $ajaxMode)); ?>
    <?php echo $this->Bootstrap->input('name', array('label' => 'Namn', 'placeholder' => 'Namnet på quizen',
                     'value' => $editMode ? $quiz['Quiz']['name'] : null)); ?>
    <?php if ($canApproveQuiz && $editMode) {
        echo $this->Bootstrap->checkbox('approved', array('label' => 'Godkänd', 'type' => 'checkbox',
                    'value' => $editMode ? $quiz['Quiz']['approved'] : null)); 
    } ?>
    <?php echo $this->Bootstrap->textarea('description', array('label' => 'Beskrivning', 
                    'placeholder' => 'Skriv in en beskrivning av quizen',
                    'value' => $editMode ? $quiz['Quiz']['description'] : null)); ?>
    <?php echo $this->Bootstrap->end($editMode ? "Uppdatera" : "Skapa", array('modal' => true)); ?>
<?php } ?>