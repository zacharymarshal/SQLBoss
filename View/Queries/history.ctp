<?php
// Highlight.js https://github.com/isagalaev/highlight.js
$this->Html->script('/media/highlight_js/highlight.pack', array('inline' => false));
$this->Html->css('/media/highlight_js/styles/tomorrow.css', null, array('inline' => false));
$this->Html->script('/media/sqlboss/queries/js/highlighter', array('inline' => false));
$this->Html->css('/media/sqlboss/queries/css/highlighter', null, array('inline' => false));

?>
<div class="queries index span12">
	<?php echo $this->DatabaseNavigation->create($connection, $connection_parameters) ?>
	<table class="table table-bordered">
		<?php foreach ($queries as $query): ?>
		<tr>
			<td>
				<strong style="font-size: 1.2em;">
					<?php echo $this->Html->link("#{$query['Query']['id']}", array(
							'controller' => 'queries',
							'action'     => 'index',
							$query['Query']['id']
						) + $connection_parameters)
					?>
				</strong> <small class="muted"><?php echo $this->Time->niceShort($query['Query']['modified']) ?></small>
				<pre><code class="language-sql"><?php echo $query['Query']['query_sql'] ?></code></pre>
			</td>
		</tr>
		<?php endforeach ?>
	</table>
</div>