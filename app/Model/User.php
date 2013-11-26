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
            'ruleEmpty' => array(
                'rule' => 'alphaNumeric',
                'allowEmpty' => false,
                'message' => 'Fältet får inte vara tomt'
            ),
            'ruleUniqe' => array(
                'rule' => 'isUnique',
                'message' => 'Användarnamnet är redan taget'
            )
        ),
        'password' => array(
            'rule' => array('minLength',8),
            'allowEmpty'=> false,
            'message' => 'Du måste ange ett lösenord med minst åtta tecken'
        ),
        'confirmPassword'  => array(
           'match' => array(
               'rule' => array('match','password'),
               'message' => 'Lösenorden matchar inte'
           )
           
        ),
        
        'email' => array(
            'rule' => array('email',true),
            'allowEmpty' => false,
            'message' => 'Du måste ange en giltig E-Postadress'      
        ),
        'description' => array(
            'rule' => 'notEmpty',
            'message' => 'Fältet får inte vara tomt'
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
    //From Wuilliam Lacruz, http://stackoverflow.com/questions/3760663/cakephp-password-validation/3766745#3766745
    public function match($check, $with) {
    // Getting the keys of the parent field
    foreach ($check as $k => $v) {
        $$k = $v;
    }

    // Removing blank fields
    $check = trim($$k);
    $with = trim($this->data[$this->name][$with]);

    // If both arent empty we compare and return true or false
    if (!empty($check) && !empty($with)) {
        return $check == $with;
    }

    // Return false, some fields is empty
    return false;
}

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = Security::hash($this->data[$this->alias]['password'],'blowfish');
        }
        return true;
    }
}
?>