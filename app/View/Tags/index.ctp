<?php
/** 
 * Tags view
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
 * @package     app.View.Tags
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

$this->Html->addCrumb('Taggar');

if ($tags) {
$chunks = array_chunk($tags, ceil(sizeof($tags) / 3));

?>

<?php if ($current_user) { ?>
<div class="row">
	<div class="col-md-4 tools">
		<?php echo $this->element('saveTag'); ?>
	</div>
</div>
<?php } ?>

<div class="row">
<?php if (isset($chunks[0])) { ?>
<div class="col-md-4">
	<?php echo $this->element('tagsTable', array("tags" => $chunks[0])); ?>
</div>
<?php } if (isset($chunks[1])) { ?>
<div class="col-md-4">
	<?php echo $this->element('tagsTable', array("tags" => $chunks[1])); ?>
</div>
<?php } if (isset($chunks[2])) { ?>
<div class="col-md-4">
	<?php echo $this->element('tagsTable', array("tags" => $chunks[2])); ?>
</div>
<?php } ?>
</div>

<?php 
}
?>