<div class="row">
  <div class="actions col-xs-2 col-ms-2">
    <ul class="nav nav-pills nav-stacked">
      <li><?php echo $this->Html->link(__('Connections'), array('action' => 'index')); ?> </li>
      <li class="active"><?php echo $this->Html->link(__('New Connection'), array('action' => 'add')); ?> </li>
    </ul>
  </div>
  <div class="col-xs-10 col-ms-10">
    <?php echo $this->Form->create('Connection'); ?>
    <fieldset>
      <legend><?php echo __('Add Connection'); ?></legend>
      <?php
      echo $this->Form->input('user_id', array('default' => $user_id));
      echo $this->Form->input('label', array('type' => 'text'));
      echo $this->Form->input('driver', array('options' => $drivers));
      echo $this->Form->input('host', array('type' => 'text'));
      echo $this->Form->input('username', array('type' => 'text'));
      echo $this->Form->input('password', array('value' => ''));
      echo $this->Form->input('database_name', array('type' => 'text'));
      ?>
    </fieldset>
    <div class="form-actions">
      <?php echo $this->Form->Submit('Add', array('class' => 'btn btn-success')) ?>
    </div>
    <?php echo $this->Form->end(); ?>
  </div>
</div>
