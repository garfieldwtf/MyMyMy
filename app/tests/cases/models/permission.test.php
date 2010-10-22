<?php 
/* SVN FILE: $Id$ */
/* Permission Test cases generated on: 2009-11-19 15:42:08 : 1258616528*/
App::import('Model', 'Permission');

class PermissionTestCase extends CakeTestCase {
	var $Permission = null;
	var $fixtures = array('app.permission');

	function startTest() {
		$this->Permission =& ClassRegistry::init('Permission');
	}

	function testPermissionInstance() {
		$this->assertTrue(is_a($this->Permission, 'Permission'));
	}

	function testPermissionFind() {
		$this->Permission->recursive = -1;
		$results = $this->Permission->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Permission' => array(
			'id'  => 1,
			'role_id'  => 1,
			'group_id'  => 1,
			'model'  => 'Lorem ipsum dolor sit amet',
			'level'  => 1,
			'view'  => 'Lorem ipsum dolor sit amet',
			'edit'  => 'Lorem ipsum dolor sit amet',
			'delete'  => 'Lorem ipsum dolor sit amet',
			'approve'  => 'Lorem ipsum dolor sit amet',
			'disapprove'  => 'Lorem ipsum dolor sit amet'
		));
		$this->assertEqual($results, $expected);
	}
}
?>