<div class="row">
  <div class="actions col-xs-2 col-ms-2">
    <ul class="nav nav-pills nav-stacked">
      <li><?php echo $this->Html->link(__('Users'), array('action' => 'index')); ?></li>
      <li><?php echo $this->Html->link(__('Profile'), array('action' => 'view', $this->Form->value('User.id'))); ?></li>
    </ul>
  </div>
  <div class="col-xs-10 col-ms-10">
    <?php echo $this->Form->create('User'); ?>
    <fieldset>
      <legend><?php echo __('Edit User'); ?></legend>
    <?php
      echo $this->Form->input('id');
      echo $this->Form->input('username');
      echo $this->Form->input('access_role', array(
        'options' => $access_roles
      ));
    ?>
    </fieldset>
    <div class="form-actions">
      <?php echo $this->Form->Submit('Save', array('class' => 'btn btn-success')) ?>
    </div>
    <?php echo $this->Form->end(); ?>
  </div>
</div>