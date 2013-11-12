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

if ($canAddAnswer) { ?>
    <?php

    $parties = $this->requestAction('parties/all');
    $questions = $this->requestAction('questions/all');

    $editMode = isset($edit) && $edit;

    if (!isset($partyId) && isset($answer['Answer']['party_id'])) {
    	$partyId = $answer['Answer']['party_id'];
    }

    if (!isset($questionId) && isset($answer['Question']['id'])) {
    	$questionId = $answer['Question']['id'];
    }
    
    $ajaxMode = isset($ajax) && $ajax;

    ?>

    <?php echo $this->Bootstrap->create('Answer', array('modal' => true, 'label' => $editMode ? "Ändra svar" : "Lägg till svar", 
                    'id' => $editMode ? $answer['Answer']['id'] : null, 'ajax' => $ajaxMode)); ?>
    <?php echo $this->Bootstrap->input('answer', array('label' => 'Svar', 'placeholder' => 'Svaret',
                     'value' => $editMode ? $answer['Answer']['answer'] : '')); ?>
    <?php echo $this->Bootstrap->input('source', array('label' => 'Källa', 'placeholder' => 'Källan där svaret hämtades ifrån',
                     'value' => $editMode ? $answer['Answer']['source'] : '')); ?>
    <?php echo $this->Bootstrap->date('date', array('label' => 'Datum för källa', 'placeholder' => 'Datumet källan är ifrån',
                     'value' => $editMode ? $answer['Answer']['date'] : '')); ?>
    <?php echo $this->Bootstrap->dropdown('party_id', 'Party', array('label' => 'Parti', 'options' => $parties, 
    				'selected' => isset($partyId) ? $partyId : null)); ?>
    <?php if ($canApproveAnswer && $editMode) {
        echo $this->Bootstrap->checkbox('approved', array('label' => 'Godkänd', 'type' => 'checkbox',
                    'value' => $editMode ? $answer['Answer']['approved'] : '')); 
    } ?>
    <?php echo $this->Bootstrap->dropdown('question_id', 'Question', array('label' => 'Fråga', 'options' => $questions, 
    				'selected' => isset($questionId) ? $questionId : null, 'titleField' => 'title')); ?>
    <?php echo $this->Bootstrap->textarea('description', array('label' => 'Beskrivning', 
                    'placeholder' => 'Här kan du skriva mer om svaret, t ex ett citat från källan',
                    'value' => $editMode ? $answer['Answer']['description'] : '')); ?>
    <?php echo $this->Bootstrap->end($editMode ? "Uppdatera" : "Skapa", array('modal' => true)); ?>
<?php } ?>