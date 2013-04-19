<?php

namespace SQLBoss\Datasource;

use \PDO;

class Statement
{
    protected $pdo_statement;

    protected $datasource;

    protected $execution_time = 0;

    public function __construct(\PDOStatement $pdo_statement, AbstractDatasource $datasource)
    {
        $this->pdo_statement = $pdo_statement;
        $this->datasource = $datasource;
    }

    public function setExecutionTime($execution_time)
    {
        $this->execution_time = $execution_time;
    }

    public function getExecutionTime()
    {
        return $this->execution_time;
    }

    public function getCount()
    {
        return $this->pdo_statement->rowCount();
    }

    public function getColumns()
    {
        $fields = array();
        for ($column = 0; $column < $this->pdo_statement->columnCount(); $column++) { 
            $fields[] = $this->pdo_statement->getColumnMeta($column);
        }
        return $fields;
    }

    public function getQuery()
    {
        return $this->pdo_statement->queryString;
    }

    public function fetch()
    {
        return $this->pdo_statement->fetch(PDO::FETCH_NUM);
    }

    public function isSelect()
    {
        return (stripos(trim($this->getQuery()), "select") === 0 ? true : false);
    }
}