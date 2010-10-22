<?php 
/* SVN FILE: $Id$ */
/* TasksController Test cases generated on: 2009-11-19 15:42:30 : 1258616550*/
App::import('Controller', 'Tasks');

class TestTasks extends TasksController {
	var $autoRender = false;
}

class TasksControllerTest extends CakeTestCase {
	var $Tasks = null;

	function startTest() {
		$this->Tasks = new TestTasks();
		$this->Tasks->constructClasses();
	}

	function testTasksControllerInstance() {
		$this->assertTrue(is_a($this->Tasks, 'TasksController'));
	}

	function endTest() {
		unset($this->Tasks);
	}
}
?>