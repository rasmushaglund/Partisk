<?php 
/** 
 * Delete question view
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

	if ($canDeleteQuestion || (!$question['approved'] && $question['created_by'] == $current_user['id'])) {    
  
            echo $this->Bootstrap->delete('Question', $question['id'], array('label' => "Ta bort fråga", 'modelItem' => $question['title']));  
            
//             echo $this->Bootstrap->create('Question',
//            array('action' => 'delete/'. $question['id'] ,  "id" => "delete" . $question['id'],  'modal' => true, 'icon' => 'fa fa-times', 'class' => "btn btn-danger btn-xs" ));      
//        echo '<p>Är du säker att du vill ta bort ' .  '?</p>';             
//        echo $this->Bootstrap->end("Ta bort", array('modal' => TRUE));
        
        
        
//            echo $this->Form->postLink('<i class="fa fa-times"></i>',
//            array('action' => 'delete', $question['id']),
//    	    array('confirm' => 'Är du säker på att du vill ta bort frågan "' . $question['title'] . '"?', 
//    	    		'class' => 'btn btn-danger btn-xs', 'escape' => false));
	}
?>