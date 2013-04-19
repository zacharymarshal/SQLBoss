<?php

namespace SQLBoss\Datasource;

use \PDO;
use SQLBoss\Datasource\Sqlite\Statement;

class Sqlite extends AbstractDatasource
{
    public function getDsn()
    {
        return "sqlite:{$this->options['dbname']}";
    }

    public function getDatabases()
    {
        return array(array(
            'id'   => $this->getUrlSafeDatabaseName(),
            'name' => $this->options['dbname']
        ));
    }

    protected function statementFactory($pdo_statement)
    {
        return new Statement($pdo_statement, $this);
    }

    protected function getUrlSafeDatabaseName()
    {
        $database = $this->options['dbname'];
        $database = preg_replace('/[^-\w\s]/', '_', $database);
        $database = preg_replace('/^\s+|\s+$/', '', $database);
        $database = preg_replace('/[-\s]+/', '-', $database);
        $database = strtolower($database);
        return trim(trim($database, '-'), '_');
    }
}