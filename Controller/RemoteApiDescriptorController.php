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

// load app controller
App::import('Controller', 'BanchaDeveloperRemoteApi.BanchaDeveloperRemoteApiApp');

// load BanchaApiDescriptor
App::uses('BanchaApi', 'Bancha.Bancha'); //extends BanchaAPi

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

App::uses('DocCommentHelper', 'BanchaDeveloperRemoteApi.BanchaDeveloperRemoteApi');
App::uses('BanchaApiDescriptor', 'BanchaDeveloperRemoteApi.BanchaDeveloperRemoteApi');

// load syntax highlighter
require_once($vendor_path.'hyperlight'.DS.'hyperlight.php');



/**
 * RemoteApiDescriptor Controller
 * This class exports Controller description for a requested file.
 *
 * @package    BanchaDeveloperRemoteApi
 * @subpackage Controller
 * @author     Roland Schuetz <roland@banchaproject.com>
 */
class RemoteApiDescriptorController extends BanchaDeveloperRemoteApiAppController {
	public $name = 'RemoteApiDescriptor';
	
	public function beforeFilter() {
    	parent::beforeFilter();

		// allow the usage in debug mode, when there's an AuthComponent
		if(Configure::read('debug')==2 && isset($this->Auth)) {
			$this->Auth->allow('index','loadMetaData');
		}
	}
	
    /**
     * Describes an Controller in jsonp format.
	 * The method is only reachable in debug mode, for security reasons.
	 * 
     * Mapped as /bancha-controller-description/stubsName.js
     * @returns jsduck controller metadata
     */
	public function index($stubsName) {
        if(Configure::read('debug')!=2) {
            throw new NotFoundException('This is unavailable in production mode.');
        }
		
		$this->autoRender = false; //we don't need a view for this
		$this->autoLayout = false;
		
		// delegate to Bancha Api Descriptor
        $banchaApiDescriptor = new BanchaApiDescriptor();
		$description = $banchaApiDescriptor->getRemoteApiClassDescription($stubsName);

        // no extra view file needed, simply output in  JsonP format
		$this->response->body(sprintf("Ext.data.JsonP.%s(%s)", $stubsName, json_encode($description)));
	}

	/**
	 * Displays a file, syntax highlighted 
	 * The method is only reachable in debug mode, for security reasons.
	 * 
     * Mapped as /bancha-file-viewer/stubsName.js
	 */
	public function displayFile($stubsName) {
        if(Configure::read('debug')!=2) {
            throw new NotFoundException('This is unavailable in production mode.');
        }
		
		// get the controller name without loading it
		$controllerClass = Inflector::pluralize($stubsName) . 'Controller';

		// check if file exists
		$path = APP . DS . 'Controller' . DS . $controllerClass . '.php';
		if(!file_exists($path)) {
			throw new MissingControllerException(array('class' => $controllerClass));
		}
		
		// set variables for output
		$this->set('title',$controllerClass);
		$this->set('path',$path);
		
		// we dont need an layout, view already rovides full html
		$this->autoLayout = false;
	}
}
