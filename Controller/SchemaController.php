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
		Doctrine\DBAL\Types\Type::addType('arrayintegertype', 'SQLBoss\DBAL\Types\ArrayIntegerType');
		$remote_connection = $this->Connection->getRemoteConnection();
		$platform = $remote_connection->getDatabasePlatform();
		$platform->registerDoctrineTypeMapping('_int4', 'arrayintegertype');
		$sm = $remote_connection->getSchemaManager();
		$table = $sm->listTableDetails($this->params['pass'][0]);

		$this->set('table_sql', $platform->getCreateTableSQL($table));
		$this->set('drop_table_sql', $platform->getDropTableSQL($table));
	}
}
