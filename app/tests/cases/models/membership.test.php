<?php 
/* SVN FILE: $Id$ */
/* Membership Test cases generated on: 2009-11-19 15:42:05 : 1258616525*/
App::import('Model', 'Membership');

class MembershipTestCase extends CakeTestCase {
	var $Membership = null;
	var $fixtures = array('app.membership');

	function startTest() {
		$this->Membership =& ClassRegistry::init('Membership');
	}

	function testMembershipInstance() {
		$this->assertTrue(is_a($this->Membership, 'Membership'));
	}

	function testMembershipFind() {
		$this->Membership->recursive = -1;
		$results = $this->Membership->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Membership' => array(
			'id'  => 1,
			'user_id'  => 1,
			'group_id'  => 1,
			'role_id'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>