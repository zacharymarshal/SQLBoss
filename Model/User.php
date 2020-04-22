<?php

App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel
{
    public $validate = array(
        'username' => array(
            'This username has already been taken' => array(
                'rule' => 'isUnique',
                'last' => false,
            ),
        ),
        'access_role' => array(
            'valid' => array(
                'rule'       => array('inList', array('admin', 'limited')),
                'message'    => 'Please enter a valid role',
                'allowEmpty' => false,
                'required'   => true,
            )
        ),
    );

    public $hasMany = array(
        'Connection' => array(
            'className'  => 'Connection',
            'foreignKey' => 'user_id',
        ),
        'Query' => array(
            'className'  => 'Query',
            'foreignKey' => 'user_id',
        )
    );

    public function beforeSave($options = array())
    {
        return true;
    }
}
