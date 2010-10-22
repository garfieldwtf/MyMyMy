<?php 
/* SVN FILE: $Id$ */
/* Hash Fixture generated on: 2009-11-19 15:41:58 : 1258616518*/

class HashFixture extends CakeTestFixture {
	var $name = 'Hash';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'model' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'foreign_key' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'url' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'hash_type' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 30),
		'hash' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'limit' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'due_date' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'limit_count' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'deleted' => array('type'=>'boolean', 'null' => false, 'default' => '0'),
		'deleted_date' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'model'  => 'Lorem ipsum dolor sit amet',
		'foreign_key'  => 1,
		'url'  => 'Lorem ipsum dolor sit amet',
		'hash_type'  => 'Lorem ipsum dolor sit amet',
		'hash'  => 'Lorem ipsum dolor sit amet',
		'limit'  => 1,
		'due_date'  => '2009-11-19 15:41:58',
		'limit_count'  => 1,
		'created'  => '2009-11-19 15:41:58',
		'updated'  => '2009-11-19 15:41:58',
		'deleted'  => 1,
		'deleted_date'  => '2009-11-19 15:41:58'
	));
}
?>