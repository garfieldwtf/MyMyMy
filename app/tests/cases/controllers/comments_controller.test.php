<?php 
/* SVN FILE: $Id$ */
/* CommentsController Test cases generated on: 2009-11-19 15:41:47 : 1258616507*/
App::import('Controller', 'Comments');

class TestComments extends CommentsController {
	var $autoRender = false;
}

class CommentsControllerTest extends CakeTestCase {
	var $Comments = null;

	function startTest() {
		$this->Comments = new TestComments();
		$this->Comments->constructClasses();
	}

	function testCommentsControllerInstance() {
		$this->assertTrue(is_a($this->Comments, 'CommentsController'));
	}

	function endTest() {
		unset($this->Comments);
	}
}
?>