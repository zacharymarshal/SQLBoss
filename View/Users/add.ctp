<div class="row">
  <div class="actions col-xs-2 col-ms-2">
    <ul class="nav nav-pills nav-stacked">
      <li><?php echo $this->Html->link(__('Users'), array('action' => 'index')); ?> </li>
      <li class="active"><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
    </ul>
  </div>
  <div class="col-xs-10 col-ms-10">
    <?php echo $this->Form->create('User'); ?>
    <fieldset>
      <legend><?php echo __('Add User'); ?></legend>
    <?php
      echo $this->Form->input('username');
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