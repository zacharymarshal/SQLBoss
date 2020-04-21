<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController
{
    private $user = null;
    private $googleClient= null;
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
        $this->google_login();
    }

    public function logout()
    {
        $this->Session->delete('token');
        $this->redirect($this->Auth->logout());
    }

    public function google_login()
    {
        try {
            $this->googleClient = new Google_Client();
            $this->googleClient->setApplicationName(GOOGLE_APP_NAME);
            $this->googleClient->setClientId(GOOGLE_OAUTH_CLIENT_ID);
            $this->googleClient->setClientSecret(GOOGLE_OAUTH_CLIENT_SECRET);
            $this->googleClient->setRedirectUri(GOOGLE_OAUTH_REDIRECT_URI);
            $this->googleClient->addScope(GOOGLE_OAUTH_SCOPE);
        } catch (Exception $e) {
            $this->Session->setFlash($e->getMessage());
        }

        try {
            $google_oauth = new \Google_Service_Oauth2($this->googleClient);
        } catch (Exception $e) {
            $this->Session->setFlash($e->getMessage());
        }

        if (isset($this->request->query['code']))
        {
            $this->googleClient->authenticate($this->request->query['code']);
            $this->Session->write('token', $this->googleClient->getAccessToken());
            $this->redirect(filter_var(GOOGLE_OAUTH_REDIRECT_URI, FILTER_SANITIZE_URL), null, false);
            return;
        }

        if ($this->Session->read('token'))
        {
            $this->googleClient->setAccessToken($this->Session->read('token'));
        }


        if ($this->googleClient->getAccessToken())
        {
            $user 				= $google_oauth->userinfo->get();
            $email 				= filter_var($user['email'], FILTER_SANITIZE_EMAIL);
            $domain 				= $user['hd'];
            $this->Session->write('token', $this->googleClient->getAccessToken());
        } else {
            $authUrl = $this->googleClient->createAuthUrl();
        }

        if(isset($authUrl))
        {
            $this->set('authUrl', $authUrl);
        } else
        {
            $data = $this->User->find("first", ['conditions'=> ['username'=> $email]])["User"];
            if ("illuminateed.net" === $domain) {
                $this->Auth->login($data);
                $this->redirect(array('controller' => 'databases', 'action' => 'index'), null, false);
            } else {
                $this->Session->setFlash("Please login with an Illuminate Education authorized user or contact an admin.");
            }
        }
    }
}
