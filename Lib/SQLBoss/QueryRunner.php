<?php

namespace SQLBoss;

class QueryRunner
{
    protected $remote_connection;
    protected $in_transaction;
    protected $multiple_queries;
    protected $sql;
    protected $errors = array();

    public function __construct(array $options)
    {
        $remote_connection = null;
        $in_transaction = true;
        $multiple_queries = true;
        $sql = '';
        extract($options, EXTR_IF_EXISTS);
        $this->remote_connection = $remote_connection;
        $this->in_transaction = $in_transaction;
        $this->multiple_queries = $multiple_queries;
        $this->sql = $sql;
    }

    public function runQueries()
    {
        if ($this->multiple_queries === true) {
            $queries = \SqlFormatter::splitQuery($this->sql);
        } else {
            $queries = $this->sql;
        }

        $logger = $this->remote_connection->getConfiguration()->getSQLLogger();
        $statements = array();
        foreach ($queries as $query) {
            try {
                $statements[] = array(
                    'statement'      => $this->remote_connection->executeQuery($query),
                    'query'          => $logger->queries[$logger->currentQuery]['sql'],
                    'execution_time' => $logger->queries[$logger->currentQuery]['executionMS'],
                );
            } catch (\Exception $e) {
                $this->errors[] = $e->getMessage();
            }
        }

        return $statements;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
