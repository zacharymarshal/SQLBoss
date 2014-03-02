<?php

App::uses('AppController', 'Controller');
App::uses('Connection', 'Model');

class DatabasesController extends AppController
{
    public $components = array(
        'Connection'
    );

    public function isAuthorized($user)
    {
        if ($this->action == 'index') {
            return true;
        }

        return parent::isAuthorized($user);
    }

    public function index()
    {
        $database_list = new SQLBoss\DatabaseList(
            $this->Auth->user('id'),
            new Connection,
            new SQLBoss\Cache\Adapter\CakePhp,
            (isset($this->request->query['reset_cache']))
        );
        $this->set('connections', $database_list->getConnections());
        $this->set('databases', $database_list->getDatabases());
        $this->set('errors', $database_list->getErrors());
    }
}
