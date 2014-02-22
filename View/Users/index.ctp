<div class="row">
  <div class="actions col-xs-2 col-ms-2">
    <ul class="nav nav-pills nav-stacked">
      <li class="active"><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
      <li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
    </ul>
  </div>
  <div class="col-xs-10 col-ms-10">
    <table class="table table-condensed table-striped table-bordered">
      <thead>
        <tr>
            <th><?php echo $this->Paginator->sort('id', '#'); ?></th>
            <th><?php echo $this->Paginator->sort('username'); ?></th>
            <th><?php echo $this->Paginator->sort('access_role'); ?></th>
            <th><?php echo $this->Paginator->sort('modified'); ?></th>
            <th class="actions"></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
          <td><?php echo h($user['User']['id']); ?></td>
          <td><?php echo h($user['User']['username']); ?></td>
          <td>
            <?php echo h($user['User']['access_role']); ?>
          </td>
          <td><?php echo $this->Time->niceShort($user['User']['modified']); ?></td>
          <td class="actions">
            <?php echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id']), array('class' => 'btn')); ?>
            <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id']), array('class' => 'btn')); ?>
            <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-danger'), __('Are you sure you want to delete user #%s?', $user['User']['id'])); ?>
          </td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages} ({:current} of {:count} users)'))); ?>
    <?php echo $this->Paginator->prev(__('Previous'), array(), null, array('class' => 'prev disabled')); ?>
    <?php echo $this->Paginator->next(__('Next'), array(), null, array('class' => 'next disabled')); ?>
  </div>
</div>