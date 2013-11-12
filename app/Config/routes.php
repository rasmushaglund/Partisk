<?php

Router::connect('/', array('controller' => 'pages', 'action' => 'index'));
Router::connect('/about', array('controller' => 'pages', 'action' => 'about'));
Router::connect('/contact', array('controller' => 'pages', 'action' => 'contact'));

Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

CakePlugin::routes();

require CAKE . 'Config' . DS . 'routes.php';
