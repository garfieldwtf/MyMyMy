<?php 
/* SVN FILE: $Id$ */
/* Comment Test cases generated on: 2009-11-19 15:41:47 : 1258616507*/
App::import('Model', 'Comment');

class CommentTestCase extends CakeTestCase {
	var $Comment = null;
	var $fixtures = array('app.comment');

	function startTest() {
		$this->Comment =& ClassRegistry::init('Comment');
	}

	function testCommentInstance() {
		$this->assertTrue(is_a($this->Comment, 'Comment'));
	}

	function testCommentFind() {
		$this->Comment->recursive = -1;
		$results = $this->Comment->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Comment' => array(
			'id'  => 1,
			'model'  => 'Lorem ipsum dolor ',
			'foreign_key'  => 1,
			'description'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'user_id'  => 1,
			'created'  => '2009-11-19 15:41:47',
			'updated'  => '2009-11-19 15:41:47'
		));
		$this->assertEqual($results, $expected);
	}
}
?>