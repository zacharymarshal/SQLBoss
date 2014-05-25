<?php $this->Assetrinc->js('sqlboss/schema/js/tableDescribe.js.coffee'); ?>
<?php $this->Assetrinc->css('sqlboss/schema/css/tableDescribe.css'); ?>
<?php echo $this->DatabaseNavigation->create($connection, $connection_parameters) ?>
<div class="row">
  <div class="actions col-sm-2">
    <ul class="nav nav-pills nav-stacked">
      <li><?php echo $this->Html->link(__('SELECT *'), array('controller' => 'queries', 'define_table' => $table_name, 'define_table_method' => 'SelectStar') + $connection_parameters); ?></li>
      <li><?php echo $this->Html->link(__('SELECT Fields'), array('controller' => 'queries', 'define_table' => $table_name, 'define_table_method' => 'SelectFields') + $connection_parameters); ?></li>
      <li><?php echo $this->Html->link(__('INSERT'), array('controller' => 'queries', 'define_table' => $table_name, 'define_table_method' => 'Insert') + $connection_parameters); ?></li>
      <li><?php echo $this->Html->link(__('UPDATE'), array('controller' => 'queries', 'define_table' => $table_name, 'define_table_method' => 'Update') + $connection_parameters); ?></li>
      <li><?php echo $this->Html->link(__('DELETE'), array('controller' => 'queries', 'define_table' => $table_name, 'define_table_method' => 'Delete') + $connection_parameters); ?></li>
    </ul>
  </div>
  <div class="col-sm-10">
    <h2>Table: <?php echo $table_name ?></h2>
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
        <?php if (!$columns): ?>
        <tr>
          <td colspan="3">
            <em>No columns</em>
          </td>
        </tr>
        <?php endif ?>
        <?php foreach ($columns as $column): ?>
        <tr>
          <td><?php echo $column['column'] ?></td>
          <td><pre data-language="generic" class="nowrap"><?php echo $column['type'] ?></pre></td>
          <td>
            <pre data-language="generic" class="nowrap"><?php echo ($column['not_null'] ? "not null" : '') ?> <?php echo $column['default'] ?></pre>
          </td>
          <td><?php echo $column['comment'] ?></td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <?php if ($view_definition): ?>
      <h3>View Definition</h3>
      <pre style="tab-stops: dotted 3in"><code class="language-sql"><?php echo $view_definition ?></code></pre>
    <?php endif ?>
    <h3>Indexes</h3>
    <table class="table table-condensed table-float">
      <thead>
        <tr>
          <th>Name</th>
          <th>Definition</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$indexes): ?>
        <tr>
          <td colspan="3">
            <em>No indexes</em>
          </td>
        </tr>
        <?php endif ?>
        <?php foreach ($indexes as $index): ?>
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
        <?php if (!$checks): ?>
        <tr>
          <td colspan="3">
            <em>No check constraints</em>
          </td>
        </tr>
        <?php endif ?>
        <?php foreach ($checks as $check): ?>
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
        <?php if (!$foreign_keys): ?>
        <tr>
          <td colspan="3">
            <em>No foreign-key contraints</em>
          </td>
        </tr>
        <?php endif ?>
        <?php foreach ($foreign_keys as $fk): ?>
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
          <th>Enabled</th>
          <th>Name</th>
          <th>Definition</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$triggers): ?>
        <tr>
          <td colspan="3">
            <em>No triggers</em>
          </td>
        </tr>
        <?php endif ?>
        <?php foreach ($triggers as $trigger): ?>
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
        <?php if (!$references): ?>
        <tr>
          <td colspan="3">
            <em>Not referenced</em>
          </td>
        </tr>
        <?php endif ?>
        <?php foreach ($references as $ref): ?>
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