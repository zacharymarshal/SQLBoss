<?php
App::uses('Query', 'Model');

/**
 * Query Test Case
 *
 */
class QueryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.query',
		'app.user',
		'app.group',
		'app.server'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Query = ClassRegistry::init('Query');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Query);

		parent::tearDown();
	}

}
