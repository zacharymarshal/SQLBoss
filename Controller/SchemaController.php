<?php

App::uses('AppController', 'Controller');

class SchemaController extends AppController
{
    public $components = array(
        'Connection'
    );

    public function index()
    {
        $remote_connection = $this->Connection->getRemoteConnection();
        $this->set('tables', $remote_connection->getSchemaManager()->listTableNames());
    }

    public function tableDescribe()
    {
        $remote_connection = $this->Connection->getRemoteConnection();

        $table_queries = new \SQLBoss\Describe\TableQueries($remote_connection);
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

    public function tableDefinition()
    {
        $remote_connection = $this->Connection->getRemoteConnection();

        $table_definition = new \SQLBoss\TableDefinition(array(
            'remote_connection' => $remote_connection,
            'table_name'        => $this->params['pass'][0]
        ));

        $this->set('table_name', $table_definition->getName());
        $this->set('table_sql', $table_definition->getCreateSql());
        $this->set('drop_table_sql', $table_definition->getDropSql());
    }
}
