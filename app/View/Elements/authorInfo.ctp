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

$createdBy = $object['CreatedBy'];
$updatedBy = $object['UpdatedBy'];


$createdDate = date('Y-m-d', strtotime($object[$model]['created_date']));
$updatedDate = date('Y-m-d', strtotime($object[$model]['updated_date']));

if ($model == "Question" || $model == "Answer") {
	$approvedBy = $object['ApprovedBy'];
	$approvedDate = date('Y-m-d', strtotime($object[$model]['updated_date']));
}

?>
	<?php if (!empty($createdBy['id'])) { ?>

    <div class="row">
    <div class="col-md-6">    
    <div class="author-info well well-sm">
	<p class="description">Skapad av <?php echo $this->Html->link($createdBy['username'], array('controller' => 'users', 'action' => 'view', 
                                                'name' => $createdBy['username'])); ?>
	 <i>(<?php echo $createdDate; ?>)</i>
	<?php if (!empty($updatedBy['id'])) { ?>
		, senast uppdaterad av <?php echo $this->Html->link($updatedBy['username'], array('controller' => 'users', 'action' => 'view', 
                                                'name' => $updatedBy['username'])); ?>
	 <i>(<?php echo $updatedDate; ?>)</i>
	<?php } ?>
	<?php if (!empty($approvedBy['id'])) { ?>
		, godkänd av <?php echo $this->Html->link($approvedBy['username'], array('controller' => 'users', 'action' => 'view', 
                                                'name' => $approvedBy['username'])); ?>
	 <i>(<?php echo $approvedDate; ?>)</i>
	<?php } ?>
	</p>
</div>
    </div>
</div>
<?php } ?>