<?php

Router::connect('/', array('controller' => 'pages', 'action' => 'index'));

/*Router::connect('/about', array('controller' => 'pages', 'action' => 'about'));
Router::connect('/contact', array('controller' => 'pages', 'action' => 'contact'));

Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));*/

// TODO: Remove eventually. For backwards compatibility only.

// Swedish routes
Router::connect('/om', array('controller' => 'pages', 'action' => 'about'));
Router::connect('/kontakt', array('controller' => 'pages', 'action' => 'contact'));
Router::connect('/logga_in', array('controller' => 'users', 'action' => 'login'));
Router::connect('/logga_ut', array('controller' => 'users', 'action' => 'logout'));

Router::connect('/frågor', array('controller' => 'questions', 'action' => 'index'));
Router::connect('/frågor/ej_godkända', array('controller' => 'questions', 'action' => 'notApproved'));
Router::connect('/frågor/utan_beskrivning', array('controller' => 'questions', 'action' => 'noDescription'));
Router::connect('/frågor/:title', array('controller' => 'questions', 'action' => 'view'), array('pass' => array('title')));
Router::connect('/taggar', array('controller' => 'tags', 'action' => 'index'));
Router::connect('/taggar/:name', array('controller' => 'tags', 'action' => 'view'), array('pass' => array('name')));
Router::connect('/partier', array('controller' => 'parties', 'action' => 'index'));
Router::connect('/partier/:name', array('controller' => 'parties', 'action' => 'view'), array('pass' => array('name')));
Router::connect('/partier/:name/ej_besvarade', array('controller' => 'parties', 'action' => 'notAnswered'), array('pass' => array('name')));
Router::connect('/användare', array('controller' => 'users', 'action' => 'index'));
Router::connect('/användare/:name', array('controller' => 'users', 'action' => 'view'), array('pass' => array('name')));

Router::connect('/svar/:id', array('controller' => 'answers', 'action' => 'view'), array('pass' => array('id')));
Router::connect('/answers/info/:id', array('controller' => 'answers', 'action' => 'info'), array('pass' => array('id')));
Router::connect('/answers/tip/:questionId/:partyId', array('controller' => 'answers', 'action' => 'tip'), 
        array('pass' => array('questionId', 'partyId')));
Router::connect('/questions/empty_answer/:questionId/:partyId', array('controller' => 'questions', 'action' => 'emptyAnswer'), 
        array('pass' => array('questionId', 'partyId')));

Router::connect('/quiz', array('controller' => 'quizzes', 'action' => 'index'));
Router::connect('/quiz/frågor', array('controller' => 'quizzes', 'action' => 'questions'));
Router::connect('/quiz/översikt', array('controller' => 'quizzes', 'action' => 'overview'));
Router::connect('/quiz/:id/starta_om', array('controller' => 'quizzes', 'action' => 'restart'), array('pass' => array('id')));
Router::connect('/quiz/:id/fortsätt', array('controller' => 'quizzes', 'action' => 'resume'), array('pass' => array('id')));
Router::connect('/quiz/session_results/:guid', array('controller' => 'quizzes', 'action' => 'sessionResults'), array('pass' => array('guid')));
Router::connect('/quiz/frågor/nästa', array('controller' => 'quizzes', 'action' => 'next'));
Router::connect('/quiz/frågor/föregående', array('controller' => 'quizzes', 'action' => 'prev'));
Router::connect('/quiz/avsluta', array('controller' => 'quizzes', 'action' => 'close'));
Router::connect('/quiz/resultat/:guid', array('controller' => 'quizzes', 'action' => 'results'), array('pass' => array('guid')));
Router::connect('/quiz/results/*', array('controller' => 'quizzes', 'action' => 'results'));
Router::connect('/quiz/:id', array('controller' => 'quizzes', 'action' => 'start'), array('pass' => array('id')));

Router::connect('/frågor/search/:string', array('controller' => 'questions', 'action' => 'search'), array('pass' => array('string')));
Router::connect('/frågor/getCategoryTable/:tagId', array('controller' => 'questions', 'action' => 'getCategoryTable'), array('pass' => array('tagId')));
Router::connect('/frågor/getQuestionSummaryTable/:questionId', array('controller' => 'quizzes', 'action' => 'getQuestionSummaryTable'), array('pass' => array('questionId')));

Router::connect('/api/questions', array('controller' => 'api', 'action' => 'questions'));
Router::connect('/api/questions/:id', array('controller' => 'api', 'action' => 'questions'), array('pass' => array('id')));
Router::connect('/api/parties', array('controller' => 'api', 'action' => 'parties'));
Router::connect('/api/parties/:id', array('controller' => 'api', 'action' => 'parties'), array('pass' => array('id')));
Router::connect('/api/answers', array('controller' => 'api', 'action' => 'answers'));
Router::connect('/api/answers/:id', array('controller' => 'api', 'action' => 'answers'), array('pass' => array('id')));
Router::connect('/api/tags', array('controller' => 'api', 'action' => 'tags'));
Router::connect('/api/tags/:id', array('controller' => 'api', 'action' => 'tags'), array('pass' => array('id')));

// http://deadlytechnology.com/php/cakephp-api-component/
Router::connect('/api/:version', array('controller' => 'api', 'action' => 'info'), array('pass' => array('version')));
Router::connect('/api/:version/:controller/', array('prefix' => 'api', 'action' => 'index', 'api' => true), array('version'=>'[0-9]+\.[0-9]+'));
Router::connect('/api/:version/:controller/:args', array('prefix' => 'api', 'action' => 'view', 'api' => true), 
        array('version'=>'[0-9]+\.[0-9]+', 'pass' => array('args')));

CakePlugin::routes();

require CAKE . 'Config' . DS . 'routes.php';
