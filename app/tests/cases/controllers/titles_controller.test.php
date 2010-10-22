<?php 
/* SVN FILE: $Id$ */
/* TitlesController Test cases generated on: 2009-11-19 15:42:34 : 1258616554*/
App::import('Controller', 'Titles');

class TestTitles extends TitlesController {
	var $autoRender = false;
}

class TitlesControllerTest extends CakeTestCase {
	var $Titles = null;

	function startTest() {
		$this->Titles = new TestTitles();
		$this->Titles->constructClasses();
	}

	function testTitlesControllerInstance() {
		$this->assertTrue(is_a($this->Titles, 'TitlesController'));
	}

	function endTest() {
		unset($this->Titles);
	}
}
?>