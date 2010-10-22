<?php 
/* SVN FILE: $Id$ */
/* TasktypesController Test cases generated on: 2009-11-19 15:42:32 : 1258616552*/
App::import('Controller', 'Tasktypes');

class TestTasktypes extends TasktypesController {
	var $autoRender = false;
}

class TasktypesControllerTest extends CakeTestCase {
	var $Tasktypes = null;

	function startTest() {
		$this->Tasktypes = new TestTasktypes();
		$this->Tasktypes->constructClasses();
	}

	function testTasktypesControllerInstance() {
		$this->assertTrue(is_a($this->Tasktypes, 'TasktypesController'));
	}

	function endTest() {
		unset($this->Tasktypes);
	}
}
?>