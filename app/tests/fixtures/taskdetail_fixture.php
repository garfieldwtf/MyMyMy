<?php 
/* SVN FILE: $Id$ */
/* Taskdetail Fixture generated on: 2009-11-19 15:42:21 : 1258616541*/

class TaskdetailFixture extends CakeTestFixture {
	var $name = 'Taskdetail';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'description' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'tasktype_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 4),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor ',
		'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'tasktype_id'  => 1
	));
}
?>