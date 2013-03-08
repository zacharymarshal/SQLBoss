<div class="queries view">
<h2><?php  echo __('Query'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($query['Query']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($query['User']['id'], array('controller' => 'users', 'action' => 'view', $query['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Label'); ?></dt>
		<dd>
			<?php echo h($query['Query']['label']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Query Sql'); ?></dt>
		<dd>
			<?php echo h($query['Query']['query_sql']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Query Hash'); ?></dt>
		<dd>
			<?php echo h($query['Query']['query_hash']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($query['Query']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($query['Query']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted'); ?></dt>
		<dd>
			<?php echo h($query['Query']['deleted']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Deleted Date'); ?></dt>
		<dd>
			<?php echo h($query['Query']['deleted_date']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Query'), array('action' => 'edit', $query['Query']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Query'), array('action' => 'delete', $query['Query']['id']), null, __('Are you sure you want to delete # %s?', $query['Query']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Queries'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Query'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
