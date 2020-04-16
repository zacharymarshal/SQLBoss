<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController
{
    private $user = null;
    public function isAuthorized($user)
    {
        $this->user = $user;
        if ($this->action == 'logout') {
            return true;
        }

        if (in_array($this->action, array('view', 'edit'))) {
            $user_id = (isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : false);
            if ($user_id == $user['id']) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }

    public function index()
    {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function view($id = null)
    {
        $this->User->id = $id;
        if ( ! $this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
        $access_roles = array(
            'admin'   => 'Administrator',
            'limited' => 'Limited'
        );
        $this->set(compact('access_roles'));
    }

    public function edit($id = null)
    {
        $this->User->id = $id;
        if ( ! $this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'edit', $id));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
        }
        if (isset($this->user['access_role']) && $this->user['access_role'] === 'admin') {
            $access_roles = array(
                'admin'   => 'Administrator',
                'limited' => 'Limited'
            );
        } else {
            $access_roles = array(
                'limited' => 'Limited'
            );
        }
        $this->set(compact('access_roles'));
    }

    public function delete($id = null)
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function login()
    {
//        if ($this->Session->read('Auth.User')) {
//            $this->Session->setFlash('You are logged in!');
//            $this->redirect(array('controller' => 'databases', 'action' => 'index'), null, false);
//        }
//
//        if ($this->request->is('post')) {
//            if ($this->Auth->login()) {
//                $this->redirect($this->Auth->redirect());
//            } else {
//                $this->Session->setFlash('Your username or password was incorrect.');
//            }
//        }
        $this->Session->setFlash("GET Code: " . $_GET['code']);
        $this->googlogin();

    }

    public function logout()
    {
        $this->Session->setFlash('Good-Bye');
        $this->redirect($this->Auth->logout());
    }

    public function googlogin()
    {
        ########## Google Configs - REMOVE #############
        $google_client_id 		= '461023085744-05mbn00b7t1n090p88cr709u8c1rbalj.apps.googleusercontent.com';
        $google_client_secret 	= 'S8pcv14E9Sa9r-0fg7svxRxh';
        $google_redirect_url 	= 'http://127.0.0.1:8000/index.php';
//        $google_developer_key 	= 'AIzaSyAHWm--OHu0u5Wk0hsUI2u28rKHyH8Do24';

        try {
            $google_client = new Google_Client();
            $google_client->setApplicationName('Login to localhost');
            $google_client->setClientId($google_client_id);
            $google_client->setClientSecret($google_client_secret);
            $google_client->setRedirectUri($google_redirect_url);
//            $google_client->setDeveloperKey($google_developer_key);
            $google_client->addScope('https://mail.google.com/');
            $this->Session->setFlash("connected to google client successfully");
        } catch (Exception $e) {
            $this->Session->setFlash($e->getMessage());
        }

        try {
            $google_oauth = new \Google_Service_Oauth2($google_client);
            $this->Session->setFlash("created google oauth object");
        } catch (Exception $e) {
            $this->Session->setFlash($e->getMessage());
        }

        $this->Session->setFlash("GET Code: " . $this->request->query['code']);
        if (empty($_GET['code']))
        {
            $google_client->authenticate($_REQUEST['code']);
            $this->Session->write('token', $google_client->getAccessToken());
            $this->redirect(filter_var($google_redirect_url, FILTER_SANITIZE_URL), null, false);
            $this->Session->setFlash("redirected");
            //header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
//            return;
        }

        if ($this->Session->read('token'))
        {
            $this->Session->setFlash("reading token");
            $google_client->setAccessToken($this->Session->read('token'));
        }

        if ($google_client->getAccessToken())
        {
            //Get user details if user is logged in
            $user 				= $google_oauth->userinfo->get();
            $user_id 			= $user['id'];
            $user_name 			= filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
            $email 				= filter_var($user['email'], FILTER_SANITIZE_EMAIL);
            $this->Session->write('token', $google_client->getAccessToken());
            $this->Session->setFlash('You are logged in!');
            pr($user);
        } else
        {
            $authUrl = $google_client->createAuthUrl();
        }
        $this->Session->setFlash("Access token: " . $google_client->getAccessToken());

        if(isset($authUrl)) //user is not logged in, show login button
        {
            $this->set('authUrl', $authUrl);
        } else // user logged in
        {
            $this->Session->setFlash('You are logged in!');
//            return $this->redirect(array('controller' => 'databases', 'action' => 'index'), null, false);

            $result = $this->User->find('count', array('conditions' => array('google_id' => $user_id)));
            if($result > 0)
            {
                //check illuminateed.net here
            }
        }
    }

    public function google_login() {
//        $this->Session->setFlash('You are logged in!');
        return $this->redirect(array('controller' => 'databases', 'action' => 'index'), null, false);
    }
}
