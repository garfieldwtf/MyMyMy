<?php 
/* SVN FILE: $Id$ */
/* Permission Fixture generated on: 2009-11-19 15:42:08 : 1258616528*/

class PermissionFixture extends CakeTestFixture {
	var $name = 'Permission';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'role_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'group_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'model' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'level' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'view' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'edit' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'delete' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'approve' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'disapprove' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'role_id'  => 1,
		'group_id'  => 1,
		'model'  => 'Lorem ipsum dolor sit amet',
		'level'  => 1,
		'view'  => 'Lorem ipsum dolor sit amet',
		'edit'  => 'Lorem ipsum dolor sit amet',
		'delete'  => 'Lorem ipsum dolor sit amet',
		'approve'  => 'Lorem ipsum dolor sit amet',
		'disapprove'  => 'Lorem ipsum dolor sit amet'
	));
}
?>