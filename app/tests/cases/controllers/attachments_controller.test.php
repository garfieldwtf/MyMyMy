<?php 
/* SVN FILE: $Id$ */
/* AttachmentsController Test cases generated on: 2009-11-19 15:41:39 : 1258616499*/
App::import('Controller', 'Attachments');

class TestAttachments extends AttachmentsController {
	var $autoRender = false;
}

class AttachmentsControllerTest extends CakeTestCase {
	var $Attachments = null;

	function startTest() {
		$this->Attachments = new TestAttachments();
		$this->Attachments->constructClasses();
	}

	function testAttachmentsControllerInstance() {
		$this->assertTrue(is_a($this->Attachments, 'AttachmentsController'));
	}

	function endTest() {
		unset($this->Attachments);
	}
}
?>