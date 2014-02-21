<?php

namespace SQLBoss;

class TableDefinition
{
    protected $remote_connection;
    protected $platform;
    protected $sm;
    public $table;

    public function __construct(array $options = array())
    {
        $remote_connection = FALSE;
        $table_name = NULL;
        extract($options, EXTR_IF_EXISTS);

        $this->remote_connection = $remote_connection;

        $this->platform = $this->remote_connection->getDatabasePlatform();
        \Doctrine\DBAL\Types\Type::addType('arrayintegertype', 'SQLBoss\DBAL\Types\ArrayIntegerType');
        $this->platform->registerDoctrineTypeMapping('_int4', 'arrayintegertype');

        $this->sm = $this->remote_connection->getSchemaManager();
        $this->table = $this->sm->listTableDetails($table_name);
    }

    public function getName()
    {
        return $this->table->getShortestName('public');
    }

    public function getCreateSql()
    {
        return $this->platform->getCreateTableSQL($this->table, \Doctrine\DBAL\Platforms\AbstractPlatform::CREATE_FOREIGNKEYS|\Doctrine\DBAL\Platforms\AbstractPlatform::CREATE_INDEXES);
    }

    public function getDropSql()
    {
        return $this->platform->getDropTableSQL($this->table);
    }

    public function getSelectStarSql()
    {
        return <<<SQL
SELECT *
FROM {$this->getName()}
LIMIT 100;
SQL;
    }

    public function getSelectFieldsSql()
    {
        $platform = $this->platform;
        $columns = $this->table->getColumns();
        $columns = implode(",\n\t", Underscore::map($columns, function ($column) use ($platform) { return $column->getQuotedName($platform); }));
        return <<<SQL
SELECT
    {$columns}
FROM {$this->getName()}
LIMIT 100;
SQL;
    }

    public function getInsertSql()
    {
        $platform = $this->platform;
        $columns = $this->table->getColumns();
        $column_fields_sql = implode(",\n\t", Underscore::map($columns, function ($column) use ($platform) { return $column->getQuotedName($platform); }));
        $column_values_sql = implode(",\n\t", Underscore::map($columns, function ($column) { return ":{$column->getName()}"; }));
        return <<<SQL
INSERT INTO {$this->getName()} (
    {$column_fields_sql}
)
VALUES (
    {$column_values_sql}
);
SQL;
    }

    public function getUpdateSql()
    {
        $platform = $this->platform;
        $columns = $this->table->getColumns();
        $column_fields_sql = implode(",\n\t", Underscore::map($columns, function ($column) use ($platform) { return "{$column->getQuotedName($platform)} = ?"; }));
        return <<<SQL
UPDATE {$this->getName()}
SET
    {$column_fields_sql}
WHERE :condition;
SQL;
    }

    public function getDeleteSql()
    {
        return <<<SQL
DELETE FROM {$this->getName()}
WHERE :condition;
SQL;
    }
}
