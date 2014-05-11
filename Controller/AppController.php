<?php

App::uses('Controller', 'Controller');
App::uses('Connection', 'Model');
App::uses('AssetrincHelper', 'View/Helper');

class AppController extends Controller
{
    public $components = array(
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'users',
                'action'     => 'login'
            ),
            'logoutRedirect' => array(
                'controller' => 'users',
                'action'     => 'login'
            ),
            'loginRedirect' => array(
                'controller' => 'databases',
                'action'     => 'index'
            ),
            'authorize' => array('Controller')
        ),
        'Session'
    );

    public $helpers = array(
        'Html',
        'Form' => array(
            'className' => 'ExtraForm'
        ),
        'Session',
        'Assetrinc',
    );

    public function beforeFilter()
    {
        $this->set('auth_user', $this->Auth->user());
    }

    public function isAuthorized($user)
    {
        if (isset($user['access_role']) && $user['access_role'] === 'admin') {
            return true;
        }
        $this->Session->setFlash('Not authorized.');

        return false;
    }
}
