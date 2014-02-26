<?php 

// ACE Editor
$this->Html->script('/media/bower_components/ace-builds/src-min-noconflict/ace', array('inline' => false));

// Controller specific
$this->Html->script('/media/sqlboss/queries/js/index', array('inline' => false));
$this->Html->css('/media/sqlboss/queries/css/index', null, array('inline' => false));
?>

<?php echo $this->DatabaseNavigation->create($connection, $connection_parameters) ?>
<div id="run_query">
  <?php echo $this->Form->create('Query', array('action' => false, 'id' => 'QueryIndexForm', 'url' => $this->request->here(false) . '#queries', 'class' => 'form-inline')); ?>

  <?php echo $this->Form->input('query_sql', array('label' => false, 'div' => false, 'class' => 'hidden', 'style' => 'display: none;', 'required' => false)); ?>

  <div id="query_sql_editor"><?php echo isset($this->request->data['Query']) && isset($this->request->data['Query']['query_sql']) ? $this->request->data['Query']['query_sql'] : '' ?></div>
  <hr>
  <div class="query-actions row">
    <div class="col-sm-1 col-md-1">
      <?php echo $this->Form->Submit('Run', array(
        'div'    => false,
        'escape' => false,
        'class'  => 'btn btn-success col-sm-12 col-md-12'
      )) ?>
    </div>
    <div class="col-sm-11 col-md-11">
      <div class="input-group">
        <?php echo $this->Form->input('label', array(
          'type'        => 'text',
          'label'       => false,
          'div'         => false,
          'class'       => 'form-control',
          'placeholder' => 'Name your query to be saved for later'
        )); ?>
        <span class="input-group-btn">
          <?php echo $this->Form->input('public', array(
            'type'  => 'checkbox',
            'label' => false,
            'div'   => false,
            'style' => 'display: none',
          )); ?>
          <a href="javascript:;" class="btn btn-default" id="query-public" title="Make query public"><i class="fa fa-globe"></i></a>
        </span>
        <span class="input-group-btn">
          <?php echo $this->Form->Submit('Save Query', array(
            'name'  => 'save',
            'class' => 'btn btn-default',
            'div'   => false
          )) ?>
        </span>
      </div>
    </div>
  </div>

  <?php echo $this->Form->end(); ?>
  <hr>

  <?php if (isset($query_errors) || isset($statements)): ?>
    <p><a href="#run_query"><i class="fa fa-arrow-up"></i> Back to Query</a></p>
  <?php endif ?>

  <div id="queries">
    <?php if (isset($query_errors)): ?>
      <?php foreach ($query_errors as $error): ?>
        <div class="alert alert-danger">
          <?php echo $error ?>
        </div>
      <?php endforeach ?>
    <?php endif ?>

    <?php if (isset($statements) && $statements): ?>
      <?php foreach ($statements as $statement): ?>
        <?php $count = $statement['statement']->rowCount(); ?>
        <h4 style="font-weight: normal">
          <strong><?php echo $count; ?></strong> record(s) in 
          <strong><?php echo round($statement['execution_time'], 3) ?></strong> seconds 
          <small class="text-muted"><?php echo $this->Text->ellipsize($statement['query'], 100, 0.5) ?></small>
        </h4>
        <?php if ($count > 0): ?>
          <div style="overflow-x: auto;">
            <table class="table table-condensed table-striped table-bordered">
              <thead>
                <tr>
                  <?php $columns = array(); ?>
                  <?php for ($column_index = 0; $column_index < $statement['statement']->columnCount(); $column_index++): ?>
                    <?php $columns[$column_index] = $column = $statement['statement']->getColumnMeta($column_index); ?>
                    <th><?php echo $column['name']; ?></th>
                  <?php endfor ?>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = $statement['statement']->fetch(PDO::FETCH_NUM)): ?>
                  <tr>
                    <?php foreach ($row as $column_index => $value): ?>
                      <td><?php echo ($value === NULL ? "<em>NULL</em>" : ($columns[$column_index]['pdo_type'] == PDO::PARAM_BOOL ? ($value ? "<em>TRUE</em>" : "<em>FALSE</em>") : htmlentities($value))) ?></td>
                    <?php endforeach ?>
                  </tr>
                <?php endwhile ?>
              </tbody>
            </table>
          </div>
          <?php endif ?>
        <?php endforeach ?>
      <?php endif ?>
  </div>
</div>