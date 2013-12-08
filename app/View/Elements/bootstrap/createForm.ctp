<?php
/** 
 * Bootstrap create form view
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
 * @package     app.View.Elements.bootstrap
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

	$method = $id ? "PUT" : "POST";
	$modalId = $controller . (isset($id) ? $id : '');
?>

<?php if ($modal && !$ajax) { ?>
 <a data-toggle="modal" id="<?php echo $modalId; ?>ModalLink" href="#<?php echo $modalId; ?>Modal" class="<?php echo $class; ?>">
 	<i class="<?php echo $icon; ?>"></i> <?php echo $modalLabel; ?></a>
<?php } ?>

<?php if ($modal) { ?>
<div class="modal fade" id="<?php echo $modalId; ?>Modal" tabindex="-1" role="dialog" 
	aria-labelledby="<?php echo $modalId; ?>ModalLabel" aria-hidden="true">
	<form action="<?php echo Router::url('/', false) . $controller; ?>/<?php echo $action; ?>" role="form" id="<?php echo $modalId; ?>AdminForm" method="post" accept-charset="utf-8">
	    <div class="modal-dialog">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	          <h4 class="modal-title"><?php echo $label . $label2; ?></h4>
	        </div>
	        <div class="modal-body">
<?php } else { ?>
			<form action="<?php echo Router::url('/', false) . $controller; ?>/<?php echo $id ? "edit" : "add"; ?>" role="form" id="<?php echo $modalId; ?>AdminForm" method="post" accept-charset="utf-8">
<?php } ?>
				<?php if (!$modal && !empty($label)) { ?><legend><?php echo $label; ?></legend><?php } ?>
			    <div style="display:none;">
			        <input type="hidden" name="_method" value="<?php echo $method; ?>">
			        <?php if ($id) { ?>
			        <input type="hidden" name="data[<?php echo $model; ?>][id]" value="<?php echo $id; ?>">
			        <?php } ?>
			    </div>