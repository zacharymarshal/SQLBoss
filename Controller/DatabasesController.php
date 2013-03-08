<?php

App::uses('AppController', 'Controller');
App::uses('Connection', 'Model');
App::uses('Hash', 'Utility');

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
		$connection = new Connection();
		$connections = $connection->find('all', array(
			'conditions' => array('user_id' => $this->Auth->user('id')),
			'order'      => array('Connection.id')
		));
		
		$this->set('connections', $connections);

		$all_databases = array();
		foreach ($connections as $connection_row) {
			$db = $connection->getRemoteConnection($connection_row);
			$cache_key = "databases_for_server_{$connection_row['Connection']['id']}";
			$databases = Cache::read($cache_key);
			if ( ! $databases) {
				$databases = $db->getDatabases();
				foreach ($databases as &$database) {
					$database = $database + $connection_row;
				}
				Cache::write($cache_key, $databases);
			}
			$all_databases = array_merge($all_databases, $databases);
		}
		
		$databases_sorted_by_name = Hash::sort($all_databases, '{n}.name', 'asc');
		$this->set('databases', $databases_sorted_by_name);
	}
}
