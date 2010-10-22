<?php 
/* SVN FILE: $Id$ */
/* Title Test cases generated on: 2009-11-19 15:42:34 : 1258616554*/
App::import('Model', 'Title');

class TitleTestCase extends CakeTestCase {
	var $Title = null;
	var $fixtures = array('app.title');

	function startTest() {
		$this->Title =& ClassRegistry::init('Title');
	}

	function testTitleInstance() {
		$this->assertTrue(is_a($this->Title, 'Title'));
	}

	function testTitleFind() {
		$this->Title->recursive = -1;
		$results = $this->Title->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Title' => array(
			'id'  => 1,
			'short_name'  => 'Lorem ipsum dolor sit amet',
			'long_name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-11-19 15:42:34',
			'updated'  => '2009-11-19 15:42:34'
		));
		$this->assertEqual($results, $expected);
	}
}
?>