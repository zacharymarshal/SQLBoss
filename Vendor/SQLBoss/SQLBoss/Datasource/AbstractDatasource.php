<?php

namespace SQLBoss\Datasource;

use \PDO;
use \SqlFormatter;
use \Closure;

abstract class AbstractDatasource
{
    protected $db;

    protected $options;

    protected $default_options = array(
        'username' => null,
        'password' => null,
    );

    public function __construct($options)
    {
        $options = array_filter($options);
        $this->options = $options + $this->default_options;
    }

    public function query($sql)
    {
        // query() must run some things that throw off the query times
        // run a dummy query first to be sure the query times are accurate
        $this->getDb()->query('SELECT 1');

        $queries = SqlFormatter::splitQuery($sql);
        $statements = array();
        foreach ($queries as $query) {
            $time_start = microtime(true);
            $pdo_statement = $this->getDb()->query($query);
            $time_end = microtime(true);
            $time = $time_end - $time_start;
            $statement = $this->statementFactory($pdo_statement);
            $statement->setExecutionTime($time);
            $statements[] = $statement;
        }
        return $statements;
    }

    /**
     * Executes a function in a transaction.
     *
     * The function gets passed this Connection instance as an (optional) parameter.
     *
     * If an exception occurs during execution of the function or transaction commit,
     * the transaction is rolled back and the exception re-thrown.
     *
     * @param Closure $func The function to execute transactionally.
     */
    public function transactional(Closure $func)
    {
        $this->getDb()->beginTransaction();
        try {
            $func($this);
            $this->getDb()->commit();
        } catch (Exception $e) {
            $this->getDb()->rollback();
            throw $e;
        }
    }

    public function getDb()
    {
        if ( ! isset($this->db)) {
            $this->db = new PDO(
                $this->getDsn(),
                $this->options['username'],
                $this->options['password']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $this->db;
    }

    /**
     * Get the PDO dsn string
     * 
     * @return string
     */
    abstract protected function getDsn();

    protected function statementFactory($pdo_statement)
    {
        return new Statement($pdo_statement, $this);
    }
}