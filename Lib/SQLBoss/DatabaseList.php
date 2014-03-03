<?php

namespace SQLBoss;

use SQLBoss\Cache\Cacher;
use \Connection;

class DatabaseList
{
    protected $user_id;
    protected $connections;
    protected $errors = array();
    protected $databases;
    protected $cacher;
    protected $reset_cache;

    public function __construct($user_id, Connection $connection, Cacher $cacher, $reset_cache = false)
    {
        $this->user_id = $user_id;
        $this->connection = $connection;
        $this->reset_cache = $reset_cache;
        $this->cacher = $cacher;
    }

    public function getConnections()
    {
        if (isset($this->connections)) {
            return $this->connections;
        }

        $this->connections = $this->connection->find('all', array(
            'recursive'  => -1,
            'conditions' => array('user_id' => $this->user_id),
            'order'      => array('Connection.id')
        ));

        return $this->connections;
    }

    public function getDatabases()
    {
        if (isset($this->databases)) {
            return $this->databases;
        }
        $this->databases = array();
        foreach ($this->getConnections() as $connection) {
            $connection = $connection['Connection'];
            try {
                $this->databases = array_merge($this->getDatabasesForConnection($connection), $this->databases);
            } catch (\PDOException $e) {
                $this->errors[] = array(
                    'message'   => "Error connecting to {$connection['label']}",
                    'exception' => $e->getMessage()
                );
            }
        }

        usort($this->databases, function ($db_a, $db_b) {
            return strcmp($db_a['name'], $db_b['name']);
        });

        return $this->databases;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function getDatabasesForConnection($connection)
    {
        $cache_key = "databases_for_connection_{$connection['id']}";
        if ($this->reset_cache) {
            $this->cacher->delete($cache_key);
        }
        if ($databases = $this->cacher->read($cache_key)) {
            return $databases;
        }
        $db = $this->connection->getRemoteConnection($connection);
        $databases = $db->getSchemaManager()->listDatabases();
        $built_out_databases = array();
        // Append the connection information to every row
        // this is useful when displaying the databases
        foreach ($databases as $database) {
            $built_out_databases[] = array(
                'id'         => $database,
                'name'       => $database,
                'Connection' => $connection
            );
        }
        $this->cacher->write($cache_key, $built_out_databases);

        return $built_out_databases;
    }
}
