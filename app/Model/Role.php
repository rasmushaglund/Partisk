<?php
/** 
 * Role model
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
 * @package     app.Model
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

class Role extends AppModel {
    
    public $hasMany = array(
        'User' => array(
            'foreignKey' => 'role'
        ),
    );
    
    public function getAll() {
        $result = Cache::read('all_roles', 'role');
        if (!$result) {
            $this->recursive = -1;
            $result = $this->find('all', array('order' => 'name'));
            Cache::write('all_roles', $result, 'role');
        }
        
        return $result;
    }
    
    public function afterSave($created, $options = array()) {
        parent::afterSave($created, $options);
        Cache::clear(false, 'role');
    }
    
    public function afterDelete() {
        parent::afterDelete();
        Cache::clear(false, 'role');
    }
}
?>