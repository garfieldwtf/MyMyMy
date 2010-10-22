<?php 
/* SVN FILE: $Id$ */
/* Role Test cases generated on: 2009-11-19 15:42:15 : 1258616535*/
App::import('Model', 'Role');

class RoleTestCase extends CakeTestCase {
	var $Role = null;
	var $fixtures = array('app.role');

	function startTest() {
		$this->Role =& ClassRegistry::init('Role');
	}

	function testRoleInstance() {
		$this->assertTrue(is_a($this->Role, 'Role'));
	}

	function testRoleFind() {
		$this->Role->recursive = -1;
		$results = $this->Role->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Role' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor ',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'deleted'  => 1,
			'deleted_date'  => '2009-11-19 15:42:15'
		));
		$this->assertEqual($results, $expected);
	}
}
?>