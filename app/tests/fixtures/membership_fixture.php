<?php 
/* SVN FILE: $Id$ */
/* Membership Fixture generated on: 2009-11-19 15:42:05 : 1258616525*/

class MembershipFixture extends CakeTestFixture {
	var $name = 'Membership';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'group_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'role_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'user_id'  => 1,
		'group_id'  => 1,
		'role_id'  => 1
	));
}
?>