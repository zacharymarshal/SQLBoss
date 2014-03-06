<?php
// Syntax highlighting
$this->Html->script('/media/bower_components/rainbow/js/rainbow.min.js', array('inline' => false));
$this->Html->script('/media/bower_components/rainbow/js/language/generic.js', array('inline' => false));

// Table floating
$this->Html->script('/media/bower_components/floatThead/dist/jquery.floatThead.min.js', array('inline' => false));

$this->Html->script('/media/sqlboss/schema/js/tableDescribe.js', array('inline' => false));

$this->Html->css('/media/rainbow/theme/tomorrow', null, array('inline' => false));
$this->Html->css('/media/sqlboss/schema/css/tableDescribe', null, array('inline' => false));

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
    <table class="table table-condensed table-float">
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
          <td><pre data-language="generic" class="nowrap"><?php echo $field['type'] ?></pre></td>
          <td>
            <pre data-language="generic" class="nowrap"><?php echo ($field['not_null'] ? "not null" : '') ?> <?php echo $field['default'] ?></pre>
          </td>
          <td><?php echo $field['comment'] ?></td>
        </tr>
      <?php endforeach ?>
      </tbody>
    </table>
    <h3>Indexes</h3>
    <table class="table table-condensed table-float">
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
          <td><pre data-language="generic"><?php echo $index['definition'] ?></pre></td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <h3>Check constraints</h3>
    <table class="table table-condensed table-float">
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
          <td><pre data-language="generic"><?php echo $check['condef'] ?></pre></td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <h3>Foreign-key constraints</h3>
    <table class="table table-condensed table-float">
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
          <td><pre data-language="generic"><?php echo $fk['condef'] ?></pre></td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <h3>Triggers</h3>
    <table class="table table-condensed table-float">
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
          <td><pre data-language="generic"><?php echo $trigger['definition'] ?></pre></td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <h3>Referenced by</h3>
    <table class="table table-condensed table-float">
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
          <td><pre data-language="generic"><?php echo $ref['condef'] ?></pre></td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>