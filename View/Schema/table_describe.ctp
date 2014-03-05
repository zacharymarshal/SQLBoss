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
    <table class="table table-condensed">
      <thead>
        <tr>
          <th>Name</th>
          <th>Definition</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($description->getIndexes() as $index): ?>
        <tr>
          <td><?php echo $index['relname'] ?></td>
          <td><?php echo $index['definition'] ?></td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <h3>Check constraints</h3>
    <table class="table table-condensed">
      <thead>
        <tr>
          <th>Name</th>
          <th>Definition</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($description->getChecks() as $check): ?>
        <tr>
          <td><?php echo $check['conname'] ?></td>
          <td><?php echo $check['condef'] ?></td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <h3>Foreign-key constraints</h3>
    <table class="table table-condensed">
      <thead>
        <tr>
          <th>Name</th>
          <th>Definition</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($description->getForeignKeys() as $fk): ?>
        <tr>
          <td><?php echo $fk['conname'] ?></td>
          <td><?php echo $fk['condef'] ?></td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <h3>Triggers</h3>
    <table class="table table-condensed">
      <thead>
        <tr>
          <th>Enabled?</th>
          <th>Name</th>
          <th>Definition</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($description->getTriggers() as $trigger): ?>
        <tr>
          <td>
            <?php if ($trigger['tgenabled'] == 'D'): ?>
              <span class="label label-warning">Disabled</span>
            <?php elseif ($trigger['tgenabled'] == 'O'): ?>
              <span class="label label-success">Enabled</span>
            <?php endif ?>
          </td>
          <td><?php echo $trigger['tgname'] ?></td>
          <td><?php echo $trigger['definition'] ?></td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <h3>Referenced by</h3>
    <table class="table table-condensed">
      <thead>
        <tr>
          <th>Table</th>
          <th>Constraint</th>
          <th>Definition</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($description->getReferences() as $ref): ?>
        <tr>
          <td><?php echo $ref['ref_table'] ?></td>
          <td><?php echo $ref['conname'] ?></td>
          <td><?php echo $ref['condef'] ?></td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>