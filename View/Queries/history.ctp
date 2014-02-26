<?php
// Highlight.js https://github.com/isagalaev/highlight.js
$this->Html->script('/media/highlight_js/highlight.pack', array('inline' => false));
$this->Html->css('/media/highlight_js/styles/tomorrow.css', null, array('inline' => false));
$this->Html->script('/media/sqlboss/queries/js/highlighter', array('inline' => false));
$this->Html->css('/media/sqlboss/queries/css/highlighter', null, array('inline' => false));

// Controller specific
$this->Html->css('/media/sqlboss/queries/css/saved', null, array('inline' => false));
$this->Html->script('/media/sqlboss/queries/js/saved', array('inline' => false));

?>

<?php echo $this->DatabaseNavigation->create($connection, $connection_parameters) ?>
<?php foreach ($queries as $query): ?>
<div class="query">
  <div class="query-creator">
    <?php echo $this->Html->link($query['User']['username'], array('controller' => 'users', 'action' => 'view', $query['User']['id'])); ?> / 
    <?php echo $this->Html->link("query #{$query['Query']['id']}", array(
      'controller' => 'queries',
      'action'     => 'index',
      $query['Query']['id']
    ) + $connection_parameters) ?>
  </div>
  <div class="query-created"><small class="text-muted">Created <?php echo $this->Time->niceShort($query['Query']['created']) ?></small></div>
  <div class="query-name">
    <?php echo $query['Query']['label'] ?>
  </div>
  <div class="query-sql_box">
    <a href="<?php echo $this->Html->url(array('controller' => 'queries', 'action' => 'index', $query['Query']['id']) + $connection_parameters); ?>" class="query-link_overlay">
      <span class="link">View <strong>query #<?php echo $query['Query']['id'] ?></strong> <i class="fa fa-arrow-right"></i></span>
    </a>
    <div class="query-sql_data">
      <pre style="tab-stops: dotted 3in"><code class="language-sql"><?php echo str_replace("\t", '    ', $this->Text->lineLimiter($query['Query']['query_sql'])) ?></code></pre>
    </div>
  </div>
</div>
<?php endforeach ?>