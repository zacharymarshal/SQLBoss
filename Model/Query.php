<?php

App::uses('AppModel', 'Model');

class Query extends AppModel
{
    public $validate = array(
        'user_id'    => 'numeric',
        'query_sql'  => 'notempty',
        'query_hash' => array('notempty', 'isUnique'),
    );

    public function getQueryHash($query_sql)
    {
        return md5($query_sql);
    }

    public function beforeSave(array $options = array())
    {
        $query_hash = $this->getQueryHash($this->data['Query']['query_sql']);
        $this->data['Query']['query_hash'] = $query_hash;
        return true;
    }
}
