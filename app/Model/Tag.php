<?php 
/** 
 * Tag model
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

class Tag extends AppModel {
	public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Du måste ange ett namn på taggen'
            )
        )
    );

    public $hasAndBelongsToMany = array(
        'Question' => array(
            'joinTable' => "question_tags"
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
        ),
        'QuestionTag'
    );

    public $virtualFields = array('number_of_questions' => "count(Question.id)");

    public function getTags($args) {
        $id = isset($args['id']) ? $args['id'] : null;
        $tagDeleted = isset($args['tagDeleted']) ? $args['tagDeleted'] : false;
        $questionDeleted = isset($args['questionDeleted']) ? $args['questionDeleted'] : false;
        $approved = isset($args['approved']) ? $args['approved'] : null;

        $conditions = array();

        if (isset($tagDeleted)) { $conditions['Tag.deleted'] = $tagDeleted; }
        if (isset($questionDeleted)) { $conditions['Question.deleted'] = $questionDeleted; }
        if (isset($approved)) { $conditions['Question.approved'] = $approved; }
                    
        return $this->find('all', array(
                'conditions' => $conditions,
                'fields' => array(
                    'Tag.*'
                    ),
                'joins' => array(
                    array(
                            'table' => 'question_tags as QuestionTag',
                            'conditions' => 'QuestionTag.tag_id = Tag.id'
                        ),
                    array(
                            'table' => 'questions as Question',
                            'conditions' => 'Question.id = QuestionTag.question_id'
                        )
                    ),
                'order' => array('Tag.name'),
                'group' => array('Tag.id')
            ));
    }

    public function getTagStringByQuestionId($id) {
        $tagIds = $this->find('list', array(
                'conditions' => array('Tag.deleted = false', 'Tag.id = QuestionTag.tag_id '),
                'joins' => array(
                        array(
                            'type' => 'left',
                            'table' => 'question_tags as QuestionTag',
                            'conditions' => array('QuestionTag.question_id' => $id)
                            )
                    ),
                'fields' => array('Tag.name')
            ));

        return implode($tagIds, ', ');
    }

    // TODO: Refactor this :(
    public function addTags($data) {
        $questionId = $data['Question']['id'];
        $tagsString = $data['Question']['tags'];
        $tagsArray = array_map('trim', explode(',', strtolower($tagsString)));

        if (!empty($tagsArray)) {
            $questionTags = array();
            $this->Question->Tag->recursive = -1;
            $tagIds = $this->Question->Tag->find('all', 
                array(
                        'conditions' => array('name' => $tagsArray),
                        'fields' => array('Tag.id', 'Tag.name')
                    )
            );

            $this->Question->Tag->QuestionTag->deleteAll(array('QuestionTag.question_id' => $questionId), false);

            $tagHash = array();
            foreach ($tagIds as $tagId) {
                $id = $tagId['Tag']['id'];
                $name = $tagId['Tag']['name'];
                $tagHash[$name] = $tagId['Tag'];
                array_push($questionTags, array(
                    "question_id" => $questionId,
                    "tag_id" => $id));
            }

            $newTags = array();
            foreach ($tagsArray as $tag) {
                if (!isset($tagHash[$tag])) {
                    array_push($newTags, array(
                        "name" => $tag
                        ));
                }
            }

            $this->Question->Tag->saveAll($newTags);
            $newTagIds = $this->Question->Tag->inserted_ids;

            foreach($newTagIds as $id) {
                array_push($questionTags, array(
                        "question_id" => $questionId,
                        "tag_id" => $id
                    ));
            }

            $this->Question->QuestionTag->saveAll($questionTags);
        }
    }
}

?>