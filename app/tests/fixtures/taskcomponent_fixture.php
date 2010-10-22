<?php 
/* SVN FILE: $Id$ */
/* Taskcomponent Fixture generated on: 2009-11-19 15:42:19 : 1258616539*/

class TaskcomponentFixture extends CakeTestFixture {
	var $name = 'Taskcomponent';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'task_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'taskdetail_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'task_id'  => 1,
		'taskdetail_id'  => 1
	));
}
?>