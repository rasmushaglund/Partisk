<?php 
/** 
 * Author information view
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

$createdBy = $object['CreatedBy'];
$updatedBy = $object['UpdatedBy'];


$createdDate = date('Y-m-d', strtotime($object[$model]['created_date']));
$updatedDate = date('Y-m-d', strtotime($object[$model]['updated_date']));

if ($model == "Question" || $model == "Answer") {
	$approvedBy = $object['ApprovedBy'];
	$approvedDate = date('Y-m-d', strtotime($object[$model]['updated_date']));
}

?>
<div class="author-info">
	<?php if (!empty($createdBy['id'])) { ?>
	<p class="description">Skapad av <?php echo $this->Html->link($createdBy['username'], array('controller' => 'users', 'action' => 'view', $createdBy['id'])); ?>
	 <i>(<?php echo $createdDate; ?>)</i>
	<?php if (!empty($updatedBy['id'])) { ?>
		, uppdaterad av <?php echo $this->Html->link($updatedBy['username'], array('controller' => 'users', 'action' => 'view', $updatedBy['id'])); ?>
	 <i>(<?php echo $updatedDate; ?>)</i>
	<?php } ?>
	<?php if (!empty($approvedBy['id'])) { ?>
		, godkänd av <?php echo $this->Html->link($approvedBy['username'], array('controller' => 'users', 'action' => 'view', $approvedBy['id'])); ?>
	 <i>(<?php echo $approvedDate; ?>)</i>
	<?php } ?>
	</p>
</div>
<?php } ?>