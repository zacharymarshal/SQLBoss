<?php

App::uses('AppController', 'Controller');
App::uses('Query', 'Model');

class QueriesController extends AppController
{
    public $components = array(
        'Connection'
    );
    public $helpers = array(
        'Text' => array(
            'className' => 'ExtraText'
        )
    );

    public function index($id = null)
    {
        $this->loadQuery($id);
        $this->handleFormSubmission();
    }

    protected function formWasSubmitted()
    {
        return ($this->request->is('post') || $this->request->is('put'));
    }

    protected function loadQuery($id)
    {
        if ($id === null) {
            return false;
        }
        $this->Query->id = $id;
        if ( ! $this->Query->exists()) {
            throw new NotFoundException(__('Invalid query'));
        }
        if ( ! $this->formWasSubmitted()) {
            $this->request->data = $this->Query->read(null, $id);
        }
    }

    protected function handleFormSubmission()
    {
        if ( ! $this->formWasSubmitted()) {
            return false;
        }
        $this->saveWasClicked();
        $this->runQuery();
    }

    protected function saveWasClicked()
    {
        if ( ! isset($this->request->data['save'])) {
            return false;
        }
        
        $label = $this->request->data['Query']['label'];

        $query = new Query();
        $existing = $query->findByLabel($label);
        if ($existing) {
            $query->id = $existing['Query']['id'];
            $saved = $query->save(array(
                'Query' => array(
                    'query_sql' => $this->request->data['Query']['query_sql']
                )
            ));
        } else {
            $query->create();
            $saved = $query->save(array(
                'Query' => array(
                    'user_id'   => $this->Auth->user('id'),
                    'query_sql' => $this->request->data['Query']['query_sql'],
                    'label'     => $this->request->data['Query']['label']
                )
            ));
        }
        
        if ($saved) {
            $this->Session->setFlash(__('The query has been saved'));
            $this->redirect(array('action' => 'index', $query->id) + $this->viewVars['connection_parameters']);
        } else {
            $this->Session->setFlash(__('The query could not be saved. Please, try again.'));
        }

        return true;
    }

    protected function runQuery()
    {
        try {

            $query_hash = $this->Query->getQueryHash($this->data['Query']['query_sql']);
            $exists = $this->Query->findByQueryHash($query_hash);
            if ($exists) {
                $this->Query->id = $exists['Query']['id'];
            }
            else {
                $this->Query->create();
            }

            $this->Query->save(array(
                'Query' => array(
                    'user_id'   => $this->Auth->user('id'),
                    'query_sql' => $this->request->data['Query']['query_sql']
                )
            ));
            $connnection = $this->Connection->getConnection();
            $statements = $connnection
                ->getRemoteConnection($connnection->data)
                ->query($this->request->data['Query']['query_sql']);
            $this->set(compact('statements'));
        } catch (PDOException $e) {
            $query_error = $e->getMessage();
            $this->set(compact('query_error'));
        }
    }

    public function history()
    {
        $this->set('queries', $this->Query->find('all', array(
            'conditions' => array(
                'user_id' => $this->Auth->user('id'),
                'label'   => null
            ),
            'order'      => array('Query.modified DESC')
        )));
    }

    public function saved()
    {
        $this->set('queries', $this->Query->find('all', array(
            'conditions' => array(
                'user_id' => $this->Auth->user('id'),
                'label IS NOT NULL'
            ),
            'order'      => array('Query.modified DESC')
        )));
    }

    public function view($id = null)
    {
        $this->Query->id = $id;
        if (!$this->Query->exists()) {
            throw new NotFoundException(__('Invalid query'));
        }
        $this->set('query', $this->Query->read(null, $id));
    }

    public function add()
    {
        if ( ! $this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        $this->Query->create();
        $this->request->data['Query']['user_id'] = $this->Auth->user('id');
        if ($this->Query->save($this->request->data)) {
            $this->Session->setFlash(__('The query has been saved'));
            $this->redirect(array('action' => 'index') + $this->viewVars['connection_parameters']);
        } else {
            $this->Session->setFlash(__('The query could not be saved. Please, try again.'));
        }
    }

    public function edit($id = null)
    {
        if ( ! $this->request->is('post') || ! $this->request->is('put')) {
            throw new MethodNotAllowedException();
        }

        $this->Query->id = $id;
        if ( ! $this->Query->exists()) {
            throw new NotFoundException(__('Invalid query'));
        }
        $this->request->data['Query']['user_id'] = $this->Auth->user('id');
        if ($this->Query->save($this->request->data)) {
            $this->Session->setFlash(__('The query has been saved'));
            $this->redirect(array('action' => 'index') + $this->viewVars['connection_parameters']);
        } else {
            $this->Session->setFlash(__('The query could not be saved. Please, try again.'));
        }
    }

    public function delete($id = null)
    {
        if ( ! $this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Query->id = $id;
        if (!$this->Query->exists()) {
            throw new NotFoundException(__('Invalid query'));
        }

        if ($this->Query->delete()) {
            $this->Session->setFlash(__('Query deleted'));
            $this->redirect(array('action' => 'saved') + $this->viewVars['connection_parameters']);
        }
        $this->Session->setFlash(__('Query was not deleted'));
        $this->redirect(array('action' => 'saved') + $this->viewVars['connection_parameters']);
    }
}
