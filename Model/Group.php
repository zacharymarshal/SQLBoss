<?php

App::uses('AppModel', 'Model');

class Group extends AppModel
{
    public $validate = array(
        'name' => 'notempty'
    );

    public $hasMany = array(
        'User' => array(
            'className'  => 'User',
            'foreignKey' => 'group_id',
        )
    );
}
