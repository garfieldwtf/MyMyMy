<?php 
/* SVN FILE: $Id$ */
/* PermissionsController Test cases generated on: 2009-11-19 15:42:08 : 1258616528*/
App::import('Controller', 'Permissions');

class TestPermissions extends PermissionsController {
	var $autoRender = false;
}

class PermissionsControllerTest extends CakeTestCase {
	var $Permissions = null;

	function startTest() {
		$this->Permissions = new TestPermissions();
		$this->Permissions->constructClasses();
	}

	function testPermissionsControllerInstance() {
		$this->assertTrue(is_a($this->Permissions, 'PermissionsController'));
	}

	function endTest() {
		unset($this->Permissions);
	}
}
?>