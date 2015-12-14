<?php

App::uses('AppController', 'Controller');

use SQLBoss\Describe\TableQueries;

class SchemaFunctionsController extends AppController
{
    public $components = array(
        'Connection',
    );

    public function index()
    {
        $remote_connection = $this->Connection->getRemoteConnection();
        $this->set('functions', SQLBoss\listFunctions([$remote_connection, 'fetchAll']));
    }

    public function describe()
    {
        $remote_connection = $this->Connection->getRemoteConnection();
        $oid = $this->params['pass'][0];
        $this->set('function', SQLBoss\describeFunction([$remote_connection, 'fetchAssoc'], $oid));
    }
}
