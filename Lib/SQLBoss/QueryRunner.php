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
		$remote_connection = NULL;
		$in_transaction = TRUE;
		$multiple_queries = TRUE;
		$sql = '';
		extract($options, EXTR_IF_EXISTS);
		$this->remote_connection = $remote_connection;
		$this->in_transaction = $in_transaction;
		$this->multiple_queries = $multiple_queries;
		$this->sql = $sql;
	}

	public function runQueries()
	{
		$params = $this->getParameters();
		if ($this->multiple_queries === TRUE) {
			$queries = \SqlFormatter::splitQuery($this->sql);
		} else {
			$queries = $this->sql;
		}
		
		$logger = $this->remote_connection->getConfiguration()->getSQLLogger();
		$statements = array();
		foreach ($queries as $query) {
			try {
				$statements[] = array(
					'statement'      => $this->remote_connection->executeQuery($query, $params),
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

	protected function getParameters()
	{
		$params = array();
		preg_match_all("/-- (.*) = (.*)/", $this->sql, $parsed_parameters, PREG_SET_ORDER);
		if ($parsed_parameters) {
			foreach ($parsed_parameters as $parsed) {
				$params[$parsed[1]] = $parsed[2];
			}
		}
		return $params;
	}
}