<?php
// Highlight.js https://github.com/isagalaev/highlight.js
$this->Html->script('/media/bower_components/highlightjs/highlight.pack', array('inline' => false));
$this->Html->css('/media/bower_components/highlightjs/styles/tomorrow.css', null, array('inline' => false));
$this->Html->script('/media/sqlboss/queries/js/highlighter', array('inline' => false));
$this->Html->css('/media/sqlboss/queries/css/highlighter', null, array('inline' => false));

?>
<?php echo $this->DatabaseNavigation->create($connection, $connection_parameters) ?>

<div class="row">
    <div class="actions col-sm-2">
        <ul class="nav nav-pills nav-stacked">
            <li><?php echo $this->Html->link(
                    '&larr; Functions',
                    ['controller' => 'schema_functions', 'action' => 'index'] + $connection_parameters,
                    ['escape' => false]
            ); ?></li>
            <li><?php echo $this->Html->link(
                    'SELECT',
                    [
                        'controller'    => 'queries',
                        'action'        => 'index',
                        'defined_query' => 'select_function',
                        'function_oid'  => $function['oid'],
                    ] + $connection_parameters,
                    ['escape' => false]
                ); ?></li>
        </ul>
    </div>
    <div class="col-sm-10">
        <h2>Function: <?= \SQLBoss\getFunctionDescription($function) ?></h2>
        <h3>Information</h3>
        <table class="table table-condensed table-float">
            <thead>
            <tr>
                <th>Type</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $function['type'] ?></td>
                </tr>
            </tbody>
        </table>
        <table class="table table-condensed table-float">
            <thead>
            <tr>
                <th>Argument Data Types</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= $function['arg_data_types'] ?></td>
            </tr>
            </tbody>
        </table>
        <table class="table table-condensed table-float">
            <thead>
            <tr>
                <th>Result Data Type</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?= $function['result_data_type'] ?></td>
            </tr>
            </tbody>
        </table>
        <h3>Definition</h3>
        <pre style="tab-stops: dotted 3in"><code class="language-sql"><?= $function['definition'] ?></code></pre>
    </div>
</div>
