<?php 
/* SVN FILE: $Id$ */
/* Hash Test cases generated on: 2009-11-19 15:41:58 : 1258616518*/
App::import('Model', 'Hash');

class HashTestCase extends CakeTestCase {
	var $Hash = null;
	var $fixtures = array('app.hash');

	function startTest() {
		$this->Hash =& ClassRegistry::init('Hash');
	}

	function testHashInstance() {
		$this->assertTrue(is_a($this->Hash, 'Hash'));
	}

	function testHashFind() {
		$this->Hash->recursive = -1;
		$results = $this->Hash->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Hash' => array(
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
		$this->assertEqual($results, $expected);
	}
}
?>