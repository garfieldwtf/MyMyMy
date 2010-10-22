<?php 
/* SVN FILE: $Id$ */
/* Task Test cases generated on: 2009-11-19 15:42:30 : 1258616550*/
App::import('Model', 'Task');

class TaskTestCase extends CakeTestCase {
	var $Task = null;
	var $fixtures = array('app.task');

	function startTest() {
		$this->Task =& ClassRegistry::init('Task');
	}

	function testTaskInstance() {
		$this->assertTrue(is_a($this->Task, 'Task'));
	}

	function testTaskFind() {
		$this->Task->recursive = -1;
		$results = $this->Task->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Task' => array(
			'id'  => 1,
			'ref_no'  => 1,
			'priority'  => 1,
			'task_name'  => 'Lorem ipsum dolor sit amet',
			'task_desc'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'start_date'  => '2009-11-19 15:42:30',
			'end_date'  => '2009-11-19 15:42:30',
			'deleted'  => 1,
			'created'  => '2009-11-19',
			'updated'  => '2009-11-19'
		));
		$this->assertEqual($results, $expected);
	}
}
?>