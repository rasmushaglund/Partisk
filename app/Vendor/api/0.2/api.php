<?php

App::import('Vendor', 'api/api');

class Api_0_2 extends Api
{
    public $version = 0.2;

    private $questionFields = array('question_id', 'title', 'type', 'revision_id', 'description', 'created_date', 'updated_date', 'approved_date', 'description');
    private $partyFields = array('id', 'name', 'last_result_parliment', 'last_result_eu', 'color', 'short_name', 'website');
    private $answerFields = array('id', 'answer', 'party_id', 'question_id', 'source', 'created_date', 'updated_date', 'approved_date', 'date', 'description');

    public function questionsIndex(){
        $json = Cache::read('questions', 'api');

        if (!$json) {
            $this->controller->Question->recursive = -1;
            $this->controller->Question->Tag->virtualFields['number_of_questions'] = 0;
            $questions = $this->controller->Question->find('all', array(
                'conditions' => array('approved' => true),
                'fields' => $this->questionFields,
                'contain' => array(
                    'Answer' => array(
                        'fields' => array('id')
                    ),
                    'Tag' => array(
                        'fields' => array('name')
                    ))
            ));

            foreach ($questions as $key => &$value) {
                $value['Question']['answerIds'] = Set::extract($value['Answer'], '/id');
                unset($value['Answer']);

                $value['Question']['tags'] = Set::extract($value['Tag'], '/name');
                unset($value['Tag']);
            }

            $result = Set::extract($questions, "/Question/.");

            if (empty($result)) {
                throw new NotFoundException("Ogiltigt question");
            }

            $json = $this->getJson($result);
            Cache::write('questions', $json, 'api');
        }

        $this->render($json);
    }

    public function questionsView($idString){
        $json = Cache::read('questions' . $idString, 'api');

        if (!$json) {
            $ids = explode(',', $idString);

            $this->controller->Question->recursive = -1;
            $this->controller->Question->Tag->virtualFields['number_of_questions'] = 0;
            $questions = $this->controller->Question->find('all', array(
                'conditions' => array('question_id' => $ids, 'approved' => true),
                'fields' => $this->questionFields,
                'contain' => array(
                    'Answer' => array(
                        'fields' => array('id')
                    ),
                    'Tag' => array(
                        'fields' => array('name')
                    ))
            ));

            foreach ($questions as $key => &$value) {
                $value['Question']['answerIds'] = Set::extract($value['Answer'], '/id');
                unset($value['Answer']);

                $value['Question']['tags'] = Set::extract($value['Tag'], '/name');
                unset($value['Tag']);
            }

            $result = Set::extract($questions, "/Question/.");

            if (empty($result)) {
                throw new NotFoundException("Ogiltigt question");
            }

            if (sizeof($result) === 1) {
                $result = $result[0];
            }

            $json = $this->getJson($result);
            Cache::write('questions' . $idString, $json, 'api');
        }

        $this->render($json);
    }

    public function partiesIndex(){
        $json = Cache::read('parties', 'api');

        if (!$json) {
            $this->controller->loadModel('Party');

            $this->controller->Party->recursive = -1;
            $result = Set::extract($this->controller->Party->find('all', array(
                    'conditions' => array('Party.deleted' => false),
                    'fields' => $this->partyFields)
                ),"/Party/.");

            if (empty($result)) {
                throw new NotFoundException("Ogiltigt parti");
            }

            $json = $this->getJson($result);
            Cache::write('parties', $json, 'api');
        }

        $this->render($json);
    }

    public function partiesView($idString){
        $json = Cache::read('parties' . $idString, 'api');

        if (!$json) {
            $ids = explode(',', $idString);
            $this->controller->loadModel('Party');

            $this->controller->Party->recursive = 1;
            $parties = $this->controller->Party->find('all', array(
                'conditions' => array(
                    'id' => $ids
                ),
                'fields' => $this->partyFields,
                'contain' => array(
                    'Answer' => array(
                        'conditions' => array(
                            'deleted' => false,
                            'approved' => true
                         ),
                        'fields' => array('id')
                    )
                )));

            foreach ($parties as $key => &$value) {
                $value['Party']['answers'] = Set::extract($value['Answer'], '/id');
                unset($value['Answer']);
            }

            $result = Set::extract($parties, "/Party/.");

            if (empty($result)) {
                throw new NotFoundException("Ogiltigt parti");
            }

            if (sizeof($result) === 1) {
                $result = $result[0];
            }

            $json = $this->getJson($result);
            Cache::write('parties' . $idString, $json, 'api');
        }

        $this->render($json);
    }

    public function answersIndex(){
        $json = Cache::read('answers', 'api');
        if (!$json) {
            $this->controller->loadModel('Answer');
            $this->controller->Answer->recursive = -1;

            $result = Set::extract($this->controller->Answer->find('all', array('conditions' =>
                    array('deleted' => false, 'approved' => true), 'fields' => $this->answerFields)), "/Answer/.");

            if (empty($result)) {
                throw new NotFoundException("Ogiltigt svar");
            }

            $json = $this->getJson($result);
            Cache::write('answers', $json, 'api');
        }

        $this->render($json);
    }

