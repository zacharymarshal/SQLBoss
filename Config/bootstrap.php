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
    'engine' => 'FileLog',
    'types' => array('notice', 'info', 'debug'),
    'file' => 'debug',
));
CakeLog::config('error', array(
    'engine' => 'FileLog',
    'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
    'file' => 'error',
));
