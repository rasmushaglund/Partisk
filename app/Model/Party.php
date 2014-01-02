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

class Party extends AppModel {
    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Du måste ange ett partinamn'
            )
        ),
        'website' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Du måste ange en hemsida'
            )
        )
    );

	public $hasMany = array(
        'Answer' => array(
            'className' => 'Answer'
        )
    );

    public $belongsTo = array(
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

    public $virtualFields = array(
        'best_result' => 'greatest(last_result_parliment, last_result_eu)'
    );

    public function getPartiesHash() {
        $this->recursive = -1;
        $result = array();

        $parties = $this->getPartiesOrdered();
        $index = 0;
        foreach ($parties as $party) {
            $party['Party']['order'] = $index++;
            $result[$party['Party']['id']] = $party['Party'];
        }

        return $result;
    }

    public function getPartiesOrdered() {
        $result = Cache::read('parties_ordered', 'party');
        if (!$result) {
            $this->recursive = -1;
            $result = $this->find('all', array(
                    'conditions' => array('Party.deleted' => false),
                    'fields' => array('id', 'name', 'best_result', 'last_result_parliment', 'last_result_eu', 'color'),
                    'order' => 'Party__best_result DESC')
                );
            Cache::write('parties_ordered', $result, 'party');
        }
        return $result;
    }
    
    
    public function getByIdOrName($id) {
        $result = Cache::read('party_' . $id, 'party');
        if (!$result) {
            
            $this->recursive = -1;
            $this->contain(array('CreatedBy', 'UpdatedBy'));
            
            if (is_numeric($id)) {
                $result = $this->findById($id);
            
            } else {
                $result = $this->findByName($id);
            }
            
            Cache::write('party_' . $id, $result, 'party');
        }
        return $result;
    }

    public function getIdsFromParties($parties) {
        $partyIds = array();

        foreach ($parties as $party) {
            array_push($partyIds, $party['Party']['id']);
        }

        return $partyIds;
    }
    
    public function afterSave($created, $options = array()) {
        parent::afterSave($created, $options);
        Cache::clear(false, 'party');
    }
    
    public function afterDelete() {
        parent::afterDelete();
        Cache::clear(false, 'party');
    }
}

?>