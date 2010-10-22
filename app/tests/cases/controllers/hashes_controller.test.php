<?php 
/* SVN FILE: $Id$ */
/* HashesController Test cases generated on: 2009-11-19 15:41:58 : 1258616518*/
App::import('Controller', 'Hashes');

class TestHashes extends HashesController {
	var $autoRender = false;
}

class HashesControllerTest extends CakeTestCase {
	var $Hashes = null;

	function startTest() {
		$this->Hashes = new TestHashes();
		$this->Hashes->constructClasses();
	}

	function testHashesControllerInstance() {
		$this->assertTrue(is_a($this->Hashes, 'HashesController'));
	}

	function endTest() {
		unset($this->Hashes);
	}
}
?>