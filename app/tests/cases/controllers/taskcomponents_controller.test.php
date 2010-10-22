<?php 
/* SVN FILE: $Id$ */
/* TaskcomponentsController Test cases generated on: 2009-11-19 15:42:19 : 1258616539*/
App::import('Controller', 'Taskcomponents');

class TestTaskcomponents extends TaskcomponentsController {
	var $autoRender = false;
}

class TaskcomponentsControllerTest extends CakeTestCase {
	var $Taskcomponents = null;

	function startTest() {
		$this->Taskcomponents = new TestTaskcomponents();
		$this->Taskcomponents->constructClasses();
	}

	function testTaskcomponentsControllerInstance() {
		$this->assertTrue(is_a($this->Taskcomponents, 'TaskcomponentsController'));
	}

	function endTest() {
		unset($this->Taskcomponents);
	}
}
?>