<?php

App::uses('Component', 'Controller');

class ConnectionComponent extends Component
{
	protected $controller;

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
		if (isset($this->controller->request->params['connection_id'])) {
			$connection = new Connection();
			$connection_id = $this->controller->request->params['connection_id'];
			$connection->read(null, $connection_id);
			if ( ! $connection->data['Connection']['database_name']) {
				$connection->data['Connection']['database_name'] = $this->controller->request->params['database'];
			}
			return $connection;
		}
		return false;
	}
}