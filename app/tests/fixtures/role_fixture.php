<?php 
/* SVN FILE: $Id$ */
/* Role Fixture generated on: 2009-11-19 15:42:15 : 1258616535*/

class RoleFixture extends CakeTestFixture {
	var $name = 'Role';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'description' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'deleted' => array('type'=>'boolean', 'null' => true, 'default' => '0'),
		'deleted_date' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor ',
		'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'deleted'  => 1,
		'deleted_date'  => '2009-11-19 15:42:15'
	));
}
?>