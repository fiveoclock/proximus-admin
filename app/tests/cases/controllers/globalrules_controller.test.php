<?php 
/* SVN FILE: $Id$ */
/* GlobalrulesController Test cases generated on: 2009-04-03 10:04:03 : 1238747103*/
App::import('Controller', 'Globalrules');

class TestGlobalrules extends GlobalrulesController {
	var $autoRender = false;
}

class GlobalrulesControllerTest extends CakeTestCase {
	var $Globalrules = null;

	function setUp() {
		$this->Globalrules = new TestGlobalrules();
		$this->Globalrules->constructClasses();
	}

	function testGlobalrulesControllerInstance() {
		$this->assertTrue(is_a($this->Globalrules, 'GlobalrulesController'));
	}

	function tearDown() {
		unset($this->Globalrules);
	}
}
?>