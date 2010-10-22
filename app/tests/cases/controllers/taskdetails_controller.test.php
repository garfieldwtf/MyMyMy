<?php 
/* SVN FILE: $Id$ */
/* TaskdetailsController Test cases generated on: 2009-11-19 15:42:21 : 1258616541*/
App::import('Controller', 'Taskdetails');

class TestTaskdetails extends TaskdetailsController {
	var $autoRender = false;
}

class TaskdetailsControllerTest extends CakeTestCase {
	var $Taskdetails = null;

	function startTest() {
		$this->Taskdetails = new TestTaskdetails();
		$this->Taskdetails->constructClasses();
	}

	function testTaskdetailsControllerInstance() {
		$this->assertTrue(is_a($this->Taskdetails, 'TaskdetailsController'));
	}

	function endTest() {
		unset($this->Taskdetails);
	}
}
?>