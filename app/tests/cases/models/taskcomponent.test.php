<?php 
/* SVN FILE: $Id$ */
/* Taskcomponent Test cases generated on: 2009-11-19 15:42:19 : 1258616539*/
App::import('Model', 'Taskcomponent');

class TaskcomponentTestCase extends CakeTestCase {
	var $Taskcomponent = null;
	var $fixtures = array('app.taskcomponent');

	function startTest() {
		$this->Taskcomponent =& ClassRegistry::init('Taskcomponent');
	}

	function testTaskcomponentInstance() {
		$this->assertTrue(is_a($this->Taskcomponent, 'Taskcomponent'));
	}

	function testTaskcomponentFind() {
		$this->Taskcomponent->recursive = -1;
		$results = $this->Taskcomponent->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Taskcomponent' => array(
			'id'  => 1,
			'task_id'  => 1,
			'taskdetail_id'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>