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
 * @package     app.Model
 * @license     http://opensource.org/licenses/MIT MIT
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
    
    public function getByIdOrName($id) {
        $result = Cache::read('user_' . $id, 'user');
        if (!$result) {
            $this->recursive = -1;
            $this->contain(array("CreatedBy", "UpdatedBy", "Role"));
            
            if (is_numeric($id)) {
                $result = $this->findById($id);
            } else {
                $result = $this->findByUsername($id);    
            }
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