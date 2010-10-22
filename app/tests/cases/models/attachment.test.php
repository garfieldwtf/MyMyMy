<?php 
/* SVN FILE: $Id$ */
/* Attachment Test cases generated on: 2009-11-19 15:41:39 : 1258616499*/
App::import('Model', 'Attachment');

class AttachmentTestCase extends CakeTestCase {
	var $Attachment = null;
	var $fixtures = array('app.attachment');

	function startTest() {
		$this->Attachment =& ClassRegistry::init('Attachment');
	}

	function testAttachmentInstance() {
		$this->assertTrue(is_a($this->Attachment, 'Attachment'));
	}

	function testAttachmentFind() {
		$this->Attachment->recursive = -1;
		$results = $this->Attachment->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Attachment' => array(
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
		$this->assertEqual($results, $expected);
	}
}
?>