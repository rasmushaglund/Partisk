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

if ($canAddQuiz) { ?>
    <?php

    $editMode = isset($edit) && $edit;
    $ajaxMode = isset($ajax) && $ajax;

    ?>

    <?php echo $this->Bootstrap->create('Quiz', array('modal' => true, 'label' => $editMode ? "Ändra quiz" : "Skapa ny quiz", 
                    'id' => $editMode ? $quiz['Quiz']['id'] : null, 'ajax' => $ajaxMode, 'editMode' => $editMode)); ?>
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