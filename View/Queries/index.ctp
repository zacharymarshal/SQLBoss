<?php 

// JSON.stringify
$this->Html->script('json', array('inline' => false));

// Controller specific
$this->Html->script('/media/ace/ace', array('inline' => false));
$this->Html->script('/media/sqlboss/queries/js/index', array('inline' => false));
$this->Html->css('/media/sqlboss/queries/css/index', null, array('inline' => false));
?>

<div class="queries span12">
    <?php echo $this->DatabaseNavigation->create($connection, $connection_parameters) ?>
    <?php echo $this->Form->create('Query'); ?>
    <?php echo $this->Form->input('query_sql', array('label' => false, 'class' => 'hidden')); ?>
    <div class="row-fluid">
        <pre id="query_sql_editor" class="span12"><?php echo isset($this->request->data['Query']) && isset($this->request->data['Query']['query_sql']) ? $this->request->data['Query']['query_sql'] : '' ?></pre>
    </div>
    <p></p>
    <div class="controls">
        <div class="input-append">
            <?php echo $this->Form->input('label', array(
                'type'        => 'text',
                'label'       => false,
                'div'         => false,
                'class'       => 'span4'
            )); ?>
            <?php echo $this->Form->Submit('Save Query', array(
                'name'  => 'save',
                'class' => 'btn',
                'div'   => false
            )) ?>
        </div>
        <div class="help-block">Name your query to be saved for later</div>
    </div>
    <div class="form-actions">
        <?php echo $this->Form->Submit('Run', array('class' => 'btn btn-success')) ?>
    </div>
    <?php echo $this->Form->end(); ?>

<?php if (isset($query_error)): ?>
    <div class="alert alert-error">
        <?php echo $query_error ?>
    </div>
<?php endif ?>

<?php if (isset($statements) && $statements): ?>
    <?php $query_num = 0; ?>
    <?php foreach ($statements as $statement): ?>
    <?php $query_num++ ?>
    <?php $count = $statement->getCount(); ?>
    <h4 style="font-weight: normal">
        <strong><?php echo $count; ?></strong> record(s) in 
        <strong><?php echo round($statement->getExecutionTime(), 3) ?></strong> seconds 
        <small class="muted"><?php echo $this->Text->ellipsize($statement->getQuery(), 100, 0.5) ?></small>
    </h4>
    <?php if ($count > 0): ?>
    <div style="overflow-x: auto;">
        <table class="table table-condensed table-striped table-bordered">
            <thead>
            <tr>
                <?php foreach ($statement->getColumns() as $column): ?>
                    <th><?php echo $column['name']; ?></th>
                <?php endforeach ?>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $statement->fetch()) { ?>
            <tr>
                <?php foreach ($row as $value): ?>
                    <td><?php echo ($value === NULL ? "<em>NULL</em>" : $value) ?></td>
                <?php endforeach ?>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <?php endif ?>
    <?php endforeach ?>
<?php endif ?>

</div>
