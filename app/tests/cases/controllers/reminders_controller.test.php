<?php 
/* SVN FILE: $Id$ */
/* RemindersController Test cases generated on: 2010-06-04 09:01:50 : 1275613310*/
App::import('Controller', 'Reminders');

class TestReminders extends RemindersController {
	var $autoRender = false;
}

class RemindersControllerTest extends CakeTestCase {
	var $Reminders = null;

	function startTest() {
		$this->Reminders = new TestReminders();
		$this->Reminders->constructClasses();
	}

	function testRemindersControllerInstance() {
		$this->assertTrue(is_a($this->Reminders, 'RemindersController'));
	}

	function endTest() {
		unset($this->Reminders);
	}
}
?>