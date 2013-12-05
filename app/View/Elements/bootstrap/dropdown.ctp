<?php
/** 
 * Bootstrap dropdown view
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

   	
        $sameMode = isset($validationErrors) && $validationErrors['mode'] == $mode;
   	$error = $sameMode && isset($validationErrors[$model][$field]) ? $validationErrors[$model][$field][0] : null;
        $postData = isset($formData) && $sameMode && isset($formData[$model][$field]) ? $formData[$model][$field] : null;
        
        $selected = isset($selected) ? $selected : $postData;
        
        
?>

<div class="input select form-group">
	<label for="<?php echo $id; ?>"><?php echo $label; ?></label>
	<select name="<?php echo "data[$model][$field]"; ?>" id="<?php echo $id; ?>" class="form-control">
	<?php  foreach ($options as $option) { 
		$isSelected = isset($selected) && $selected == $option[$modelField]['id']; 
                $isDeleted = isset($option[$modelField]['deleted']) && $option[$modelField]['deleted'];
                $isNotApproved = isset($option[$modelField]['approved']) && !$option[$modelField]['approved'];
                $classString = ($isDeleted ? 'dropdown-deleted ' : '') . ($isNotApproved ? 'dropdown-not-approved' : '');
                ?>
	    <option value="<?php echo $option[$modelField]['id']; ?>" class="<?php echo $classString; ?>" <?php echo $isSelected ? 'selected' : ''; ?>>

	    	<?php echo ucfirst($option[$modelField][$titleField]); ?>
	    </option>
	<?php } ?>
	</select>
</div>