<?php 
/** 
 * Save question view
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
 ?>
<?php
    $roles = $this->requestAction('roles/all');
?>
    <?php echo $this->Bootstrap->create('User', 
            array('modal' => true, 'label' => "Ansök om konto", 'icon' => 'fa fa-plus', 'class' => "btn btn-info" )); ?>
    
	
	<?php echo $this->Bootstrap->input('username', 
                array('label' => 'Användarnamn' , 'placeholder' => 'Användarnamn')); ?>
	<?php echo $this->Bootstrap->input('email', 
                array('label' => 'E-postadress', 'placeholder' => 'E-postadress')); ?>   
	<?php echo $this->Bootstrap->input('password', 
                array('label' => 'Lösenord', 'type' => 'password', 'placeholder' => 'Lösenord')); ?>
	<?php echo $this->Bootstrap->input('confirmPassword', 
                array('label' => 'Bekräfta Lösenord', 'type' => 'password', 'placeholder' => 'Bekräfta Lösenord')); ?>
	<?php echo $this->Bootstrap->textarea('description', 
                array('label' => 'Motivering', 'placeholder' => 'Här kan du skriva en kort presentation av dig själv och om hur du kan bidra till partisk.nu.')); ?>


    <?php echo $this->Bootstrap->end($editMode = "Skicka", array('modal' => true)); ?>
