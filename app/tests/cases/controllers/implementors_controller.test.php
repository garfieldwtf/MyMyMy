<?php 
/* SVN FILE: $Id$ */
/* ImplementorsController Test cases generated on: 2009-11-19 15:42:01 : 1258616521*/
App::import('Controller', 'Implementors');

class TestImplementors extends ImplementorsController {
	var $autoRender = false;
}

class ImplementorsControllerTest extends CakeTestCase {
	var $Implementors = null;

	function startTest() {
		$this->Implementors = new TestImplementors();
		$this->Implementors->constructClasses();
	}

	function testImplementorsControllerInstance() {
		$this->assertTrue(is_a($this->Implementors, 'ImplementorsController'));
	}

	function endTest() {
		unset($this->Implementors);
	}
}
?>