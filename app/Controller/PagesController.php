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

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');

class PagesController extends AppController {
    public $helpers = array('Cache');
    public $cacheAction = "+999 days";
    
    private $currentPage = "default";

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('contact', 'about'));
    }

    public function beforeRender() {
        parent::beforeRender();
        $this->set("currentPage", $this->currentPage);
    }

    public function index() {
        $this->loadModel('Question');
        
        $questions = $this->Question->getLatestQuestions();
        $questionIds = $this->Question->getIdsFromModel('Question', $questions);
        
        $this->loadModel('Party');
        $parties = $this->Party->getPartiesOrdered();

        $this->loadModel('Answer');
        $answers = $this->Answer->getAnswers(array('questionId' => $questionIds, 'includeParty' => true, 'approved' => true));
        $answersMatrix = $this->Answer->getAnswersMatrix($questions, $answers);
        
        $this->set('questions', $questions);
        $this->set('parties', $parties);
        $this->set('answers', $answersMatrix);        
        $this->set('title_for_layout', 'Hem');
        $this->set('description_for_layout', "Välkommen till Partisk.nu");
        $this->currentPage = "home";
    }

    public function about() {
        $this->set('title_for_layout', 'Om sidan');
        $this->set('description_for_layout', "Om Partisk.nu");
        $this->currentPage = "about";
    }

    public function contact() {
        $this->set('title_for_layout', 'Kontakt');
        $this->set('description_for_layout', "Kontakta oss");
        $this->currentPage = "contact";
    }

    public function logga_in() {
        $this->set('title_for_layout', 'Logga in');
        $this->set('description_for_layout', "Logga in eller ansök om konto");
        $this->currentPage = "logga_in";
    }
}
