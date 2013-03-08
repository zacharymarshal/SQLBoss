<?php
// Highlight.js https://github.com/isagalaev/highlight.js
$this->Html->script('highlight', array('inline' => false));
$this->Html->css('tomorrow', null, array('inline' => false));

// Controller specific
$this->Html->script('queries/history', array('inline' => false));
$this->Html->css('queries/history', null, array('inline' => false));

?>
<div class="queries index span12">
    <?php echo $this->DatabaseNavigation->create($connection, $connection_parameters) ?>
    <table class="table table-bordered">
    <?php foreach ($queries as $query): ?>
        <tr>
            <td>
                <strong style="font-size: 1.2em;"><?php echo $this->Html->link("#{$query['Query']['id']}", array(
                    'controller' => 'queries',
                    'action'     => 'index',
                    $query['Query']['id']
                ) + $connection_parameters) ?></strong>
                <small class="muted"><?php echo $this->Time->nice($query['Query']['modified']) ?></small>
            </td>
        </tr>
        <tr>
            <td>
                <pre><code class="language-sql"><?php echo $query['Query']['query_sql'] ?></code></pre>
            </td>
        </tr>
    <?php endforeach ?>
    </table>
</div>