<?php 

// ACE Editor
$this->Html->script('/media/ace/ace', array('inline' => false));

// Controller specific
$this->Html->script('/media/sqlboss/queries/js/index', array('inline' => false));
$this->Html->css('/media/sqlboss/queries/css/index', null, array('inline' => false));
?>

<div class="queries span12">
	<?php echo $this->DatabaseNavigation->create($connection, $connection_parameters) ?>
	<?php echo $this->Form->create('Query'); ?>
	<?php echo $this->Form->input('query_sql', array('label' => false, 'class' => 'hidden', 'required' => false)); ?>
	<div class="row-fluid">
		<div id="query_sql_editor" class="span12"><?php echo isset($this->request->data['Query']) && isset($this->request->data['Query']['query_sql']) ? $this->request->data['Query']['query_sql'] : '' ?></div>
	</div>
	<div class="controls" style="margin-top: 25px;">
		<div class="input-append">
			<?php echo $this->Form->input('label', array(
				'type'        => 'text',
				'label'       => false,
				'div'         => false,
				'class'       => 'span12',
				'placeholder' => 'Name your query to be saved for later'
			)); ?>
			<?php echo $this->Form->Submit('Save Query', array(
				'name'  => 'save',
				'class' => 'btn',
				'div'   => false
			)) ?>
		</div>
	</div>
	<div class="form-actions">
		<?php echo $this->Form->Submit('Run', array('class' => 'btn btn-success')) ?>
	</div>
	<?php echo $this->Form->end(); ?>

<?php if (isset($query_errors)): ?>
	<?php foreach ($query_errors as $error): ?>
	<div class="alert alert-error">
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
		<small class="muted"><?php echo $this->Text->ellipsize($statement['query'], 100, 0.5) ?></small>
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
			<?php while ($row = $statement['statement']->fetch(PDO::FETCH_NUM)) { ?>
			<tr>
				<?php foreach ($row as $column_index => $value): ?>
					<td><?php echo ($value === NULL ? "<em>NULL</em>" : ($columns[$column_index]['pdo_type'] == PDO::PARAM_BOOL ? ($value ? "<em>TRUE</em>" : "<em>FALSE</em>") : $value)) ?></td>
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
