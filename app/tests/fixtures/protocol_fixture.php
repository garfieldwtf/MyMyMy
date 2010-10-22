<?php 
/* SVN FILE: $Id$ */
/* Protocol Fixture generated on: 2009-11-19 15:42:12 : 1258616532*/

class ProtocolFixture extends CakeTestFixture {
	var $name = 'Protocol';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'protocol_title' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 50),
		'rank' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'protocol_title'  => 'Lorem ipsum dolor sit amet',
		'rank'  => 'Lorem ipsum dolor sit amet'
	));
}
?>