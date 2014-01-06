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

    public $virtualFields = array('number_of_questions' => "count(Question.id)",
                                  'approved_questions' => "Question.approved");

    public function getTags($args = null) {
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
    
    public function getAllTags() {
        $result = Cache::read('all_tags', 'tag');
        if (!$result) {
            $this->recursive = -1;
            $result = $this->getTags();
            Cache::write('all_tags', $result, 'tag');
        }
        
        return $result;
    }
    
    public function getAllApprovedTags() {
        $result = Cache::read('all_approved_tags', 'tag');
        if (!$result) {
            $this->recursive = -1;
            $result = $this->getTags(array('approved' => true));
            Cache::write('all_approved_tags', $result, 'tag');
        }
        
        return $result;
        
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
    public function addTags($data, $questionId) {
        Cache::clear(false, 'tag');
        
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
    
    public function getAllList() {
        $result = Cache::read('all_list_tags', 'tag');
        if (!$result) {
            $this->recursive = -1;
            $result = $this->find('all', 
                    array('conditions' => array('Tag.deleted' => false),
                          'order' => 'name',
                          'fields' => array('Tag.id', 'Tag.name')));
            Cache::write('all_list_tags', $result, 'tag');
        }
        
        return $result;
    }
    
    public function getByIdOrName($id) {
        $result = Cache::read('tag_' . $id, 'tag');
        if (!$result) {
            
            if (is_numeric($id)) {
                $conditions = array('Tag.id' => $id);
            } else {
                $conditions = array('Tag.name like' => $id);
            }
            
            $this->contain(array("CreatedBy", "UpdatedBy"));
            $tags = $this->find('all', array(
                    'conditions' => $conditions,
                    'fields' => array('Tag.id', 'Tag.name' ,'Tag.created_date' ,'Tag.updated_date')
                ));

            $result = array_pop($tags);
            Cache::write('tag_' .$id, $result, 'tag');
        }
        
        return $result;
    }
    
    public function afterSave($created, $options = array()) {
        parent::afterSave($created, $options);
        Cache::clear(false, 'tag');
        Cache::clear(false, 'question');
        clearCache(array('partisk_tag*', 'partisk_'));
    }
    
    public function afterDelete() {
        parent::afterDelete();
        Cache::clear(false, 'tag');
        Cache::clear(false, 'question');
    }
}

?>