<?php
/** 
 * Controller for managing questions
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
 * @package     app.Controller
 * @license     http://www.gnu.org/licenses/ GPLv2
 */

App::uses('UserLogger', 'Log');

class QuestionsController extends AppController {
    public $helpers = array('Html', 'Form');

    public $components = array('Session');

    public function beforeRender() {
        parent::beforeRender();
        $this->set("currentPage", "questions");
    }

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
        $this->loadModel('Party');
        $this->loadModel('Answer');
        $this->Question->recursive = -1;
        $this->Question->Answer->recursive = -1;
        $this->Question->Answer->Party->recursive = -1;

        $conditions = array('deleted' => false);

        if(!$this->isLoggedIn) {
            $conditions['approved'] = true;
        }   

        $questions = $this->Question->getQuestions($conditions);

        $parties = $this->getPartiesOrdered();

        $questionIds = array();
        $partyIds = array();

        foreach ($questions as $question) {
            array_push($questionIds, $question['Question']['id']);  
        }

        foreach ($parties as $party) {
            array_push($partyIds, $party['Party']['id']);
        }

        $answers = $this->Answer->getAnswers(array('partyId' => $partyIds, 'questionId' => $questionIds));
        $answersMatrix = $this->Answer->getAnswersMatrix($questions, $answers);
        
        $this->set('questions', $questions);
        $this->set('parties', $parties);
        $this->set('answers', $answersMatrix);
        $this->set('title_for_layout', 'Frågor');
    }

    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Ogiltig fråga'));
        }

        $this->loadModel('Answer');

        $this->Question->recursive = -1;
        $this->Question->contain(array("CreatedBy", "UpdatedBy", "ApprovedBy", "Tag.id", "Tag.name"));
        $this->Question->Tag->virtualFields['number_of_questions'] = 0;
        $questions = $this->Question->find('all', array(
                'conditions' => array(
                        'Question.id' => $id
                    ),
                'contain' => 'Tag.deleted = false',
                'fields' => array('Question.id, Question.title, Question.created_date, Question.updated_date, Question.description, 
                                   Question.deleted, Question.approved, Question.created_by, Question.approved_by, Question.approved_date')
            ));
        $question = array_pop($questions);
        if (empty($question)) {
            throw new NotFoundException("Ogiltig fråga");
        }

        $answers = $this->Answer->getAnswers(array('questionId' => $id, 'includeParty' => true));

        $this->set('question', $question);
        $this->set('answers', $answers);
        $this->set('title_for_layout', ucfirst($question['Question']['title']));
     }

     public function add() {
        if (!$this->canAddQuestion) {
            $this->abuse("Not authorized to add question");
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post')) {
            $this->Question->create();
            $this->request->data['Question']['created_by'] = $this->Auth->user('id');
            $this->request->data['Question']['created_date'] = date('c');
            $this->request->data['Question']['type'] = "YESNO";
            if ($this->Question->save($this->request->data)) {

                $this->addTags($this->request, $this->Question->getLastInsertId());
                $this->customFlash(__('Frågan skapad.'));
                $this->logUser('add', $this->Question->getLastInsertId(), $this->request->data['Question']['title']);
            } else {
                $this->customFlash(__('Kunde inte skapa frågan.'), 'danger');
                $this->Session->write('validationErrors', $this->Question->validationErrors);
            }

            return $this->redirect($this->referer());
        }
     }

     public function delete($id) {
        if (!$this->userCanDeleteQuestion($this->Auth->user('id'), $id)) {
            $this->abuse("Not authorized to delete question with id " . $id);
            return $this->redirect($this->referer());
        }

        $this->Question->set(
            array('id' => $id,
                  'deleted' => true,
                  'updated_by' => $this->Auth->user('id'),
                  'update_date' => date('c')));

        if ($this->Question->save()) {
            $this->customFlash(__('Tog bort frågan med id: %s.', h($id)));
            $this->logUser('delete', $id);
        } else {
            $this->customFlash(__('Kunde inte ta bort frågan.'), 'danger');
        }

        return $this->redirect($this->referer());
     }

     public function edit($id = null) {
        if (empty($id)) {
            $id = $this->request->data['Question']['id'];
        }

        if (!$this->userCanEditQuestion($this->Auth->user('id'), $id)) {
            $this->abuse("Not authorized to edit question with id " . $id);
            return $this->redirect($this->referer());
        }

        $this->loadModel('Tag');

        if ($this->request->is('post') || $this->request->is('put')) {

            $this->addTags($this->request, $id);

            $this->request->data['Question']['updated_by'] = $this->Auth->user('id');
            $this->request->data['Question']['updated_date'] = date('c');
            if (isset($this->request->data['Question']['approved'])) {
                $this->request->data['Question']['approved'] = true;
                $this->request->data['Question']['approved_by'] = $this->Auth->user('id');
                $this->request->data['Question']['approved_date'] = date('c');
            } else {
                $this->request->data['Question']['approved'] = false;
            }

            if ($this->Question->save($this->request->data)) {
                $this->customFlash(__('Frågan har uppdaterats.'));
                $this->logUser('edit', $id);
            } else {
                $this->customFlash(__('Kunde inte uppdatera frågan.'), 'danger');
            }

            return $this->redirect($this->referer());
        }

        if (!$id) {
            throw new NotFoundException("Ogiltig fråga");
        }

        $this->Question->recursive = -1;
        $questions = $this->Question->find('all', array(
                'conditions' => array('Question.id' => $id),
                'fields' => array('Question.id', 'Question.title', 'Question.description', 'Question.approved')));
        $question = array_pop($questions);

        if (empty($question)) {
            throw new NotFoundException("Ogiltig fråga");
        }

        if (!$this->request->data) {
            $this->request->data = $question;
        }

        $this->Tag->recursive = -1;
        $tags = $this->Tag->find('list', array(
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

        $question['Question']['tags'] = implode($tags, ', ');

        $this->set('tags', $tags);
        $this->set('question', $question);

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $this->set('edit', true);
            $this->set('modal', true);
            $this->set('ajax', true);
            $this->render('/Elements/saveQuestion');
        }
    }

    // Refactor this :(
    private function addTags($request, $questionId) {
            $tagsString = $request->data['Question']['tags'];
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

    public function all() {
        $this->Question->recursive = -1;
        return $this->Question->find('all', 
                array('conditions' => array('Question.deleted' => false),
                      'order' => 'title',
                      'fields' => array('Question.id', 'Question.title')));        
    }

    public function isAuthorized($user) {
        $role = $user['Role']['name'];

        if ($role == 'moderator' && in_array($this->action, array('edit', 'add', 'delete'))) {
            return true;
        }

        if ($role == 'contributor' && in_array($this->action, array('edit', 'add', 'delete'))) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    public function logUser($action, $object_id, $text = "") {
        UserLogger::write(array('model' => 'question', 'action' => $action,
                                'user_id' => $this->Auth->user('id'), 'object_id' => $object_id, 'text' => $text, 'ip' => $this->request->clientIp()));
    }
}

?>