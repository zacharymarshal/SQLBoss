<?php

namespace SQLBoss\Datasource;

use \PDO;

class Postgres extends AbstractDatasource
{
    protected $default_options = array(
        'username' => null,
        'password' => null,
        'dbname'   => 'postgres'
    );

    public function getDsn()
    {
        return "pgsql:dbname={$this->options['dbname']};host={$this->options['host']}";
    }

    public function getDatabases()
    {
        $sql = "
            SELECT datname AS \"id\", datname AS \"name\"
            FROM pg_database
            ORDER BY datname
        ";
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute();
        $databases = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $databases[] = $row;
        }
        return $databases;
    }
}