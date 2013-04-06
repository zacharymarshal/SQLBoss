<div class="row-fluid">
	<div class="actions span2">
		<ul class="nav nav-tabs nav-stacked">
			<li><?php echo $this->Html->link(__('Users'), array('action' => 'index')); ?> </li>
			<li class="active"><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		</ul>
	</div>
	<div class="span10">
		<?php echo $this->Form->create('User'); ?>
		<fieldset>
			<legend><?php echo __('Add User'); ?></legend>
		<?php
			echo $this->Form->input('username');
			echo $this->Form->input('password');
			echo $this->Form->input('access_role', array(
				'options' => $access_roles
			));
		?>
		</fieldset>
		<div class="form-actions">
			<?php echo $this->Form->Submit('Add', array('class' => 'btn btn-success')) ?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>