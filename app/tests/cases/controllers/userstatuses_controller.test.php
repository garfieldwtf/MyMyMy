<?php 
/* SVN FILE: $Id$ */
/* UserstatusesController Test cases generated on: 2009-11-19 15:42:38 : 1258616558*/
App::import('Controller', 'Userstatuses');

class TestUserstatuses extends UserstatusesController {
	var $autoRender = false;
}

class UserstatusesControllerTest extends CakeTestCase {
	var $Userstatuses = null;

	function startTest() {
		$this->Userstatuses = new TestUserstatuses();
		$this->Userstatuses->constructClasses();
	}

	function testUserstatusesControllerInstance() {
		$this->assertTrue(is_a($this->Userstatuses, 'UserstatusesController'));
	}

	function endTest() {
		unset($this->Userstatuses);
	}
}
?>