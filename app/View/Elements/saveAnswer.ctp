<?php 
/**
 * Copyright 2013-2014 Partisk.nu Team
 * https://www.partisk.nu/
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * 
 * @copyright   Copyright 2013-2014 Partisk.nu Team
 * @link        https://www.partisk.nu
 * @package     app.View.Elements
 * @license     http://opensource.org/licenses/MIT MIT
 */

if ($canAddAnswer) { ?>
    <?php

    $parties = $this->requestAction('parties/all');
    $questions = $this->requestAction('questions/all');

    $editMode = isset($edit) && $edit;

    if (!isset($partyId) && isset($answer['Answer']['party_id'])) {
    	$partyId = $answer['Answer']['party_id'];
    }

    if (!isset($questionId) && isset($answer['Answer']['question_id'])) {
    	$questionId = $answer['Answer']['question_id'];
    }
    
    $ajaxMode = isset($ajax) && $ajax;
    ?>

    <?php echo $this->Bootstrap->create('Answer', array('modal' => true, 'label' => $editMode ? "Ändra svar" : "Lägg till svar", 
                    'id' => $editMode ? $answer['Answer']['id'] : null, 'ajax' => $ajaxMode, 'editMode' => $editMode)); ?>
    <?php echo $this->Bootstrap->input('answer', array('label' => 'Svar', 'placeholder' => 'Svaret',
                     'value' => $editMode ? $answer['Answer']['answer'] : null)); ?>
    <?php echo $this->Bootstrap->input('source', array('label' => 'Källa', 'placeholder' => 'Källan där svaret hämtades ifrån',
                     'value' => $editMode ? $answer['Answer']['source'] : null)); ?>
    <?php echo $this->Bootstrap->date('date', array('label' => 'Datum för källa', 'placeholder' => 'Datumet källan är ifrån',
                     'value' => $editMode ? $answer['Answer']['date'] : null)); ?>
    <?php echo $this->Bootstrap->dropdown('party_id', 'Party', array('label' => 'Parti', 'options' => $parties, 
    				'selected' => isset($partyId) ? $partyId : null)); ?>
    <?php if ($canApproveAnswer && $editMode) {
        echo $this->Bootstrap->checkbox('approved', array('label' => 'Godkänd', 'type' => 'checkbox',
                    'value' => $editMode ? $answer['Answer']['approved'] : null)); 
    } ?>
    <?php echo $this->Bootstrap->dropdown('question_id', 'Question', array('label' => 'Fråga', 'options' => $questions, 
    				'selected' => isset($questionId) ? $questionId : null, 'titleField' => 'title')); ?>
    <?php echo $this->Bootstrap->textarea('description', array('label' => 'Beskrivning', 
                    'placeholder' => 'Här kan du skriva mer om svaret, t ex ett citat från källan',
                    'value' => $editMode ? $answer['Answer']['description'] : null)); ?>
    <?php echo $this->Bootstrap->end($editMode ? "Uppdatera" : "Skapa", array('modal' => true)); ?>
<?php } ?>