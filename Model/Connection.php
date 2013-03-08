<?php

App::uses('AppModel', 'Model');

class Connection extends AppModel
{
	public $validate = array(
		'user_id' => array(
			'You must have a user' => array(
				'rule'       => 'numeric',
				'allowEmpty' => false,
				'required'   => true,
			),
		),
		'driver' => array(
			'Please select a valid driver' => array(
				'rule'       => array('inList', array('pgsql', 'sqlite', 'mysql')),
				'allowEmpty' => false,
				'required'   => true,
			),
		),
		'label' => 'notempty'
	);

	public $belongsTo = array(
		'User' => array(
			'className'  => 'User',
			'foreignKey' => 'user_id',
		)
	);

	public function getRemoteConnection($connection)
	{
		$driver = $connection['Connection']['driver'];
		if ($driver == 'pgsql') {
			$classname = 'SQLBoss\Datasource\Postgres';
		} elseif ($driver == 'sqlite') {
			$classname = 'SQLBoss\Datasource\Sqlite';
		} elseif ($driver == 'mysql') {
			$classname = 'DatabaseMysql';
		}

		return new $classname(array(
			'host'       => $connection['Connection']['host'],
			'username'   => $connection['Connection']['username'],
			'password'   => $connection['Connection']['password'],
			'dbname'     => $connection['Connection']['database_name'],
		));
	}

	public function beforeValidate()
	{
		if ($this->data['Connection']['driver'] == 'pgsql') {
			$this->validator()
				->add('host', 'required', array(
					'rule'    => 'notEmpty',
					'message' => 'Hostname is required'
				));
		} elseif ($this->data['Connection']['driver'] == 'sqlite') {
			$this->validator()
				->add('database_name', 'required', array(
					'rule'    => 'notEmpty',
					'message' => 'SQLite database name is required'
				));
		}
		return true;
	}

	public function isOwnedBy($connection_id, $user_id)
	{
		return $this->field('id', array('id' => $connection_id, 'user_id' => $user_id)) === (int) $connection_id;
	}
}
