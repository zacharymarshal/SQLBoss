<?php
// Highlight.js https://github.com/isagalaev/highlight.js
$this->Html->script('/media/bower_components/highlightjs/highlight.pack', array('inline' => false));
$this->Html->css('/media/bower_components/highlightjs/styles/tomorrow.css', null, array('inline' => false));
$this->Html->script('/media/sqlboss/queries/js/highlighter', array('inline' => false));
$this->Html->css('/media/sqlboss/queries/css/highlighter', null, array('inline' => false));

?>
<?php echo $this->DatabaseNavigation->create($connection, $connection_parameters) ?>
<div class="row">
  <div class="actions col-xs-2 col-ms-2">
    <ul class="nav nav-pills nav-stacked">
      <li class="active"><?php echo $this->Html->link("Definition: {$table_name}", array($table_name) + $connection_parameters); ?></li>
      <li><?php echo $this->Html->link(__('SELECT *'), array('controller' => 'queries', 'define_table' => $table_name, 'define_table_method' => 'SelectStar') + $connection_parameters); ?></li>
      <li><?php echo $this->Html->link(__('SELECT Fields'), array('controller' => 'queries', 'define_table' => $table_name, 'define_table_method' => 'SelectFields') + $connection_parameters); ?></li>
      <li><?php echo $this->Html->link(__('INSERT'), array('controller' => 'queries', 'define_table' => $table_name, 'define_table_method' => 'Insert') + $connection_parameters); ?></li>
      <li><?php echo $this->Html->link(__('UPDATE'), array('controller' => 'queries', 'define_table' => $table_name, 'define_table_method' => 'Update') + $connection_parameters); ?></li>
      <li><?php echo $this->Html->link(__('DELETE'), array('controller' => 'queries', 'define_table' => $table_name, 'define_table_method' => 'Delete') + $connection_parameters); ?></li>
    </ul>
  </div>
  <div class="col-xs-10 col-ms-10">
    <pre style="tab-stops: dotted 3in"><code class="language-sql"><?php echo "-- {$drop_table_sql};\n" ?><?php foreach ($table_sql as $sql): ?><?php echo SqlFormatter::format($sql, false) . ";\n" ?><?php endforeach ?></code></pre>
  </div>
</div>