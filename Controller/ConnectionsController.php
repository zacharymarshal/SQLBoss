<?php

App::uses('AppController', 'Controller');

class ConnectionsController extends AppController
{
	public function isAuthorized($user)
	{
		if ($this->action == 'add') {
			return true;
		}

		if (in_array($this->action, array('edit', 'delete'))) {
			$connection_id = $this->request->params['pass'][0];
			if ($this->Connection->isOwnedBy($connection_id, $user['id'])) {
				return true;
			}
		}

		return parent::isAuthorized($user);
	}

	public function index()
	{
		$this->Connection->recursive = 0;
		$this->set('connections', $this->paginate());
	}

	public function add()
	{
		if ($this->request->is('post')) {
			$this->Connection->create();

			if (false) { // check user is not a boss
				$this->request->data['Connection']['user_id'] = $this->Auth->user('id');
			}
			if ($this->Connection->save($this->request->data)) {
				$this->Session->setFlash(__('The connection has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The connection could not be saved. Please, try again.'));
			}
		}
		$drivers = array(
			'pgsql'  => 'PostgreSQL',
			'sqlite' => 'SQLite',
			'mysql'  => 'MySQL'
		);
		$users = $this->Connection->User->find('list', array(
			'fields' => array('User.id', 'User.username'),
		));
		$user_id = (isset($this->request->params['named']['user_id']) ?
			$this->request->params['named']['user_id'] : $this->Auth->user('id'));
		$this->set(compact('drivers', 'users', 'user_id'));
	}

	public function edit($id = null)
	{
		$this->Connection->id = $id;
		if ( ! $this->Connection->exists()) {
			throw new NotFoundException(__('Invalid connection'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$connection_data = $this->request->data + $this->Connection->read(null, $id);
			if ($this->Connection->save($connection_data)) {
				$this->Session->setFlash(__('The connection has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The connection could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Connection->read(null, $id);
		}
		$drivers = array(
			'pgsql'  => 'PostgreSQL',
			'sqlite' => 'SQLite',
			'mysql'  => 'MySQL'
		);
		$connection = $this->Connection;
		$this->set(compact('drivers', 'connection'));
	}

	public function delete($id = null)
	{
		if ( ! $this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Connection->id = $id;
		if (!$this->Connection->exists()) {
			throw new NotFoundException(__('Invalid connection'));
		}
		if ($this->Connection->delete()) {
			$this->Session->setFlash(__('Connection deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Connection was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
