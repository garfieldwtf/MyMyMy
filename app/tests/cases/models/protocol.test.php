<?php 
/* SVN FILE: $Id$ */
/* Protocol Test cases generated on: 2009-11-19 15:42:12 : 1258616532*/
App::import('Model', 'Protocol');

class ProtocolTestCase extends CakeTestCase {
	var $Protocol = null;
	var $fixtures = array('app.protocol');

	function startTest() {
		$this->Protocol =& ClassRegistry::init('Protocol');
	}

	function testProtocolInstance() {
		$this->assertTrue(is_a($this->Protocol, 'Protocol'));
	}

	function testProtocolFind() {
		$this->Protocol->recursive = -1;
		$results = $this->Protocol->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Protocol' => array(
			'id'  => 1,
			'protocol_title'  => 'Lorem ipsum dolor sit amet',
			'rank'  => 'Lorem ipsum dolor sit amet'
		));
		$this->assertEqual($results, $expected);
	}
}
?>