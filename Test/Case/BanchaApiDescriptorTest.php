<?php
/**
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

// load dependencies

// uses DocCommentHelper, a decorator for phpDocumentor2
$vendor_path = App::pluginPath('BanchaDeveloperRemoteApi').'Vendor'.DS;
$base_path = $vendor_path.'phpDocumentor2'.DS.'src'.DS.'phpDocumentor'.DS.'Reflection'.DS;

// App::import('Vendor', 'DocBlock', array('file' => $base_path.'DocBlock.php'));
require_once($base_path.'DocBlock.php');
require_once($base_path.'DocBlock'.DS.'LongDescription.php');
require_once($base_path.'DocBlock'.DS.'Tag.php');
require_once($base_path.'DocBlock'.DS.'Tag'.DS.'Link.php');
require_once($base_path.'DocBlock'.DS.'Tag'.DS.'Param.php');
require_once($base_path.'DocBlock'.DS.'Tag'.DS.'Method.php');
require_once($base_path.'DocBlock'.DS.'Tag'.DS.'Property.php');
require_once($base_path.'DocBlock'.DS.'Tag'.DS.'PropertyRead.php');
require_once($base_path.'DocBlock'.DS.'Tag'.DS.'PropertyWrite.php');
require_once($base_path.'DocBlock'.DS.'Tag'.DS.'Return.php');
require_once($base_path.'DocBlock'.DS.'Tag'.DS.'See.php');
require_once($base_path.'DocBlock'.DS.'Tag'.DS.'Throws.php');
require_once($base_path.'DocBlock'.DS.'Tag'.DS.'Throw.php');
require_once($base_path.'DocBlock'.DS.'Tag'.DS.'Uses.php');
require_once($base_path.'DocBlock'.DS.'Tag'.DS.'Var.php');
    
// add markdown support
require_once($vendor_path.'phpDocumentor2'.DS.'src'.DS.'markdown.php');

// load BanchaApiDescriptor
App::uses('BanchaApi', 'Bancha.Bancha'); //extends BanchaAPi
App::uses('DocCommentHelper', 'BanchaDeveloperRemoteApi.BanchaDeveloperRemoteApi');
App::uses('BanchaApiDescriptor', 'BanchaDeveloperRemoteApi.BanchaDeveloperRemoteApi');
    
require_once('test_controller.php');

/**
 * Once overrides the load method for clean testing
 */
class BanchaApiDescriptorTestClass extends BanchaApiDescriptor {
	protected function loadController($controllerClass) {	
        // don't load class from file, expect it to be laoded
        if (!class_exists($controllerClass)) {
			throw new MissingControllerExceptionarray(array('class' => $controllerClass));
		}
	}
}

/**
 * BanchaApiDescriptiorTest
 *
 * @package       Bancha
 * @category      tests
 */
class BanchaApiDescriptorTest extends CakeTestCase {
	private $result;
	
	public function setup() {
        
		// since only one function is public we get the full result
		// and then evaluate separate
		$api = new BanchaApiDescriptorTestClass();
		$this->result = $api->getRemoteApiClassDescription('User');
		
    }

	public function testGetRemoteApiClassDescription() {
		// since this function only wraps up the once below, just make very basic tests
		$this->assertEquals('User', $this->result['name']);
		$this->assertCount(6, $this->result['crud']);
		$this->assertCount(1, $this->result['remotable']);
	}

	public function testGetClassDescription() {
		$this->markTestSkipped('Test not yet written');
	}

	public function testGetRemoteApiCrudDescription() {
		$crudDescriptions = $this->result['crud'];
		
		// check crud method names
		$this->assertEquals('getAll', $crudDescriptions[0]['name']);
		$this->assertEquals('read', $crudDescriptions[1]['name']);
		$this->assertEquals('create', $crudDescriptions[2]['name']);
		$this->assertEquals('update', $crudDescriptions[3]['name']);
		$this->assertEquals('destroy', $crudDescriptions[4]['name']);
		$this->assertEquals('submit', $crudDescriptions[5]['name']);
		// mapping
		$this->assertEquals('UsersController::index', $crudDescriptions[0]['mappedFrom']);
		$this->assertEquals('UsersController::view', $crudDescriptions[1]['mappedFrom']);
		$this->assertEquals('UsersController::add', $crudDescriptions[2]['mappedFrom']);
		$this->assertEquals('UsersController::edit', $crudDescriptions[3]['mappedFrom']);
		$this->assertEquals('UsersController::delete', $crudDescriptions[4]['mappedFrom']);
		$this->assertEquals('UsersController::add/edit', $crudDescriptions[5]['mappedFrom']);
		
		// docs
		$this->assertRegExp('/Simply displays all Users in a paginated way, .*/', $crudDescriptions[0]['doc']);
		$this->assertRegExp('/Simply displays all Users in a paginated way, .*\.\.\./', $crudDescriptions[0]['shortDoc']);
		$this->assertEquals('view method', $crudDescriptions[1]['doc']);
		// submit doc is a special case
		$this->assertRegExp('/This function can be used in forms to submit data and files.*/', $crudDescriptions[5]['doc']);
		
		// that's always the same
		$this->assertEquals('method', $crudDescriptions[0]['tagname']); //static
		
		// check formhandler
		$this->assertEquals(false, $crudDescriptions[0]['formHandler']);
		$this->assertEquals(true,  $crudDescriptions[5]['formHandler']);
	}

	public function testGetRemoteApiRemoteControllerMethodsDescription() {
		$this->markTestSkipped('Test not yet written');
	}
	
	public function testGetRemoteApiMethodDescription() {
		//$this->markTestSkipped('Test not yet written');
		
		//getAll has no params
		$params = $this->result['crud'][0]['params'];
		$this->assertEquals(0, count($params));
				
		//delete has one param and no docs
		$params = $this->result['crud'][4]['params'];
		$this->assertEquals(1, count($params));
		$this->assertEquals('id', $params[0]['name']);
		$this->assertEquals(false, $params[0]['optional']);
		$this->assertEquals('NotProvided', $params[0]['type']);
		$this->assertEquals('', $params[0]['doc']);
		
		// anyFunction has one param
		$params = $this->result['remotable'][0]['params'];
		$this->assertEquals(1, count($params));
		$this->assertEquals('anyParam', $params[0]['name']);
		$this->assertEquals(true, $params[0]['optional']);
		$this->assertEquals('string', $params[0]['type']);
		$this->assertEquals('This is the special any param.', $params[0]['doc']);

		
		// check return descriptions for index
		$return = $this->result['crud'][0]['return'];
		$this->assertEquals('Array', $return['type']);
		$this->assertEquals('Pagination data and users', $return['doc']);
		// delete - no phpdocs provided
		$return = $this->result['crud'][4]['return'];
		$this->assertEquals('NotProvided', $return['type']); 
		$this->assertEquals('', $return['doc']);
	}
}






