<?php 
/** 
 * Party model
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