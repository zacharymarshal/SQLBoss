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

        $table_queries = new TableQueries($remote_connection);
        if (strstr($this->params['pass'][0], '.')) {
            list($schema, $table) = explode('.', $this->params['pass'][0]);
        } else {
            $table = $this->params['pass'][0];
            $schema = 'public';
        }

        $description = new \SQLBoss\Describe\Table($schema, $table, $table_queries);
        $this->set('table_name', $this->params['pass'][0]);
        $this->set('columns', $description->getFields());
        $this->set('indexes', $description->getIndexes());
        $this->set('foreign_keys', $description->getForeignKeys());
        $this->set('triggers', $description->getTriggers());
        $this->set('references', $description->getReferences());
        $this->set('checks', $description->getChecks());
        $this->set('view_definition', $description->getViewDefinition());
    }
}
