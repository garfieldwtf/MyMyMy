<?php 
/* SVN FILE: $Id$ */
/* Taskdetail Test cases generated on: 2009-11-19 15:42:21 : 1258616541*/
App::import('Model', 'Taskdetail');

class TaskdetailTestCase extends CakeTestCase {
	var $Taskdetail = null;
	var $fixtures = array('app.taskdetail');

	function startTest() {
		$this->Taskdetail =& ClassRegistry::init('Taskdetail');
	}

	function testTaskdetailInstance() {
		$this->assertTrue(is_a($this->Taskdetail, 'Taskdetail'));
	}

	function testTaskdetailFind() {
		$this->Taskdetail->recursive = -1;
		$results = $this->Taskdetail->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Taskdetail' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor ',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'tasktype_id'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>