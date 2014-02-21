<?php
class SQLBoss2Schema extends CakeSchema
{
    public function before($event = array())
    {
        return true;
    }

    public function after($event = array())
    {
    }

    public $connections = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
        'user_id' => array('type' => 'integer', 'null' => false),
        'label' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
        'username' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
        'password' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
        'host' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
        'driver' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
        'database_name' => array('type' => 'text', 'null' => true, 'length' => 1073741824),
        'created' => array('type' => 'datetime', 'null' => true),
        'modified' => array('type' => 'datetime', 'null' => true),
        'indexes' => array(
            'PRIMARY' => array('unique' => true, 'column' => 'id')
        ),
        'tableParameters' => array()
    );
    public $queries = array(
        'id'         => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
        'user_id'    => array('type' => 'integer', 'null' => false),
        'label'      => array('type' => 'text', 'null' => true, 'length' => 1073741824),
        'query_sql'  => array('type' => 'text', 'null' => false, 'length' => 1073741824),
        'query_hash' => array('type' => 'text', 'null' => false, 'length' => 1073741824),
        'public'     => array('type' => 'boolean', 'null' => false, 'default' => false),
        'created'    => array('type' => 'datetime', 'null' => true),
        'modified'   => array('type' => 'datetime', 'null' => true),
        'indexes'    => array(
            'PRIMARY' => array('unique' => true, 'column' => 'id')
        ),
        'tableParameters' => array()
    );
    public $users = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
        'username' => array('type' => 'string', 'null' => false),
        'password' => array('type' => 'string', 'null' => false, 'length' => 40),
        'created' => array('type' => 'datetime', 'null' => true),
        'modified' => array('type' => 'datetime', 'null' => true),
        'access_role' => array('type' => 'string', 'null' => false, 'default' => 'limited', 'length' => 50),
        'indexes' => array(
            'PRIMARY' => array('unique' => true, 'column' => 'id'),
            'users_username_key' => array('unique' => true, 'column' => 'username')
        ),
        'tableParameters' => array()
    );
}
