<?php
// Highlight.js https://github.com/isagalaev/highlight.js
$this->Html->script('/media/highlight_js/highlight.pack', array('inline' => false));
$this->Html->css('/media/highlight_js/styles/tomorrow-night.css', null, array('inline' => false));
$this->Html->script('/media/sqlboss/queries/js/highlighter', array('inline' => false));
$this->Html->css('/media/sqlboss/queries/css/highlighter', null, array('inline' => false));

// Controller specific
$this->Html->css('/media/sqlboss/queries/css/saved', null, array('inline' => false));

?>
<div class="queries index span12">
	<?php echo $this->DatabaseNavigation->create($connection, $connection_parameters) ?>
	<table class="table table-bordered">
	<?php if ( ! $queries): ?>
		<tr>
			<td><em>No saved queries.</em></td>
		</tr>
	<?php endif ?>
	<?php foreach ($queries as $query): ?>
		<tr>
			<td>
				<strong style="font-size: 1.2em;"><?php echo $this->Html->link($query['Query']['label'], array(
					'controller' => 'queries',
					'action'     => 'index',
					$query['Query']['id']
				) + $connection_parameters) ?></strong>
				<div class="pull-right">
					<?php echo $this->Form->postLink('<i class="icon-trash"></i>', array(
							'action' => 'delete',
							$query['Query']['id']
						) + $connection_parameters,
						array(
							'escape' => false,
							'class'  => 'query-remove'
						),
						__('Are you sure you want to delete %s?', $query['Query']['label'])
					); ?>
				</div>
		
				<pre><code class="language-sql"><?php echo $query['Query']['query_sql'] ?></code></pre>
			</td>
		</tr>
	<?php endforeach ?>
	</table>
</div>