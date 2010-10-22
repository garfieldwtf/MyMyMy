<?php 
/* SVN FILE: $Id$ */
/* ProtocolsController Test cases generated on: 2009-11-19 15:42:12 : 1258616532*/
App::import('Controller', 'Protocols');

class TestProtocols extends ProtocolsController {
	var $autoRender = false;
}

class ProtocolsControllerTest extends CakeTestCase {
	var $Protocols = null;

	function startTest() {
		$this->Protocols = new TestProtocols();
		$this->Protocols->constructClasses();
	}

	function testProtocolsControllerInstance() {
		$this->assertTrue(is_a($this->Protocols, 'ProtocolsController'));
	}

	function endTest() {
		unset($this->Protocols);
	}
}
?>