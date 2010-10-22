<?php 
/* SVN FILE: $Id$ */
/* Attachment Fixture generated on: 2009-11-19 15:41:39 : 1258616499*/

class AttachmentFixture extends CakeTestFixture {
	var $name = 'Attachment';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'model' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'foreign_key' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'file' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'filename' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'checksum' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'field' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'type' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'size' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'model'  => 'Lorem ipsum dolor ',
		'foreign_key'  => 1,
		'file'  => 'Lorem ipsum dolor sit amet',
		'filename'  => 'Lorem ipsum dolor sit amet',
		'checksum'  => 'Lorem ipsum dolor sit amet',
		'field'  => 'Lorem ipsum dolor sit amet',
		'type'  => 'Lorem ipsum dolor sit amet',
		'size'  => 1,
		'created'  => '2009-11-19 15:41:39',
		'modified'  => '2009-11-19 15:41:39'
	));
}
?>