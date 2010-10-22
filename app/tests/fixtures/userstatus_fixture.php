<?php 
/* SVN FILE: $Id$ */
/* Userstatus Fixture generated on: 2009-11-19 15:42:38 : 1258616558*/

class UserstatusFixture extends CakeTestFixture {
	var $name = 'Userstatus';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'task_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'updater' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'status' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'percent' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'description' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'status_date' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'closed' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'date_closed' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'deleted' => array('type'=>'boolean', 'null' => false, 'default' => '0'),
		'deleted_date' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
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
}
?>