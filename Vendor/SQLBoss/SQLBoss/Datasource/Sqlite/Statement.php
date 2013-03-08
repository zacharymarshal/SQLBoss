<?php

namespace SQLBoss\Datasource\Sqlite;

use \PDO;
use SQLBoss\Datasource\Statement as BaseStatement;

class Statement extends BaseStatement
{
    public function getCount()
    {
        if ( ! $this->isSelect()) {
            return 0;
        }
        $db = $this->datasource->getDb();
        $sql = "SELECT COUNT(*) FROM ({$this->getQuery()})";
        return $db->query($sql)->fetchColumn();
    }
}