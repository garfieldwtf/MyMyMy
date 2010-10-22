<?php 
/* SVN FILE: $Id$ */
/* Tasktype Test cases generated on: 2009-11-19 15:42:32 : 1258616552*/
App::import('Model', 'Tasktype');

class TasktypeTestCase extends CakeTestCase {
	var $Tasktype = null;
	var $fixtures = array('app.tasktype');

	function startTest() {
		$this->Tasktype =& ClassRegistry::init('Tasktype');
	}

	function testTasktypeInstance() {
		$this->assertTrue(is_a($this->Tasktype, 'Tasktype'));
	}

	function testTasktypeFind() {
		$this->Tasktype->recursive = -1;
		$results = $this->Tasktype->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Tasktype' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor ',
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		));
		$this->assertEqual($results, $expected);
	}
}
?>