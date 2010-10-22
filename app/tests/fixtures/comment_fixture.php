<?php 
/* SVN FILE: $Id$ */
/* Comment Fixture generated on: 2009-11-19 15:41:47 : 1258616507*/

class CommentFixture extends CakeTestFixture {
	var $name = 'Comment';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'model' => array('type'=>'string', 'null' => true, 'default' => NULL, 'length' => 20),
		'foreign_key' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'description' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'model'  => 'Lorem ipsum dolor ',
		'foreign_key'  => 1,
		'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'user_id'  => 1,
		'created'  => '2009-11-19 15:41:47',
		'updated'  => '2009-11-19 15:41:47'
	));
}
?>