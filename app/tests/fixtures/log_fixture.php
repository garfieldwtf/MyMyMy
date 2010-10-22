<?php 
/* SVN FILE: $Id$ */
/* Log Fixture generated on: 2009-11-19 15:42:03 : 1258616523*/

class LogFixture extends CakeTestFixture {
	var $name = 'Log';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'controller' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'action' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'url' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'timestamp' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'message' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'user_id'  => 1,
		'controller'  => 'Lorem ipsum dolor sit amet',
		'action'  => 'Lorem ipsum dolor sit amet',
		'url'  => 'Lorem ipsum dolor sit amet',
		'timestamp'  => '2009-11-19 15:42:03',
		'message'  => 'Lorem ipsum dolor sit amet'
	));
}
?>