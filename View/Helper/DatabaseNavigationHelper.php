<?php

App::uses('AppHelper', 'View/Helper');

class DatabaseNavigationHelper extends AppHelper
{
    public $helpers = array('Html');

    public function create($connection, $connection_parameters)
    {
        if ( ! $connection) {
            return '';
        }

        $databases_link = $this->Html->link('Databases', array(
            'controller' => 'databases',
            'action'     => 'index'
        ) + $connection_parameters);
        $html = "
        <ul class=\"breadcrumb\">
            <li>{$databases_link} <span class=\"divider\">/</span></li>
            <li><abbr title=\"{$connection['Connection']['username']}@{$connection['Connection']['host']}\">{$connection['Connection']['label']}</abbr> <span class=\"divider\">/</span></li>
            <li>{$connection['Connection']['database_name']}</li>
        </ul>";
        return $html;
    }
}
