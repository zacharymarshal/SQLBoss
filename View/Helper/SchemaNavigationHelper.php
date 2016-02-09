<?php

App::uses('AppHelper', 'View/Helper');

class SchemaNavigationHelper extends AppHelper
{
    public $helpers = array('Html');

    public function create($connection_parameters, $active)
    {
        $links = [
            'tables' => $this->Html->link(
                __('Tables'),
                ['controller' => 'schema'] + $connection_parameters
            ),
            'views' => $this->Html->link(
                __('Views'),
                ['controller' => 'schema', '?' => ['tt' => ['v']]] + $connection_parameters
            ),
            'functions' => $this->Html->link(
                __('Functions'),
                ['controller' => 'schema_functions'] + $connection_parameters
            ),
        ];

        $links_html = implode('', array_map(
            function ($link, $key) use ($active) {
                $active_class = ($active === $key) ? " class=\"active\"" : "";

                return sprintf("<li%s>%s</li>", $active_class, $link);
            },
            $links,
            array_keys($links)
        ));

        return <<<HTML
<div class="actions col-xs-2 col-md-2">
    <ul class="nav nav-pills nav-stacked">
        {$links_html}
    </ul>
</div>
HTML;
    }
}
