<div class="row">
  <div class="actions col-xs-2 col-md-2">
    <ul class="nav nav-pills nav-stacked">
      <li class="active"><?php echo $this->Html->link(__('Connections'), array('action' => 'index')); ?> </li>
      <li><?php echo $this->Html->link(__('New Connection'), array('action' => 'add')); ?> </li>
    </ul>
  </div>
  <div class="col-xs-10 col-md-10">
    <table class="table table-condensed table-striped table-bordered">
      <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('user_id'); ?></th>
            <th><?php echo $this->Paginator->sort('label'); ?></th>
            <th><?php echo $this->Paginator->sort('driver'); ?></th>
            <th><?php echo $this->Paginator->sort('username'); ?></th>
            <th><?php echo $this->Paginator->sort('host'); ?></th>
            <th><?php echo $this->Paginator->sort('database_name'); ?></th>
            <th><?php echo $this->Paginator->sort('modified'); ?></th>
            <th class="actions"></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($connections as $connection): ?>
        <tr>
          <td>
            <?php echo $this->Html->link($connection['User']['username'], array('controller' => 'users', 'action' => 'view', $connection['User']['id'])); ?>
          </td>
          <td><?php echo h($connection['Connection']['label']); ?></td>
          <td><?php echo h($connection['Connection']['driver']); ?></td>
          <td><?php echo h($connection['Connection']['username']); ?></td>
          <td><?php echo h($connection['Connection']['host']); ?></td>
          <td><?php echo h($connection['Connection']['database_name']); ?></td>
          <td><?php echo $this->Time->niceShort($connection['Connection']['modified']); ?></td>
          <td class="actions">
            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $connection['Connection']['id']), array('class' => 'btn')); ?>
            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $connection['Connection']['id']), array('class' => 'btn btn-danger'), __('Are you sure you want to delete %s?', $connection['Connection']['label'])); ?>
          </td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages} ({:current} of {:count} connections)'))); ?>
    <?php echo $this->Paginator->prev(__('Previous'), array(), null, array('class' => 'prev disabled')); ?>
    <?php echo $this->Paginator->next(__('Next'), array(), null, array('class' => 'next disabled')); ?>
  </div>
</div>