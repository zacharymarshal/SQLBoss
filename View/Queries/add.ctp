<div class="queries form">
<?php echo $this->Form->create('Query'); ?>
    <fieldset>
        <legend><?php echo __('Add Query'); ?></legend>
    <?php
        echo $this->Form->input('label', array(
            'type' => 'text'
        ));
        echo $this->Form->input('query_sql');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('List Queries'), array('action' => 'index')); ?></li>
    </ul>
</div>
