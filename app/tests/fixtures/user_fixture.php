<?php 
/* SVN FILE: $Id$ */
/* User Fixture generated on: 2009-11-19 15:42:36 : 1258616556*/

class UserFixture extends CakeTestFixture {
	var $name = 'User';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'username' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'password' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 200),
		'superuser' => array('type'=>'boolean', 'null' => false, 'default' => '0'),
		'protocol_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'job_title' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 80),
		'email' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 150),
		'telephone' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'mobile' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'fax' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'address' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'title_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'deleted' => array('type'=>'boolean', 'null' => false, 'default' => '0'),
		'deleted_date' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'bahagian' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'username'  => 'Lorem ipsum dolor ',
		'password'  => 'Lorem ipsum dolor sit amet',
		'superuser'  => 1,
		'protocol_id'  => 1,
		'job_title'  => 'Lorem ipsum dolor sit amet',
		'name'  => 'Lorem ipsum dolor sit amet',
		'email'  => 'Lorem ipsum dolor sit amet',
		'telephone'  => 'Lorem ipsum dolor sit amet',
		'mobile'  => 'Lorem ipsum dolor sit amet',
		'fax'  => 'Lorem ipsum dolor sit amet',
		'address'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'title_id'  => 1,
		'deleted'  => 1,
		'deleted_date'  => '2009-11-19 15:42:36',
		'bahagian'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-11-19 15:42:36',
		'updated'  => '2009-11-19 15:42:36'
	));
}
?>