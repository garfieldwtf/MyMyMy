<?php 
/* SVN FILE: $Id$ */
/* Userstatus Test cases generated on: 2009-11-19 15:42:38 : 1258616558*/
App::import('Model', 'Userstatus');

class UserstatusTestCase extends CakeTestCase {
	var $Userstatus = null;
	var $fixtures = array('app.userstatus');

	function startTest() {
		$this->Userstatus =& ClassRegistry::init('Userstatus');
	}

	function testUserstatusInstance() {
		$this->assertTrue(is_a($this->Userstatus, 'Userstatus'));
	}

	function testUserstatusFind() {
		$this->Userstatus->recursive = -1;
		$results = $this->Userstatus->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Userstatus' => array(
			'id'  => 1,
			'task_id'  => 1,
			'user_id'  => 1,
			'updater'  => 1,
			'status'  => 'Lorem ipsum dolor sit amet',
			'percent'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'status_date'  => '2009-11-19 15:42:38',
			'closed'  => 1,
			'date_closed'  => '2009-11-19 15:42:38',
			'deleted'  => 1,
			'deleted_date'  => '2009-11-19 15:42:38',
			'created'  => '2009-11-19 15:42:38',
			'updated'  => '2009-11-19 15:42:38'
		));
		$this->assertEqual($results, $expected);
	}
}
?>