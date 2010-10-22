<?php 
/* SVN FILE: $Id$ */
/* Group2sController Test cases generated on: 2010-09-06 09:45:32 : 1283737532*/
App::import('Controller', 'Group2s');

class TestGroup2s extends Group2sController {
	var $autoRender = false;
}

class Group2sControllerTest extends CakeTestCase {
	var $Group2s = null;

	function startTest() {
		$this->Group2s = new TestGroup2s();
		$this->Group2s->constructClasses();
	}

	function testGroup2sControllerInstance() {
		$this->assertTrue(is_a($this->Group2s, 'Group2sController'));
	}

	function endTest() {
		unset($this->Group2s);
	}
}
?>