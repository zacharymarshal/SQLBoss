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
