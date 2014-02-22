<?php
$this->Html->script('/media/sqlboss/schema/js/index', array('inline' => false));
$this->Html->script('/media/list/js/list', array('inline' => false));
?>
<?php echo $this->DatabaseNavigation->create($connection, $connection_parameters) ?>
<div id="tables-list">
  <p>
    <?php echo $this->Form->input('tables-search', array(
      'label'       => false,
      'class'       => 'search search-query form-control',
      'placeholder' => 'Search...',
      'autofocus'   => true
    )); ?>
  </p>
  <ul class="list nav nav-pills nav-stacked">
  <?php sort($tables) ?>
  <?php foreach ($tables as $table_name): ?>
    <li><?php echo $this->Html->link($table_name, array(
      'action' => 'tableDefinition',
      $table_name
    ) + $connection_parameters, array('class' => 'sqlboss-table')) ?></li>
  <?php endforeach ?>
  </ul>
</div>