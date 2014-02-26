<?php
// Controller specific
$this->Html->css('/media/sqlboss/users/css/view', null, array('inline' => false));

?>
<div class="row">
  <div class="actions col-xs-2 col-md-2">
    <ul class="nav nav-pills nav-stacked">
      <li><?php echo $this->Html->link(__('Edit Profile'), array('action' => 'edit', $user['User']['id'])); ?></li>
      <li><?php echo $this->Html->link(__('New Connection'), array('controller' => 'connections', 'action' => 'add', 'user_id' => $user['User']['id'])); ?></li>
    </ul>
  </div>
  <div class="col-xs-10 col-md-10">
    <span class="username"><?php echo h($user['User']['username']) ?></span>
    <?php echo h($user['User']['access_role']) ?><br/>
    <span class="text-muted"><i class="fa fa-clock-o"></i> Created on </span><?php echo $this->Time->niceShort($user['User']['created']) ?>
    <hr>
    <h4>Connections</h4>
    <table class="table table-condensed table-striped table-bordered">
      <thead>
        <tr>
            <th><?php echo __('Label'); ?></th>
            <th><?php echo __('Driver'); ?></th>
            <th><?php echo __('Username'); ?></th>
            <th><?php echo __('Host'); ?></th>
            <th><?php echo __('Database'); ?></th>
            <th><?php echo __('Modified'); ?></th>
            <th class="actions"></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($user['Connection'] as $connection): ?>
        <tr>
          <td><?php echo h($connection['label']); ?></td>
          <td><?php echo h($connection['driver']); ?></td>
          <td><?php echo h($connection['username']); ?></td>
          <td><?php echo h($connection['host']); ?></td>
          <td><?php echo h($connection['database_name']); ?></td>
          <td><?php echo $this->Time->niceShort($connection['modified']); ?></td>
          <td class="actions">
            <?php echo $this->Html->link(__('Edit'), array('controller' => 'connections', 'action' => 'edit', $connection['id']), array('class' => 'btn')); ?>
            <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'connections', 'action' => 'delete', $connection['id']), array('class' => 'btn btn-danger'), __('Are you sure you want to delete %s?', $connection['label'])); ?>
          </td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>