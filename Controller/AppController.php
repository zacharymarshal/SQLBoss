<?php

App::uses('Controller', 'Controller');
App::uses('Connection', 'Model');

class AppController extends Controller
{
    public $components = array(
        'Auth',
        'Session'
    );

    public $helpers = array(
        'Html',
        'Form' => array(
            'className' => 'ExtraForm'
        ),
        'Session',

    );

    public function beforeFilter()
    {
        $this->Auth->loginAction = array(
            'controller' => 'users',
            'action'     => 'login'
        );
        $this->Auth->logoutRedirect = array(
            'controller' => 'users',
            'action'     => 'login'
        );
        $this->Auth->loginRedirect = array(
            'controller' => 'databases',
            'action'     => 'index'
        );
        $this->set('auth_user', $this->Auth->user());
    }

    public function isAuthorized()
    {
        return false;
    }
}
