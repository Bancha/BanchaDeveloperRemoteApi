<?php
/**
 * AllTestsTest file.
 * 
 * Bancha Developer Remote API : JS Developer Tool for (Bancha](http://banchaproject.com)
 * Copyright 2011-2012 StudioQ OG
 *
 * Licensed under The GNU General Public License Version 3
 * Redistributions of files must retain the above copyright notice.
 *
 * @package       BanchaDeveloperRemoteApi
 * @subpackage    Controller
 * @copyright     Copyright 2011-2012 StudioQ OG
 * @link          http://banchaproject.com Bancha Project
 * @since         BanchaDeveloperRemoteApi v 0.0.1
 * @license       GNU General Public License Version 3
 * @author        Roland Schuetz <roland@banchaproject.com>
 */

/**
 * AllTestsTest class
 *
 * This test group will run all test in the BanchaDeveloperRemoteApi/Test/Cases directory except for those in the System directory.
 *
 * @package       BanchaDeveloperRemoteApi
 * @category      tests
 */
class AllTestsTest extends PHPUnit_Framework_TestSuite {

/**
 * Suite define the tests for this suite
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('All Tests');

		$path = dirname(__FILE__);
		$suite->addTestFile($path . DS . 'BanchaApiDescriptorTest.php');
		$suite->addTestFile($path . DS . 'DocCommentHelperTest.php');
		
		return $suite;
	}
}
