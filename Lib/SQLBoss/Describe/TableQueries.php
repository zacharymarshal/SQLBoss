<?php

namespace SQLBoss\Describe;

class TableQueries
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getOid($schema, $table)
    {
        $sql = <<<SQL
SELECT
    c.oid,
    n.nspname,
    c.relname
FROM pg_catalog.pg_class c
LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace
WHERE c.relname ~ :table
    AND n.nspname ~ :schema
ORDER BY 2, 3
SQL;

        return $this->db->fetchColumn(
            $sql,
            array(
                'schema' => "^({$schema})$",
                'table'  => "^({$table})$",
            )
        );
    }

    public function getCatalog($oid)
    {
        $sql = <<<SQL
SELECT
    c.relchecks,
    c.relkind,
    c.relhasindex,
    c.relhasrules,
    c.relhastriggers,
    c.relhasoids,
    c.reltablespace,
    CASE WHEN c.reloftype = 0 THEN '' ELSE c.reloftype::pg_catalog.regtype::pg_catalog.text END,
    c.relpersistence
FROM pg_catalog.pg_class c
LEFT JOIN pg_catalog.pg_class tc ON (c.reltoastrelid = tc.oid)
WHERE c.oid = :oid
SQL;

        return $this->db->fetchAssoc($sql, array('oid' => $oid));
    }

    public function getFields($oid)
    {
        $sql = <<<SQL
SELECT
    a.attnum AS ordinal_position,
    a.attname AS column,
    pg_catalog.format_type(a.atttypid, a.atttypmod) AS type,
    (
        SELECT substring(pg_catalog.pg_get_expr(d.adbin, d.adrelid) for 128)
        FROM pg_catalog.pg_attrdef d
        WHERE d.adrelid = a.attrelid AND d.adnum = a.attnum AND a.atthasdef
    ) AS default,
    a.attnotnull AS not_null,
    (
        SELECT c.collname
        FROM pg_catalog.pg_collation c, pg_catalog.pg_type t
        WHERE c.oid = a.attcollation AND t.oid = a.atttypid AND a.attcollation <> t.typcollation
    ) AS collate,
    pg_catalog.col_description(a.attrelid, a.attnum) AS comment
FROM pg_catalog.pg_attribute a
WHERE a.attrelid = :oid
    AND a.attnum > 0
    AND NOT a.attisdropped
ORDER BY ordinal_position
SQL;

        return $this->db->fetchAll($sql, array('oid' => $oid));
    }

    public function getIndexes($oid)
    {
        $sql = <<<SQL
SELECT
    c2.relname,
    i.indisprimary,
    i.indisunique,
    i.indisclustered,
    i.indisvalid,
    pg_catalog.pg_get_indexdef(i.indexrelid, 0, true),
    pg_catalog.pg_get_constraintdef(con.oid, true),
    contype,
    condeferrable,
    condeferred,
    c2.reltablespace
FROM pg_catalog.pg_class c, pg_catalog.pg_class c2, pg_catalog.pg_index i
LEFT JOIN pg_catalog.pg_constraint con ON (conrelid = i.indrelid AND conindid = i.indexrelid AND contype IN ('p','u','x'))
WHERE c.oid = :oid AND c.oid = i.indrelid AND i.indexrelid = c2.oid
ORDER BY i.indisprimary DESC, i.indisunique DESC, c2.relname
SQL;

        return $this->db->fetchAll($sql, array('oid' => $oid));
    }

    public function getChecks($oid)
    {
        $sql = <<<SQL
SELECT
    r.conname,
    pg_catalog.pg_get_constraintdef(r.oid, true) AS condef
FROM pg_catalog.pg_constraint r
WHERE r.conrelid = :oid
    AND r.contype = 'c'
ORDER BY 1
SQL;

        return $this->db->fetchAll($sql, array('oid' => $oid));
    }

    public function getForeignKeys($oid)
    {
        $sql = <<<SQL
SELECT
    conname,
    pg_catalog.pg_get_constraintdef(r.oid, true) as condef
FROM pg_catalog.pg_constraint r
WHERE r.conrelid = :oid
    AND r.contype = 'f'
ORDER BY 1
SQL;

        return $this->db->fetchAll($sql, array('oid' => $oid));
    }

    public function getReferences($oid)
    {
        $sql = <<<SQL
SELECT
    conname,
    conrelid::pg_catalog.regclass AS ref_table,
    pg_catalog.pg_get_constraintdef(c.oid, true) as condef
FROM pg_catalog.pg_constraint c
WHERE c.confrelid = :oid
    AND c.contype = 'f'
ORDER BY ref_table, conname
SQL;

        return $this->db->fetchAll($sql, array('oid' => $oid));
    }

    public function getTriggers($oid)
    {
        $sql = <<<SQL
SELECT
    t.tgname,
    pg_catalog.pg_get_triggerdef(t.oid, true),
    t.tgenabled
FROM pg_catalog.pg_trigger t
WHERE t.tgrelid = :oid
    AND NOT t.tgisinternal
ORDER BY 1
SQL;

        return $this->db->fetchAll($sql, array('oid' => $oid));
    }
}
