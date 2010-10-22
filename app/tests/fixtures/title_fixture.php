<?php 
/* SVN FILE: $Id$ */
/* Title Fixture generated on: 2009-11-19 15:42:34 : 1258616554*/

class TitleFixture extends CakeTestFixture {
	var $name = 'Title';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'short_name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'long_name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'short_name'  => 'Lorem ipsum dolor sit amet',
		'long_name'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-11-19 15:42:34',
		'updated'  => '2009-11-19 15:42:34'
	));
}
?>