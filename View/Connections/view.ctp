<div class="actions col-sm-2 col-md-2">
  <ul class="nav nav-tabs nav-stacked">
    <li>
      <?php echo $this->Html->link(__('List Connections'), array(
        'action' => 'index'
      )); ?>
    </li>
    <li>
      <?php echo $this->Html->link(__('Edit Connection'), array(
        'action' => 'edit',
        $connection['Connection']['id']
      )); ?>
    </li>
    <li>
      <?php echo $this->Form->postLink(
        __('Delete Connection'),
        array('action' => 'delete', $connection['Connection']['id']),
        null,
        __('Are you sure you want to delete # %s?', $connection['Connection']['id'])
        ); ?>
    </li>
    <li>
      <?php echo $this->Html->link(__('New Connection'), array(
        'action' => 'add'
      )); ?>
    </li>
  </ul>
</div>
<div class="connections view col-sm-10 col-md-10">
    <h2><?php  echo h($connection['Connection']['label']); ?></h2>
    <?php $driver = $connection['Connection']['driver'] ?>
    <?php echo $this->element("view_connection_{$driver}", array(
        'connection' => $connection
    )); ?>
</div>
