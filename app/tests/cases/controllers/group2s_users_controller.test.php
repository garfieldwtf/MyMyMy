<?php 
/* SVN FILE: $Id$ */
/* Group2sUsersController Test cases generated on: 2010-09-06 09:46:21 : 1283737581*/
App::import('Controller', 'Group2sUsers');

class TestGroup2sUsers extends Group2sUsersController {
	var $autoRender = false;
}

class Group2sUsersControllerTest extends CakeTestCase {
	var $Group2sUsers = null;

	function startTest() {
		$this->Group2sUsers = new TestGroup2sUsers();
		$this->Group2sUsers->constructClasses();
	}

	function testGroup2sUsersControllerInstance() {
		$this->assertTrue(is_a($this->Group2sUsers, 'Group2sUsersController'));
	}

	function endTest() {
		unset($this->Group2sUsers);
	}
}
?>