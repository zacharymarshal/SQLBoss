<?php
// Highlight.js https://github.com/isagalaev/highlight.js
$this->Html->script('/media/bower_components/highlightjs/highlight.pack', array('inline' => false));
$this->Html->css('/media/bower_components/highlightjs/styles/tomorrow.css', null, array('inline' => false));
$this->Html->script('/media/sqlboss/queries/js/highlighter', array('inline' => false));
$this->Html->css('/media/sqlboss/queries/css/highlighter', null, array('inline' => false));

?>
<?php echo $this->DatabaseNavigation->create($connection, $connection_parameters) ?>
<div class="row">
  <div class="actions col-xs-2 col-ms-2">
    <ul class="nav nav-pills nav-stacked">
      <li class="active"><?php echo $this->Html->link("Definition: {$table_name}", array($table_name) + $connection_parameters); ?></li>
      <li><?php echo $this->Html->link(__('SELECT *'), array('controller' => 'queries', 'define_table' => $table_name, 'define_table_method' => 'SelectStar') + $connection_parameters); ?></li>
      <li><?php echo $this->Html->link(__('SELECT Fields'), array('controller' => 'queries', 'define_table' => $table_name, 'define_table_method' => 'SelectFields') + $connection_parameters); ?></li>
      <li><?php echo $this->Html->link(__('INSERT'), array('controller' => 'queries', 'define_table' => $table_name, 'define_table_method' => 'Insert') + $connection_parameters); ?></li>
      <li><?php echo $this->Html->link(__('UPDATE'), array('controller' => 'queries', 'define_table' => $table_name, 'define_table_method' => 'Update') + $connection_parameters); ?></li>
      <li><?php echo $this->Html->link(__('DELETE'), array('controller' => 'queries', 'define_table' => $table_name, 'define_table_method' => 'Delete') + $connection_parameters); ?></li>
    </ul>
  </div>
  <div class="col-xs-10 col-ms-10">
    <h3>Columns</h3>
    <table class="table table-condensed">
      <thead>
        <tr>
          <th>Column</th>
          <th>Type</th>
          <th>Modifiers</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($description->getFields() as $field): ?>
        <tr>
          <td><?php echo $field['column'] ?></td>
          <td style="white-space: nowrap;"><?php echo $field['type'] ?></td>
          <td style="white-space: nowrap;">
            <?php echo ($field['not_null'] ? "not null" : '') ?> <?php echo $field['default'] ?>
          </td>
          <td><?php echo $field['comment'] ?></td>
        </tr>
      <?php endforeach ?>
      </tbody>
    </table>
    <h3>Indexes</h3>
    <ul>
    <?php foreach ($description->getIndexes() as $index): ?>
      <li><?php echo $index['definition'] ?></li>
    <?php endforeach ?>
    </ul>
    <h3>Check constraints</h3>
    <ul>
    <?php foreach ($description->getChecks() as $check): ?>
      <li><?php echo "\"{$check['conname']}\"" ?> <?php echo $check['condef'] ?></li>
    <?php endforeach ?>
    </ul>
    <h3>Foreign-key constraints</h3>
    <ul>
    <?php foreach ($description->getForeignKeys() as $fk): ?>
      <li><?php echo "\"{$fk['conname']}\"" ?> <?php echo $fk['condef'] ?></li>
    <?php endforeach ?>
    </ul>
    <h3>Triggers</h3>
    <ul>
    <?php foreach ($description->getTriggers() as $trigger): ?>
      <li>
        <?php if ($trigger['tgenabled'] == 'D'): ?>
          <span class="label label-warning">Disabled</span>
        <?php endif ?>
        <?php echo $trigger['definition'] ?>
      </li>
    <?php endforeach ?>
    </ul>
    <h3>Referenced by</h3>
    <ul>
    <?php foreach ($description->getReferences() as $ref): ?>
      <li><?php echo "TABLE \"{$ref['ref_table']}\" CONSTRAINT \"{$ref['conname']}\" {$ref['condef']}" ?></li>
    <?php endforeach ?>
    </ul>
  </div>
</div>