<?php 
/* SVN FILE: $Id$ */
/* User Test cases generated on: 2009-11-19 15:42:36 : 1258616556*/
App::import('Model', 'User');

class UserTestCase extends CakeTestCase {
	var $User = null;
	var $fixtures = array('app.user');

	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function testUserInstance() {
		$this->assertTrue(is_a($this->User, 'User'));
	}

	function testUserFind() {
		$this->User->recursive = -1;
		$results = $this->User->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('User' => array(
			'id'  => 1,
			'username'  => 'Lorem ipsum dolor ',
			'password'  => 'Lorem ipsum dolor sit amet',
			'superuser'  => 1,
			'protocol_id'  => 1,
			'job_title'  => 'Lorem ipsum dolor sit amet',
			'name'  => 'Lorem ipsum dolor sit amet',
			'email'  => 'Lorem ipsum dolor sit amet',
			'telephone'  => 'Lorem ipsum dolor sit amet',
			'mobile'  => 'Lorem ipsum dolor sit amet',
			'fax'  => 'Lorem ipsum dolor sit amet',
			'address'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'title_id'  => 1,
			'deleted'  => 1,
			'deleted_date'  => '2009-11-19 15:42:36',
			'bahagian'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-11-19 15:42:36',
			'updated'  => '2009-11-19 15:42:36'
		));
		$this->assertEqual($results, $expected);
	}
}
?>