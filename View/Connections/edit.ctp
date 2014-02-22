<div class="row">
  <div class="actions col-xs-2 col-ms-2">
    <ul class="nav nav-pills nav-stacked">
      <li><?php echo $this->Html->link(__('Connections'), array('action' => 'index')); ?></li>
      <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Connection.id')), null, __('Are you sure you want to delete %s?', $this->Form->value('Connection.label'))); ?></li>
    </ul>
  </div>
  <div class="col-xs-10 col-ms-10">
    <?php echo $this->Form->create('Connection'); ?>
    <fieldset>
      <legend><?php echo __('Edit Connection'); ?></legend>
      <?php
      $driver = $connection->data['Connection']['driver'];
      echo $this->Form->input('label', array('type' => 'text'));
      if ($driver == 'pgsql' || $driver == 'mysql') {
        echo $this->Form->input('host', array('type' => 'text'));
        echo $this->Form->input('username', array('type' => 'text'));
        echo $this->Form->input('password', array('value' => ''));
      }
      elseif ($driver == 'sqlite') {
        echo $this->Form->input('database_name', array('type' => 'text'));
      }
      ?>
    </fieldset>
    <div class="form-actions">
      <?php echo $this->Form->Submit('Save', array('class' => 'btn btn-success')) ?>
    </div>
    <?php echo $this->Form->end(); ?>
  </div>
</div>