<?php
/** 
 * Error view
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

$this->Html->addCrumb('Fel');

?>

<h2>Oj, någonting gick fel!</h2>
<p>Kan du beskriva vad du gjorde när felet uppstod? På så sätt kan vi snabbt åtgärda felet och göra Partisk.nu till en ännu bättre sida!</p>
<br />
<?php echo $this->Bootstrap->create('Feedback'); ?>
<?php echo $this->Bootstrap->textarea('report', array('label' => 'Beskrivning av felet', 
	'placeholder' => 'Skriv in vad som hände när felet uppstod')); ?>
<?php echo $this->Bootstrap->end("Skicka felrapport"); ?>

<?php
if (Configure::read('debug') > 0):
	echo $this->element('exception_stack_trace');
endif;
?>