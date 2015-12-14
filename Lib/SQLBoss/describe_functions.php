<?php

namespace SQLBoss;

function listFunctions(callable $getAll)
{
    $sql = <<<SQL
SELECT
    p.oid,
    n.nspname AS "schema",
    p.proname AS "name",
    pg_catalog.pg_get_function_arguments(p.oid) AS arg_data_types
FROM pg_catalog.pg_proc p
LEFT JOIN pg_catalog.pg_namespace n ON n.oid = p.pronamespace
WHERE pg_catalog.pg_function_is_visible(p.oid)
    AND n.nspname <> 'pg_catalog'
    AND n.nspname <> 'information_schema'
ORDER BY 2, 3, 4
SQL;

    return $getAll($sql);
}

function describeFunction(callable $getRow, $oid)
{
    $sql = <<<SQL
SELECT
    n.nspname AS "schema",
    p.proname AS "name",
    pg_catalog.pg_get_function_result(p.oid) AS result_data_type,
    pg_catalog.pg_get_function_arguments(p.oid) AS arg_data_types,
    CASE
        WHEN p.proisagg THEN 'agg'
        WHEN p.proiswindow THEN 'window'
        WHEN p.prorettype = 'pg_catalog.trigger' :: pg_catalog.regtype THEN 'trigger'
        ELSE 'normal'
    END AS type,
    pg_catalog.pg_get_functiondef(p.oid) AS definition
FROM pg_catalog.pg_namespace p
LEFT JOIN pg_catalog.pg_namespace n ON n.oid = p.pronamespace
WHERE p.oid = ?
SQL;

    return $getRow($sql, [$oid]);
}
