<?php

namespace SQLBoss\Describe;

class Table
{
    protected $queries;
    protected $schema;
    protected $table;

    public function __construct($schema, $table, TableQueries $queries)
    {
        $this->schema = $schema;
        $this->table = $table;
        $this->queries = $queries;
    }

    public function getFields()
    {
        $oid = $this->queries->getOid($this->schema, $this->table);

        return $this->queries->getFields($oid);
    }

    public function getIndexes()
    {
        $oid = $this->queries->getOid($this->schema, $this->table);

        $indexes = $this->queries->getIndexes($oid);

        foreach ($indexes as &$index) {
            $definition = array();
            if ($index['contype'] == 'x') {
                $definition[] = $index['pg_get_constraintdef'];
            } else {
                if ($index['indisprimary']) {
                    $definition[] = "PRIMARY KEY,";
                } elseif ($index['indisunique']) {
                    if ($index['contype'] == 'u') {
                        $definition[] = "UNIQUE CONSTRAINT,";
                    } else {
                        $definition[] = "UNIQUE,";
                    }
                }
            }
            $index_def = $index['pg_get_indexdef'];
            $using_pos = strstr($index_def, " USING ");
            if ($using_pos) {
                $index_def = str_replace(" USING ", '', $using_pos);
            }
            $definition[] = $index_def;

            if ($index['condeferrable']) {
                $definition[] = "DEFERRABLE";
            }

            if ($index['condeferred']) {
                $definition[] = "INITIALLY DEFERRED";
            }

            if ($index['indisclustered']) {
                $definition[] = "CLUSTER";
            }

            if (!$index['indisvalid']) {
                $definition[] = "INVALID";
            }

            if ($index['reltablespace']) {
                $definition[] = "REPLICA IDENTITY";
            }

            $index['definition'] = implode(' ', $definition);
        }

        return $indexes;
    }

    public function getChecks()
    {
        $oid = $this->queries->getOid($this->schema, $this->table);

        return $this->queries->getChecks($oid);
    }

    public function getForeignKeys()
    {
        $oid = $this->queries->getOid($this->schema, $this->table);

        return $this->queries->getForeignKeys($oid);
    }

    public function getReferences()
    {
        $oid = $this->queries->getOid($this->schema, $this->table);

        return $this->queries->getReferences($oid);
    }

    public function getTriggers()
    {
        $oid = $this->queries->getOid($this->schema, $this->table);

        $triggers = $this->queries->getTriggers($oid);

        foreach ($triggers as &$trigger) {
            $trigger_def = $trigger['pg_get_triggerdef'];
            $trigger_pos = strstr($trigger_def, " {$trigger['tgname']} ");
            if ($trigger_pos) {
                $trigger_def = str_replace(" {$trigger['tgname']} ", '', $trigger_pos);
            }
            $trigger['definition'] = $trigger_def;
        }

        return $triggers;
    }

    public function getViewDefinition()
    {
        $oid = $this->queries->getOid($this->schema, $this->table);
        $catalog = $this->queries->getCatalog($oid);
        if (!in_array($catalog['relkind'], array('v', 'm'))) {
            return false;
        }

        return $this->queries->getViewDefinition($oid);
    }

    public function getSelectStarSql()
    {
        return <<<SQL
SELECT *
FROM "{$this->schema}"."{$this->table}"
LIMIT 100;
SQL;
    }

    public function getSelectFieldsSql()
    {
        $columns = implode(
            ",\n\t",
            array_map(
                function ($field) {
                    return "\"{$field['column']}\"";
                },
                $this->getFields()
            )
        );

        return <<<SQL
SELECT
\t{$columns}
FROM "{$this->schema}"."{$this->table}"
LIMIT 100;
SQL;
    }

    public function getInsertSql()
    {
        $fields = $this->getFields();
        $column_fields_sql = implode(
            ",\n\t",
            array_map(
                function ($field) {
                    return "\"{$field['column']}\"";
                },
                $fields
            )
        );
        $column_values_sql = implode(
            "\n\t",
            array_map(
                function ($field) {
                    return ":{$field['column']}, -- {$field['type']}";
                },
                $fields
            )
        );

        return <<<SQL
INSERT INTO "{$this->schema}"."{$this->table}" (
\t{$column_fields_sql}
)
VALUES (
\t{$column_values_sql}
);
SQL;
    }

    public function getUpdateSql()
    {
        $column_fields_sql = implode(
            ",\n\t",
            array_map(
                function ($field) {
                    return "\"{$field['column']}\" = ?";
                },
                $this->getFields()
            )
        );

        return <<<SQL
UPDATE "{$this->schema}"."{$this->table}"
SET
\t{$column_fields_sql}
WHERE :condition;
SQL;
    }

    public function getDeleteSql()
    {
        return <<<SQL
DELETE FROM "{$this->schema}"."{$this->table}"
WHERE :condition;
SQL;
    }
}
