<?php
/** 
 * Bootstrap textarea view
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

   	$error = isset($validationErrors) && isset($validationErrors[$model][$field]) ? $validationErrors[$model][$field][0] : null;
        $postData = isset($formData) && isset($formData[$model][$field]) ? $formData[$model][$field] : null;
        
        $value = isset($value) ? $value : $postData;
?>

<div class="input text required form-group">
    <label for="<?php echo $id; ?>"><?php echo $label; ?></label>
    <?php if ($error) { ?>
    <p class="error"><?php echo $error; ?></p>
    <?php } ?>
    <textarea name="<?php echo "data[$model][$field]"; ?>" 
               id="<?php echo $id; ?>" placeholder="<?php echo $placeholder; ?>" class="form-control"><?php echo $value; ?></textarea>
</div>