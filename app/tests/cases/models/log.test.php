<?php 
/* SVN FILE: $Id$ */
/* Log Test cases generated on: 2009-11-19 15:42:03 : 1258616523*/
App::import('Model', 'Log');

class LogTestCase extends CakeTestCase {
	var $Log = null;
	var $fixtures = array('app.log');

	function startTest() {
		$this->Log =& ClassRegistry::init('Log');
	}

	function testLogInstance() {
		$this->assertTrue(is_a($this->Log, 'Log'));
	}

	function testLogFind() {
		$this->Log->recursive = -1;
		$results = $this->Log->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Log' => array(
			'id'  => 1,
			'user_id'  => 1,
			'controller'  => 'Lorem ipsum dolor sit amet',
			'action'  => 'Lorem ipsum dolor sit amet',
			'url'  => 'Lorem ipsum dolor sit amet',
			'timestamp'  => '2009-11-19 15:42:03',
			'message'  => 'Lorem ipsum dolor sit amet'
		));
		$this->assertEqual($results, $expected);
	}
}
?>