<?php

App::uses('AppController', 'Controller');
App::uses('Query', 'Model');

class QueriesController extends AppController
{
    public $components = array(
        'Connection',
        'Paginator'
    );
    public $helpers = array(
        'Text' => array(
            'className' => 'ExtraText'
        )
    );

    public function isAuthorized($user)
    {
        if (in_array($this->action, array('index', 'delete'))) {
            $query_id = isset($this->request->params['pass'][0]) ? $this->request->params['pass'][0] : false;
            if (! $query_id) {
                return true;
            } elseif ($this->Query->isOwnedBy($query_id, $user['id'])) {
                return true;
            }
        }

        if (in_array($this->action, array('history', 'saved'))) {
            return true;
        }

        return parent::isAuthorized($user);
    }

    public function index($id = null)
    {
        $this->loadDefinedQuery();

        if (isset($this->request->named['define_table']) && isset($this->request->named['define_table_method'])) {
            $this->loadTableQuery($this->request->named['define_table'], $this->request->named['define_table_method']);
        } elseif ($id) {
            $this->loadQuery($id);
        }
        $this->handleFormSubmission();
    }

    public function history()
    {
        $this->Paginator->settings = array(
            'limit' => 100,
            'order' => array(
                'Query.modified' => 'desc'
            ),
            'conditions' => array(
                'user_id' => $this->Auth->user('id'),
                'label'   => null
            ),
        );

        $this->set('queries', $this->Paginator->paginate('Query'));
    }

    public function saved($all = false)
    {
        $conditions = array(
            'label IS NOT NULL'
        );
        if ($all) {
            $conditions['public'] = true;
        } else {
            $conditions['user_id'] = $this->Auth->user('id');
        }
        $this->set('queries', $this->Query->find('all', array(
            'conditions' => $conditions,
            'order'      => array('Query.modified DESC')
        )));
        $this->set('showing_all', (bool) $all);
    }

    public function delete($id = null)
    {
        if (!$this->request->is('post')) {
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
        if (!$this->Query->exists()) {
            throw new NotFoundException(__('Invalid query'));
        }
        if (!$this->formWasSubmitted()) {
            $query = $this->Query->read(null, $id);
            if ($query['Query']['user_id'] != $this->Auth->user('id')) {
                $this->Query->id = null;
                $query = array('Query' => array('query_sql' => $query['Query']['query_sql']));
            }
            $this->request->data = $query;
        }
    }

    protected function loadTableQuery($table, $method)
    {
        if (!in_array($method, array('SelectStar', 'SelectFields', 'Insert', 'Update', 'Delete'))) {
            return false;
        }

        if ($this->formWasSubmitted()) {
            return false;
        }

        $remote_connection = $this->Connection->getRemoteConnection();
        $table_queries = new \SQLBoss\Describe\TableQueries($remote_connection);
        if (strstr($table, '.')) {
            list($schema, $table) = explode('.', $table);
        } else {
            $table = $table;
            $schema = 'public';
        }
        $describe_table = new SQLBoss\Describe\Table($schema, $table, $table_queries);

        $method = "get{$method}Sql";
        $this->request->data = array(
            'Query' => array(
                'query_sql' => $describe_table->$method()
            )
        );
    }

    protected function handleFormSubmission()
    {
        if (!$this->formWasSubmitted()) {
            return false;
        }
        $this->saveWasClicked();
        $this->runQuery();
    }

    protected function saveWasClicked()
    {
        if (!isset($this->request->data['save'])) {
            return false;
        }

        $label = $this->request->data['Query']['label'];

        $query = new Query();
        $existing = $query->findByLabel($label);
        if ($existing) {
            $query->id = $existing['Query']['id'];
            $saved = $query->save(array(
                'Query' => array(
                    'user_id'   => $this->Auth->user('id'),
                    'query_sql' => $this->request->data['Query']['query_sql'],
                    'public'    => $this->request->data['Query']['public']
                )
            ));
        } else {
            $query->create();
            $saved = $query->save(array(
                'Query' => array(
                    'user_id'   => $this->Auth->user('id'),
                    'query_sql' => $this->request->data['Query']['query_sql'],
                    'label'     => $this->request->data['Query']['label'],
                    'public'     => $this->request->data['Query']['public']
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
        $query_hash = $this->Query->getQueryHash($this->data['Query']['query_sql'] . $this->Auth->user('id'));
        $exists = $this->Query->findByQueryHash($query_hash);
        if ($exists) {
            $this->Query->id = $exists['Query']['id'];
        } else {
            $this->Query->create();
        }

        $this->Query->save(array(
            'Query' => array(
                'user_id'   => $this->Auth->user('id'),
                'query_sql' => $this->request->data['Query']['query_sql']
            )
        ));
        $connnection = $this->Connection->getConnection();
        $remote_connection = $connnection->getRemoteConnection($connnection->data['Connection']);

        $query_runner = new \SQLBoss\QueryRunner(array(
            'remote_connection' => $remote_connection,
            'sql'               => $this->request->data['Query']['query_sql']
        ));
        $statements = $query_runner->runQueries();
        $query_errors = $query_runner->getErrors() ?: array();
        $this->set(compact('statements', 'query_errors'));
    }

    private function loadDefinedQuery()
    {
        if (empty($this->request->named['defined_query'])) {
            return;
        }

        $preloaded_queries = [
            'select_function' => function () {
                $remote_connection = $this->Connection->getRemoteConnection();
                $oid = $this->request->named['function_oid'];

                return \SQLBoss\getFunctionSelectQuery(
                    \SQLBoss\getFunction([$remote_connection, 'fetchAssoc'], $oid)
                );
            }
        ];

        if (empty($preloaded_queries[$this->request->named['defined_query']])) {
            throw new NotImplementedException("Preloaded query not found.");
        }

        if (isset($this->request->data['Query'])) {
            return;
        }

        $this->request->data['Query'] = [
            'query_sql' => call_user_func(
                $preloaded_queries[$this->request->named['defined_query']]
            )
        ];
    }
}
