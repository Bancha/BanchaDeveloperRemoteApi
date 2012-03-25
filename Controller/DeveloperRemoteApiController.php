<?php
/**
 * Bancha Developer Remote API : JS Developer Tool for (Bancha](http://banchaproject.com)
 * Copyright 2011-2012 Roland Schuetz
 *
 * Licensed under The GNU General Public License Version 3
 * Redistributions of files must retain the above copyright notice.
 *
 * @package       BanchaDeveloperRemoteApi
 * @subpackage    Controller
 * @copyright     Copyright 2011-2012 Roland Schuetz
 * @link          http://banchaproject.com Bancha Project
 * @since         BanchaDeveloperRemoteApi v 0.0.1
 * @license       GNU General Public License Version 3
 * @author        Roland Schuetz <roland@banchaproject.com>
 */

// load up requirements
App::import('Controller', 'BanchaDeveloperRemoteApi.BanchaDeveloperRemoteApiApp');
App::uses('BanchaApi', 'Bancha.Bancha');
App::uses('BanchaApiDescriptor', 'BanchaDeveloperRemoteApi.BanchaDeveloperRemoteApi') // lib file, extends BanchaApi

/**
 * RemoteApiDescriptor Controller
 * This class exports Controller description for a requested file.
 *
 * @package    BanchaDeveloperRemoteApi
 * @subpackage Controller
 * @author     Roland Schuetz <roland@banchaproject.com>
 */
class RemoteApiDescriptorController extends BanchaDeveloperRemoteApiAppController {

	public $name = 'DeveloperRemoteApi';
	public $autoRender = false; //we don't need a view for this
	public $autoLayout = false;
	
    /**
     * return controller description for BanchaDeveloperRemoteApi frotnend
     */
	public function index($controllerName) {
        exit("yes:".$controllerName);
        
        /*
         // get phpDocumentator Reflection Helper
         require_once('phpDocumentator2/src/phpDocumentor/Reflection/DocBlock.php');
         
         
         
         class BanchaApiDescriptor extends BanchaApi {
         
         
         
         private function parsePhpDocs($classOrMethod) {
         return new phpDocumentor_Reflection_DocBlock($classOrMethod->getDocComment());
         }
         */
	}

}
