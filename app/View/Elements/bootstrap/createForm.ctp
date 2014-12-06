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
 * @package     app.View.Elements.bootstrap
 * @license     http://opensource.org/licenses/MIT MIT
 */

	$method = $id ? "PUT" : "POST";
	$modalId = $controller . (isset($id) ? $id : '');
?>

<?php if ($modal && !$ajax) { ?>
 <a data-toggle="modal" id="<?php echo $modalId; ?>ModalLink" href="#<?php echo $modalId; ?>Modal" class="<?php echo $class; ?>">
 	<i class="<?php echo $icon; ?>"></i> <?php echo $modalLabel; ?></a>
<?php } ?>

<?php if ($modal) { ?>
<div class="modal fade" id="<?php echo $modalId; ?>Modal" tabindex="-1" role="dialog" aria-hidden="true">
	<form action="<?php echo Router::url('/', false) . $controller; ?>/<?php echo $action; ?>" role="form" id="<?php echo $modalId; ?>AdminForm" method="post" accept-charset="utf-8">
	    <div class="modal-dialog">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	          <h4 class="modal-title"><?php echo $label; ?></h4>
	        </div>
	        <div class="modal-body">
<?php } else { ?>
			<form action="<?php echo Router::url('/', false) . $controller; ?>/<?php echo $id ? "edit" : "add"; ?>" role="form" id="<?php echo $modalId; ?>AdminForm" method="post" accept-charset="utf-8">
<?php } ?>
				<?php if (!$modal && !empty($label)) { ?><legend><?php echo $label; ?></legend><?php } ?>
			    <div style="display:none;">
			        <input type="hidden" name="_method" value="<?php echo $method; ?>">
			        <?php if ($id) { ?>
			        <input type="hidden" name="data[<?php echo $model; ?>][<?php echo $idName; ?>]" value="<?php echo $id; ?>">
			        <?php } ?>
			    </div>