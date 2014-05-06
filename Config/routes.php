<?php

Router::connect('/', array('controller' => 'databases', 'action' => 'index'));
Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
Router::connect('/assets/*', array('controller' => 'assets', 'action' => 'index'));

Router::connect("/:connection_id-:database/:controller", array('action' => 'index'));
Router::connect("/:connection_id-:database/:controller/:action/*");

CakePlugin::routes();

require CAKE . 'Config' . DS . 'routes.php';
