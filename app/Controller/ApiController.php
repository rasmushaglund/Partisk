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
 * @package     app.Controller
 * @license     http://opensource.org/licenses/MIT MIT
 */


App::uses('AppController', 'Controller');

class ApiController extends AppController{
    public $helpers = array('Cache');
       
    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow(array('parties', 'questions', 'answers', 'tags', 'api'));
    }

    public function index(){
        
    }
      
    public function questions($id = null){
        
        $json = Cache::read('questions' . $id, 'api');
        $isSingleObj = isset($id);

        if (!$json) {
            $this->loadModel('Question');
            
            if(!$isSingleObj) {
                $result = Set::extract($this->Question->getQuestions(array('approved' => true, 'deleted' => false, 
                    'fields' => array('question_id', 'title', 'type', 'description', 'created_date', 'updated_date', 'description'))), "/Question/.");
            } else {
                
                $this->loadModel('Tag');
                $result = Set::extract($this->Question->getQuestions(array('question_id' => $id,'approved' => true, 'deleted' => false,
                    'fields' => array('question_id', 'title', 'type', 'description', 'created_date', 'updated_date', 'description', 'id'))), "/Question/.");
                $answers = $answers = $this->Question->Answer->getAnswers(
                        array('questionId' => $id, 'includeParty' => false));
                $result[0]['answers'] = Set::extract($answers, "/Answer/.");
                $tags = $this->Tag->getQuestionTags($result[0]['id']);
                $result[0]['tags'] = Set::extract($tags, "/Tag/id");
                unset($result[0]['id']);
            }

            if (empty($result)) {
                throw new NotFoundException("Ogiltigt question");
            }

            $json = $this->renderJson($result, $isSingleObj);
            Cache::write('questions' . $id, $json, 'api');
        }

        return $json;
                   
    }
    
    public function parties($id = null){
        $json = Cache::read('parties' . $id, 'api');
        $isSingleObj = isset($id);
              
        if (!$json) {     
            $this->loadModel('Party');
            if(!$isSingleObj) {
                $result = Set::extract($this->Party->getPartiesOrdered(),"/Party/.");
            } else {
                $this->Party->recursive = 1;
                $this->Party->contain(array('Answer'));
                $party = $this->Party->findById($id);
                $result = Set::extract($party, "/Party/.");
                $result[0]['answers'] = Set::extract($party, "/Answer/.");
            }
            
            if (empty($result)) {
                throw new NotFoundException("Ogiltigt parti");
            }
                       
            $json = $this->renderJson($result, $isSingleObj);
            Cache::write('parties' . $id, $json, 'api');
        }  
        
        return $json;
    }
     
    public function answers($id = null){
        $json = Cache::read('answers' . $id, 'api');
        $isSingleObj = isset($id);
              
        
        if (!$json) {      
            $this->loadModel('Answer');
            $this->Answer->recursive = -1;
            if(!$isSingleObj) {
                $result = Set::extract($this->Answer->find('all', array('conditions' => 
                    array('deleted' => false, 'approved' => true))), "/Answer/.");
            } else {
                $result = Set::extract($this->Answer->findById($id), "/Answer/.");
            }
            
            if (empty($result)) {
                throw new NotFoundException("Ogiltigt svar");
            } 
            
            $json = $this->renderJson($result, $isSingleObj);
            Cache::write('answers' . $id, $json, 'api');
        }  
        
        return $json;
                   
    }
     
    public function tags($id = null){
        $json = Cache::read('tags' . $id, 'api');
        $isSingleObj = isset($id);
              
        if (!$json) {       
            $this->loadModel('Tag');
            $this->Tag->recursive = -1;
            if (!$isSingleObj) {
                $result = Set::extract($this->Tag->getAllApprovedTags(), '/Tag/.');
            } else {
                $this->loadModel('Question');
                
                $this->Tag->virtualFields['number_of_questions'] = 0;
                $result = Set::extract($this->Tag->findById($id), '/Tag/.');
                unset($result[0]['number_of_questions']);
                $questions = $this->Question->getTagQuestions($id);
                $result[0]['questions'] = Set::extract($questions, "/Question/id");
            }
            
            if (empty($result)) {
                throw new NotFoundException("Ogiltig tagg");
            }
            
            $json = $this->renderJson($result, $isSingleObj);
            Cache::write('tags' . $id, $json, 'api');
        }  
        
        return $json;  
    }
}?>

