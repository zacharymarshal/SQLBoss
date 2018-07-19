<?php

Configure::write('debug', 1);

Configure::write('App.baseUrl', env('SCRIPT_NAME'));

Configure::write('Error', array(
    'handler' => 'ErrorHandler::handleError',
    'level'   => E_ALL & ~E_DEPRECATED,
    'trace'   => true
));

Configure::write('Exception', array(
    'handler'  => 'ErrorHandler::handleException',
    'renderer' => 'ExceptionRenderer',
    'log'      => true
));

Configure::write('App.encoding', 'UTF-8');

define('LOG_ERROR', LOG_ERR);

Configure::write('Session', array(
    'defaults'       => 'database',
    'autoRegenerate' => true
));

Configure::write('Security.level', 'medium');

Configure::write('Security.salt', getenv('CAKEPHP_SALT'));

Configure::write('Security.cipherSeed', getenv('CAKEPHP_CIPHER'));

Configure::write('Acl.classname', 'DbAcl');

date_default_timezone_set('America/Los_Angeles');

$engine = 'File';
if (extension_loaded('apc') && function_exists('apc_dec') && (php_sapi_name() !== 'cli' || ini_get('apc.enable_cli'))) {
    $engine = 'Apc';
}

// In development mode, caches should expire quickly.
$duration = '+999 days';
if (Configure::read('debug') >= 1) {
    $duration = '+10 seconds';
}

// Prefix each application on the same server with a different string, to avoid Memcache  APC conflicts.
$prefix = 'sqlboss_';

Cache::config('_cake_core_', array(
    'engine'    => $engine,
    'prefix'    => $prefix . 'cake_core_',
    'path'      => CACHE . 'persistent' . DS,
    'serialize' => ($engine === 'File'),
    'duration'  => $duration
));

Cache::config('_cake_model_', array(
    'engine'    => $engine,
    'prefix'    => $prefix . 'cake_model_',
    'path'      => CACHE . 'models' . DS,
    'serialize' => ($engine === 'File'),
    'duration'  => $duration
));
