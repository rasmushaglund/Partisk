<?php
/** 
 * Controller for managing general pages
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

App::uses('AppController', 'Controller');

class PagesController extends AppController {
    
    var $helpers = array('Cache');
    public $cacheAction = array(
        'index' => array('callbacks' => true, 'duration' => '1 week'));
    
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
        $answers = $this->Answer->getAnswers(array('questionId' => $questionIds, 'includeParty' => true));
        $answersMatrix = $this->Answer->getAnswersMatrix($questions, $answers);
        
        $this->set('questions', $questions);
        $this->set('parties', $parties);
        $this->set('answers', $answersMatrix);        
        $this->set('title_for_layout', 'Hem');
        $this->currentPage = "home";
    }

    public function about() {
        $this->set('title_for_layout', 'Om sidan');
        $this->currentPage = "about";
    }

    public function contact() {
        $this->set('title_for_layout', 'Kontakt');
        $this->currentPage = "contact";
    }
}
