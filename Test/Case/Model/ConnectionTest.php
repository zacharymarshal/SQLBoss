<?php
App::uses('Connection', 'Model');

/**
 * Connection Test Case
 *
 */
class ConnectionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.connection',
		'app.user',
		'app.group',
		'app.server',
		'app.query'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Connection = ClassRegistry::init('Connection');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Connection);

		parent::tearDown();
	}

}
