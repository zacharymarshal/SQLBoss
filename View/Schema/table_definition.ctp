<pre>
<?php echo "-- {$drop_table_sql};\n" ?>
<?php foreach ($table_sql as $sql): ?>
<?php echo SqlFormatter::format($sql, false) . ";\n" ?>
<?php endforeach ?>
</pre>