<?php 
/* SVN FILE: $Id$ */
/* Implementor Fixture generated on: 2009-11-19 15:42:01 : 1258616521*/

class ImplementorFixture extends CakeTestFixture {
	var $name = 'Implementor';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'task_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'task_id'  => 1,
		'user_id'  => 1
	));
}
?>