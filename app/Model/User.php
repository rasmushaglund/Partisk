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
                'rule' => 'notEmpty',
                'message' => 'Du måste ange ett användarnamn'
            ),
            'ruleUniqe' => array(
                'rule' => 'isUnique',
                'message' => 'Användarnamnet är redan taget'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('minLength', 10),
                'message' => 'Du måste ange ett lösenord som är minst 10 tecken långt'
            )
        ),
        'email' => array(
            'rule' => array('email', false),
            'message' => 'Ogiltig email'
         ),
        'description' => array(
            'between' => array(
                'rule' => array('minLength', 10),
                'message' => 'Skriv in en lite mer utförlig motivering tack'
            )
        ),
        'confirmPassword'  => array(
           'match' => array(
               'rule' => array('match','password'),
               'message' => 'Lösenorden matchar inte'
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
    
    public function getAll() {
        $result = Cache::read('all_users', 'user');
        if (!$result) {
            $this->recursive = -1;
            $result = $this->find('all', array(
                'conditions' => array('deleted' => false),
                'order' => array('username')
            ));
            Cache::write('all_users', $result, 'user');
        }
        
        return $result;
    }
    
    public function getById($id) {
        $result = Cache::read('user_' . $id, 'user');
        if (!$result) {
            $this->recursive = -1;
            $this->contain(array("CreatedBy", "UpdatedBy", "Role"));
            $result = $this->findById($id);
            Cache::write('user_' . $id, $result, 'user');
        }
        
        return $result;
    }
    
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
    
    public function afterSave($created, $options = array()) {
        parent::afterSave($created, $options);
        Cache::clear(false, 'user');
    }
    
    public function afterDelete() {
        parent::afterDelete();
        Cache::clear(false, 'user');
    }
}
?>