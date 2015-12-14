<?php $this->Assetrinc->js('sqlboss/schema_functions/js/index.js.coffee'); ?>
<?php echo $this->DatabaseNavigation->create($connection, $connection_parameters) ?>

<div class="row">
    <?= $this->SchemaNavigation->create($connection_parameters, 'functions') ?>
    <div class="col-xs-10 col-md-10">
        <div id="schema-functions-list">
            <p>
                <?php echo $this->Form->input('schema-functions-search', array(
                    'label'       => false,
                    'class'       => 'search search-query form-control',
                    'placeholder' => 'Search...',
                    'autofocus'   => true
                )); ?>
            </p>
            <ul class="list nav nav-pills nav-stacked">
                <?php foreach ($functions as $function): ?>
                    <li><?php echo $this->Html->link(
                        $function['schema'] . '.' . $function['name'] . '(' . $function['arg_data_types'] . ')',
                        [
                            'action' => 'describe',
                            $function['oid']
                        ] + $connection_parameters,
                        ['class' => 'schema-function']
                    ) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</div>
