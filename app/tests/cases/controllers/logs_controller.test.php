<?php 
/* SVN FILE: $Id$ */
/* LogsController Test cases generated on: 2009-11-19 15:42:03 : 1258616523*/
App::import('Controller', 'Logs');

class TestLogs extends LogsController {
	var $autoRender = false;
}

class LogsControllerTest extends CakeTestCase {
	var $Logs = null;

	function startTest() {
		$this->Logs = new TestLogs();
		$this->Logs->constructClasses();
	}

	function testLogsControllerInstance() {
		$this->assertTrue(is_a($this->Logs, 'LogsController'));
	}

	function endTest() {
		unset($this->Logs);
	}
}
?>