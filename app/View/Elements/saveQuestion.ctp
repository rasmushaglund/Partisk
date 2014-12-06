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

if ($this->Permissions->canAddQuestion()) { ?>
	<?php

	$editMode = isset($edit) && $edit;
	$ajaxMode = isset($ajax) && $ajax;

	if (!isset($categoryId) && isset($question['Question']['category_id'])) {
		$categoryId = $question['Question']['category_id'];
	}
        

	?>
    <?php echo $this->Bootstrap->create('Question', array('modal' => true, 'label' => $editMode ? "Ändra fråga" : "Lägg till fråga", 
                    'id' => $editMode ? $question['Question']['revision_id'] : null, 'ajax' => $ajaxMode, 'editMode' => $editMode, 'idName' => 'revision_id')); ?>
    <?php echo $this->Bootstrap->input('title', array('label' => 'Fråga', 'placeholder' => 'Frågan',
                    'value' => $editMode ? $question['Question']['title'] : '')); ?>
                  
    <?php 
        if ($this->Permissions->canAddTag()) {
            echo $this->Bootstrap->input('tags', array('label' => 'Taggar', 'placeholder' => 'Frågans taggar',
                    'value' => $editMode ? $question['Question']['tags'] : '')); 
        } ?>

    <?php if ($this->Permissions->canApproveQuestion() && $editMode) {
        echo $this->Bootstrap->checkbox('approved', array('label' => 'Godkänd', 'type' => 'checkbox',
                    'value' => $editMode ? $question['Question']['approved'] : null)); 
    } ?>
    <?php if ($this->Permissions->canDeleteQuestion() && $editMode) {
        echo $this->Bootstrap->checkbox('deleted', array('label' => 'Borttagen', 'type' => 'checkbox',
                    'value' => $editMode ? $question['Question']['deleted'] : null)); 
    } ?>
    <?php echo $this->Bootstrap->checkbox('done', array('label' => 'Inga fler frågor kan hittas', 'type' => 'checkbox',
                    'value' => $editMode ? $question['Question']['done'] : null)); ?>
    <?php echo $this->Bootstrap->dropdown('type', 'Question', array('label' => 'Typ av fråga', 'options' => 
                    array(array('Question' => array('id' => 'YESNO', 'name' => "Ja/Nej")), 
                          array('Question' => array('id' => 'CHOICE', 'name' => 'Fritext'))), 
    				'selected' => isset($question) ? $question['Question']['type'] : null)); ?>
    <?php echo $this->Bootstrap->textarea('description', array('label' => 'Beskrivning av frågan', 
    				'placeholder' => 'Här kan du beskriva frågan mer i detalj',
    				'value' => $editMode ? $question['Question']['description'] : null)); ?>
    <?php echo $this->Bootstrap->end($editMode ? "Uppdatera" : "Skapa", array('modal' => true)); ?>
<?php } ?>