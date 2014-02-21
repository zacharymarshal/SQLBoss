<?php

App::uses('Component', 'Controller');

class ConnectionComponent extends Component
{
    protected $controller;
    protected $connection;

    public function startup($controller)
    {
        $this->controller = $controller;
        if ( ! $this->getConnection($controller) && get_class($controller) != 'DatabasesController') {
            $controller->Session->setFlash(__('Select a database'));
            $controller->redirect(array('controller' => 'databases', 'action' => 'index'));
        }
        $connection_parameters = array();
        if (isset($controller->request->params['connection_id'])) {
            $connection_parameters = array(
                'connection_id' => $controller->request->params['connection_id'],
                'database'      => $controller->request->params['database']
            );
        }
        $connection = false;
        if ($this->getConnection()) {
            $connection = $this->getConnection()->data;
        }

        $controller->set(compact('connection', 'connection_parameters'));
    }

    public function getConnection()
    {
        if (isset($this->connection)) {
            return $this->connection;
        }
        if (isset($this->controller->request->params['connection_id'])) {
            $connection = new Connection();
            $connection_id = $this->controller->request->params['connection_id'];
            $connection->read(null, $connection_id);
            if ( ! $connection->data['Connection']['database_name']) {
                $connection->data['Connection']['database_name'] = $this->controller->request->params['database'];
            }
            $this->connection = $connection;
            return $this->connection;
        }
        return false;
    }

    public function getRemoteConnection()
    {
        $connection = $this->getConnection();
        return $connection->getRemoteConnection($connection->data['Connection']);
    }
}
