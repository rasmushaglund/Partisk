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

if ($this->Permissions->canAddParty()) { ?>
	<?php

	$editMode = isset($edit) && $edit;
	$ajaxMode = isset($ajax) && $ajax;

	?>

	<?php echo $this->Bootstrap->create('Party', array('modal' => true, 'label' => $editMode ? "Ändra parti" : "Lägg till parti", 
	              'id' => $editMode ? $party['Party']['id'] : null, 'ajax' => $ajaxMode, 'editMode' => $editMode)); ?>
	<?php echo $this->Bootstrap->input('name', array('label' => 'Namn', 'placeholder' => 'Namnet på partiet',
				 'value' => $editMode ? $party['Party']['name'] : null)); ?>
	<?php echo $this->Bootstrap->input('website', array('label' => 'Hemsida', 'placeholder' => 'http://www.exempelparti.se', 
				'value' => $editMode ? $party['Party']['website'] : null)); ?>
	<?php echo $this->Bootstrap->textarea('description', array('label' => 'Beskrivning', 
				'placeholder' => 'Här kan du skriva in en kort beskrivning av partiet', 
				'value' => $editMode ? $party['Party']['description'] : null)); ?>
	<?php echo $this->Bootstrap->end($editMode ? "Uppdatera" : "Skapa", array('modal' => true)); ?>
<?php } ?>