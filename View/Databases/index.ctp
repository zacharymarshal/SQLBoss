<?php
$this->Html->script('databases/index', array('inline' => false));
$this->Html->css('databases/index', null, array('inline' => false));
?>

<div class="row-fluid">
<div class="span12">
  <?php echo $this->DatabaseNavigation->create($connection, $connection_parameters) ?>
  <ul class="nav nav-pills">
    <li class="connection active"><a href="#all">All</a></li>
    <?php foreach ($connections as $connection): ?>
    <li class="connection"><?php echo $this->Html->link($connection['Connection']['label'], "#{$connection['Connection']['id']}"); ?></li>
    <?php endforeach ?>
  </ul>
  <ul class="nav nav-tabs nav-stacked">
    <?php foreach ($databases as $database): ?>
    <li class="database" data-connection_id="<?php echo $database['Connection']['id'] ?>"><?php echo $this->Html->link($database['name'] . " <small class=\"muted\">{$database['Connection']['label']} </small>", array(
      'controller'    => 'queries',
      'connection_id' => $database['Connection']['id'],
      'database'      => $database['id'],
    ), array('escape' => false)) ?> </li>
    <?php endforeach ?>
  </ul>
</div>
</div>