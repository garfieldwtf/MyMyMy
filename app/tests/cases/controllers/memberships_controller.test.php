<?php 
/* SVN FILE: $Id$ */
/* MembershipsController Test cases generated on: 2009-11-19 15:42:05 : 1258616525*/
App::import('Controller', 'Memberships');

class TestMemberships extends MembershipsController {
	var $autoRender = false;
}

class MembershipsControllerTest extends CakeTestCase {
	var $Memberships = null;

	function startTest() {
		$this->Memberships = new TestMemberships();
		$this->Memberships->constructClasses();
	}

	function testMembershipsControllerInstance() {
		$this->assertTrue(is_a($this->Memberships, 'MembershipsController'));
	}

	function endTest() {
		unset($this->Memberships);
	}
}
?>