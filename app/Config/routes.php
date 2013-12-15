<?php

Router::connect('/', array('controller' => 'pages', 'action' => 'index'));

/*Router::connect('/about', array('controller' => 'pages', 'action' => 'about'));
Router::connect('/contact', array('controller' => 'pages', 'action' => 'contact'));

Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

// TODO: Remove eventually. For backwards compatibility only.
Router::connect('/quiz/results/*', array('controller' => 'quizzes', 'action' => 'results'));*/

// Swedish routes
Router::connect('/om', array('controller' => 'pages', 'action' => 'about'));
Router::connect('/kontakt', array('controller' => 'pages', 'action' => 'contact'));
Router::connect('/logga_in', array('controller' => 'users', 'action' => 'login'));
Router::connect('/logga_ut', array('controller' => 'users', 'action' => 'logout'));

Router::connect('/frågor', array('controller' => 'questions', 'action' => 'index'));
Router::connect('/frågor/:title', array('controller' => 'questions', 'action' => 'view'), array('pass' => array('title')));
Router::connect('/taggar', array('controller' => 'tags', 'action' => 'index'));
Router::connect('/taggar/:name', array('controller' => 'tags', 'action' => 'view'), array('pass' => array('name')));
Router::connect('/partier', array('controller' => 'parties', 'action' => 'index'));
Router::connect('/partier/:name', array('controller' => 'parties', 'action' => 'view'), array('pass' => array('name')));
Router::connect('/användare', array('controller' => 'users', 'action' => 'index'));
Router::connect('/användare/:name', array('controller' => 'users', 'action' => 'view'), array('pass' => array('name')));

Router::connect('/svar/:id', array('controller' => 'answers', 'action' => 'view'), array('pass' => array('id')));
Router::connect('/answers/info/:id', array('controller' => 'answers', 'action' => 'info'), array('pass' => array('id')));

Router::connect('/quiz', array('controller' => 'quizzes', 'action' => 'index'));
Router::connect('/quiz/frågor', array('controller' => 'quizzes', 'action' => 'questions'));
Router::connect('/quiz/översikt', array('controller' => 'quizzes', 'action' => 'overview'));
Router::connect('/quiz/:id/starta_om', array('controller' => 'quizzes', 'action' => 'restart'), array('pass' => array('id')));
Router::connect('/quiz/:id/fortsätt', array('controller' => 'quizzes', 'action' => 'resume'), array('pass' => array('id')));
Router::connect('/quiz/frågor/nästa', array('controller' => 'quizzes', 'action' => 'next'));
Router::connect('/quiz/frågor/föregående', array('controller' => 'quizzes', 'action' => 'prev'));
Router::connect('/quiz/avsluta', array('controller' => 'quizzes', 'action' => 'close'));
Router::connect('/quiz/:id', array('controller' => 'quizzes', 'action' => 'start'), array('pass' => array('id')));

Router::connect('/api/search/:string', array('controller' => 'questions', 'action' => 'search'), array('pass' => array('string')));

// TODO: Remove eventually. For backwards compatibility only.
Router::connect('/quiz/resultat/*', array('controller' => 'quizzes', 'action' => 'results'));



CakePlugin::routes();

require CAKE . 'Config' . DS . 'routes.php';
