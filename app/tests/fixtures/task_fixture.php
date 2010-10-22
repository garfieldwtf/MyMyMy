<?php 
/* SVN FILE: $Id$ */
/* Task Fixture generated on: 2009-11-19 15:42:30 : 1258616550*/

class TaskFixture extends CakeTestFixture {
	var $name = 'Task';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'ref_no' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'priority' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'task_name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 500),
		'task_desc' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'start_date' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'end_date' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'deleted' => array('type'=>'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'date', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
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
}
?>