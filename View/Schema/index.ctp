<?php
$this->Assetrinc->js('sqlboss/schema/js/index.js.coffee');
?>
<?php echo $this->DatabaseNavigation->create($connection, $connection_parameters) ?>

<div class="row">
  <div class="actions col-xs-2 col-md-2">
    <ul class="nav nav-pills nav-stacked">
      <li<?php if ($showingTables): ?> class="active"<?php endif ?>>
        <?php echo $this->Html->link(
          __('Tables'),
          $connection_parameters
        ); ?>
      </li>
      <li<?php if ($showingViews): ?> class="active"<?php endif ?>>
        <?php echo $this->Html->link(
          __('Views'),
          array('?' => array('tt' => array('v'))) + $connection_parameters
        ); ?>
      </li>
    </ul>
  </div>
  <div class="col-xs-10 col-md-10">
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
          'action' => 'tableDescribe',
          $table_name
        ) + $connection_parameters, array('class' => 'sqlboss-table')) ?></li>
      <?php endforeach ?>
      </ul>
    </div>
  </div>
</div>
