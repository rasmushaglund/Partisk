<?php
/** 
 * User model
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

App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {    
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Du måste ange ett användarnamn'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Du måste ange ett lösenord'
            )
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'contributor', 'moderator')),
                'message' => 'Du måste ange en giltig roll',
                'allowEmpty' => false
            )
        )
    );

    public $belongsTo = array(
        'Role',
        'CreatedBy' => array(
            'className' => 'User', 
            'foreignKey' => 'created_by',
            'fields' => array('id', 'username')
        ),
        'UpdatedBy' => array(
            'className' => 'User',
            'foreignKey' => 'updated_by',
            'fields' => array('id', 'username')
        )
    );

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = Security::hash($this->data[$this->alias]['password'],'blowfish');
        }
        return true;
    }
}
?>