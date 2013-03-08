<div class="queries form">
<?php echo $this->Form->create('Query'); ?>
	<fieldset>
		<legend><?php echo __('Edit Query'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('label');
		echo $this->Form->input('query_sql');
		echo $this->Form->input('query_hash');
		echo $this->Form->input('deleted');
		echo $this->Form->input('deleted_date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Query.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Query.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Queries'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
