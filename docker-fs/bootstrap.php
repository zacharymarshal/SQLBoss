<?php

require APP . '/Vendor/autoload.php';

spl_autoload_unregister(array('App', 'load'));
spl_autoload_register(array('App', 'load'), true, true);

Cache::config('default', array('engine' => 'File'));

Cache::config('connection_databases', array(
    'engine'   => 'File',
    'duration' => '+1 hours',
    'path'     => CACHE,
    'prefix'   => 'conn_db_'
));

Configure::write('Dispatcher.filters', array(
    'AssetDispatcher',
    'CacheDispatcher'
));

App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
    'engine' => 'ConsoleLog',
    'types' => array('notice', 'info', 'debug'),
));
CakeLog::config('error', array(
    'engine' => 'ConsoleLog',
    'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
));
