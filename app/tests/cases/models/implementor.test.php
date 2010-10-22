<?php 
/* SVN FILE: $Id$ */
/* Implementor Test cases generated on: 2009-11-19 15:42:01 : 1258616521*/
App::import('Model', 'Implementor');

class ImplementorTestCase extends CakeTestCase {
	var $Implementor = null;
	var $fixtures = array('app.implementor');

	function startTest() {
		$this->Implementor =& ClassRegistry::init('Implementor');
	}

	function testImplementorInstance() {
		$this->assertTrue(is_a($this->Implementor, 'Implementor'));
	}

	function testImplementorFind() {
		$this->Implementor->recursive = -1;
		$results = $this->Implementor->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Implementor' => array(
			'id'  => 1,
			'task_id'  => 1,
			'user_id'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>