    public function answersView($idString){
        $json = Cache::read('answers' . $idString, 'api');

        if (!$json) {
            $ids = explode(',', $idString);
            $this->controller->loadModel('Answer');
            $this->controller->Answer->recursive = -1;

            $result = Set::extract($this->controller->Answer->find('all', array(
                'conditions' => array('id' => $ids, 'approved' => true), 'fields' => $this->answerFields)), '/Answer/.');

            if (sizeof($result) === 1) {
                $result = $result[0];
            }

            if (empty($result)) {
                throw new NotFoundException("Ogiltigt svar");
            }

            $json = $this->getJson($result);
            Cache::write('answers' . $idString, $json, 'api');
        }

        $this->render($json);
    }

    public function tagsIndex(){
        $json = Cache::read('tags', 'api');

        if (!$json) {
            $this->controller->loadModel('Tag');
            $this->controller->Tag->recursive = -1;

            $result = Set::extract($this->controller->Tag->getAllApprovedTags(), '/Tag/.');

            if (empty($result)) {
                throw new NotFoundException("Ogiltig tagg");
            }

            $json = $this->getJson($result);
            Cache::write('tags', $json, 'api');
        }

        $this->render($json);
    }

    public function tagsView($idString){
        $json = Cache::read('tags' . $idString, 'api');

        if (!$json) {
            $ids = explode(',', $idString);

            $this->controller->Tag->recursive = -1;
            $this->controller->Tag->virtualFields['number_of_questions'] = 0;
            $tags = $this->controller->Tag->find('all', array(
                'conditions' => array('id' => $ids),
                'contain' => array(
                    'Question' => array(
                        'conditions' => array('approved' => true, 'deleted' => false),
                        'fields' => array('question_id')
                    )
                )
            ));

            foreach ($tags as $key => &$value) {
                $value['Tag']['questions'] = Set::extract($value['Question'], '/question_id');
                unset($value['Question']);
                unset($value['Tag']['number_of_questions']);
            }

            $result = Set::extract($tags, "/Tag/.");

            if (empty($result)) {
                throw new NotFoundException("Ogiltig tagg");
            }

            if (sizeof($result) === 1) {
                $result = $result[0];
            }

            //$result['number_of_questions'] = sizeof($result['questions']);
            $json = $this->getJson($result);
            Cache::write('tags' . $idString, $json, 'api');
        }

        $this->render($json);
    }

    public function quizzesIndex() {
        $json = Cache::read('quizzes', 'api');

        if (!$json) {
            $this->controller->loadModel('Quiz');
            $this->controller->Quiz->recursive = -1;

            $quizzes = $this->controller->Quiz->find('all', array(
                'conditions' => array('approved' => true, 'deleted' => false),
                'contain' => array(
                    'Question' => array(
                        'conditions' => array('approved' => true, 'deleted' => false),
                        'fields' => array('question_id')
                    )
                )
            ));

            foreach ($quizzes as $key => &$value) {
                $value['Quiz']['number_of_questions'] = $value['Quiz']['questions'];
                $value['Quiz']['questions'] = Set::extract($value['Question'], '/question_id');
                unset($value['Question']);
            }

            $result = Set::extract($quizzes, "/Quiz/.");

            if (empty($result)) {
                throw new NotFoundException("Inga quizzes");
            }

            $json = $this->getJson($result);
            Cache::write('quizzes', $json, 'api');
        }

        $this->render($json);
    }

    public function quizzesView($idString) {
        $json = Cache::read('quizzes' . $idString, 'api');

        if (!$json) {
            $ids = explode(',', $idString);

            $this->controller->loadModel('Quiz');
            $this->controller->Quiz->recursive = -1;

            $quizzes = $this->controller->Quiz->find('all', array(
                'conditions' => array('approved' => true, 'deleted' => false, 'id' => $ids),
                'contain' => array(
                    'Question' => array(
                        'conditions' => array('approved' => true, 'deleted' => false),
                        'fields' => array('question_id')
                    )
                )
            ));

            foreach ($quizzes as $key => &$value) {
                $value['Quiz']['number_of_questions'] = $value['Quiz']['questions'];
                $value['Quiz']['questions'] = Set::extract($value['Question'], '/question_id');
                unset($value['Question']);
            }

            $result = Set::extract($quizzes, "/Quiz/.");

            if (sizeof($result) === 1) {
                $result = $result[0];
            }

            if (empty($result)) {
                throw new NotFoundException("Inga quizzes");
            }

            $json = $this->getJson($result);
            Cache::write('quizzes' . $idString, $json, 'api');
        }

        $this->render($json);
    }
}
