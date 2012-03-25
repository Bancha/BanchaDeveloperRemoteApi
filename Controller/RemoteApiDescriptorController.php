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

// load app controller
App::import('Controller', 'BanchaDeveloperRemoteApi.BanchaDeveloperRemoteApiApp');

// load BanchaApiDescriptor
App::uses('BanchaApi', 'Bancha.Bancha'); //extends BanchaAPi

// uses DocCommentHelper, a decorator for phpDocumentor2
$base_path = App::pluginPath('BanchaDeveloperRemoteApi').'Vendor'.DS.'phpDocumentor2'.DS.'src'.DS.'phpDocumentor'.DS.'Reflection'.DS;
// App::import('Vendor', 'DocBlock', array('file' => $base_path.'DocBlock.php'));
require_once($base_path.'DocBlock.php');
require_once($base_path.'DocBlock/LongDescription.php');
require_once($base_path.'DocBlock/Tag.php');
require_once($base_path.'DocBlock/Tag/Link.php');
require_once($base_path.'DocBlock/Tag/Param.php');
require_once($base_path.'DocBlock/Tag/Method.php');
require_once($base_path.'DocBlock/Tag/Property.php');
require_once($base_path.'DocBlock/Tag/PropertyRead.php');
require_once($base_path.'DocBlock/Tag/PropertyWrite.php');
require_once($base_path.'DocBlock/Tag/Return.php');
require_once($base_path.'DocBlock/Tag/See.php');
require_once($base_path.'DocBlock/Tag/Throws.php');
require_once($base_path.'DocBlock/Tag/Throw.php');
require_once($base_path.'DocBlock/Tag/Uses.php');
require_once($base_path.'DocBlock/Tag/Var.php');

App::uses('DocCommentHelper', 'BanchaDeveloperRemoteApi.BanchaDeveloperRemoteApi');
App::uses('BanchaApiDescriptor', 'BanchaDeveloperRemoteApi.BanchaDeveloperRemoteApi');



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
		
		// load the Bancha Api Descriptor
        $banchaApiDescriptor = new BanchaApiDescriptor();
        try {
		$description = $banchaApiDescriptor->getRemoteApiClassDescription($stubsName);
		
		} catch(Exception $e) {
			exit($e->getMessage());
		}
        /*

         
         array(
         "return" => array(
         "type" => "Boolean",
         "doc" => "<p>Returns true is model was created successfully</p>\n"
         ),
         "params" => array(
         array(
         "type" => "String",
         "doc" => "<p>The name of the model</p>\n",
         "optional" => false,
         "name" => "modelName"
         ),array(
         "type" => "Object",
         "doc" => "<p>A standard Ext.data.Model config object</p>\n\n<pre><code> In ExtJS this will be directly applied.\n In Sencha Touch this iwll be applied to the config property.\n</code></pre>\n",
         "optional" => false,
         "name" => "modelConfig"
         )
         ),
         "doc" => "<p>This method creates a <a href=\"#/api/Bancha.data.Model\" rel=\"Bancha.data.Model\" class=\"docClass\">Bancha.data.Model</a> with your additional model configs,\nif you don't have any additional configs just use the convienience method <a href=\"#/api/Bancha-method-getModel\" rel=\"Bancha-method-getModel\" class=\"docClass\">getModel</a>.</p>\n\n<p>In the debug version it will raise an Ext.Error if the model can't be\nor is already created, in production it will only return false.</p>\n",
         "tagname" => "method",
         "shortDoc" => "This method creates a Bancha.data.Model with your additional model configs,\nif you don't have any additional configs ...",
         "name" => 'create',
         "filename" => "C:\\Users\\Roland\\Win-Mac Sharing\\Bancha Release\\app/Plugin/Bancha/webroot/js/Bancha.js",
         "linenr" => 779,
         ),


		$reflection = new ReflectionClass($controllerName);
        

        $remotableMethods = $banchaApi->getRemotableMethods();
        
		$controllers = App::objects('Controller');
		foreach ($controllers as $controllerClass) {
			$this->loadController($controllerClass);
			$modelClass = Inflector::singularize(str_replace('Controller', '', $controllerClass));
            
			$methods = $this->getClassMethods($controllerClass);
			foreach ($methods as $method) {
				if (preg_match('/@banchaRemotable/', $method->getDocComment())) {
					$remotableMethods[$modelClass][] = array(
                                                             'name'	=> $method->name,
                                                             'len'	=> $method->getNumberOfParameters(),
                                                             );
				}		 
			} // foreach methods
		} // foreach controllers
        */

        // submit
        // -> see add and edit
        
        
        // reflect data
        $api = array(
            'name'  => $controllerName,
            'crud' => array(
                array(
                    "return" => array(
                        "type" => "Boolean",
                        "doc" => "<p>Returns true is model was created successfully</p>\n"
                    ),
                    "params" => array(
                        array(
                            "type" => "String",
                            "doc" => "<p>The name of the model</p>\n",
                            "optional" => false,
                            "name" => "modelName"
                        ),array(
                            "type" => "Object",
                            "doc" => "<p>A standard Ext.data.Model config object</p>\n\n<pre><code> In ExtJS this will be directly applied.\n In Sencha Touch this iwll be applied to the config property.\n</code></pre>\n",
                            "optional" => false,
                            "name" => "modelConfig"
                        )
                    ),
                    "doc" => "<p>This method creates a <a href=\"#/api/Bancha.data.Model\" rel=\"Bancha.data.Model\" class=\"docClass\">Bancha.data.Model</a> with your additional model configs,\nif you don't have any additional configs just use the convienience method <a href=\"#/api/Bancha-method-getModel\" rel=\"Bancha-method-getModel\" class=\"docClass\">getModel</a>.</p>\n\n<p>In the debug version it will raise an Ext.Error if the model can't be\nor is already created, in production it will only return false.</p>\n",
                    "tagname" => "method",
                    "shortDoc" => "This method creates a Bancha.data.Model with your additional model configs,\nif you don't have any additional configs ...",
                    "name" => 'create',
                    "filename" => "C:\\Users\\Roland\\Win-Mac Sharing\\Bancha Release\\app/Plugin/Bancha/webroot/js/Bancha.js",
                    "linenr" => 779,
                ),
            ),
            'remotable' => array(
                array(
                    "return" => array(
                        "type" => "Boolean",
                        "doc" => "<p>Returns true is model was created successfully</p>\n"
                    ),
                    "params" => array(
                        array(
                            "type" => "String",
                            "doc" => "<p>The name of the model</p>\n",
                            "optional" => false,
                            "name" => "modelName"
                        ),array(
                            "type" => "Object",
                            "doc" => "<p>A standard Ext.data.Model config object</p>\n\n<pre><code> In ExtJS this will be directly applied.\n In Sencha Touch this iwll be applied to the config property.\n</code></pre>\n",
                            "optional" => false,
                            "name" => "modelConfig"
                        )
                    ),
                    "deprecated" => null,
                    "doc" => "<p>This method creates a <a href=\"#/api/Bancha.data.Model\" rel=\"Bancha.data.Model\" class=\"docClass\">Bancha.data.Model</a> with your additional model configs,\nif you don't have any additional configs just use the convienience method <a href=\"#/api/Bancha-method-getModel\" rel=\"Bancha-method-getModel\" class=\"docClass\">getModel</a>.</p>\n\n<p>In the debug version it will raise an Ext.Error if the model can't be\nor is already created, in production it will only return false.</p>\n",
                    "html_filename" => "Bancha.html",
                    "owner" => "Bancha",
                    "tagname" => "method",
                    "alias" => null,
                    "static" => false,
                    "protected" => false,
                    "inheritable" => false,
                    "private" => false,
                    "shortDoc" => "This method creates a Bancha.data.Model wityour additional model configs,\nif you don't have any additional configs ...",
                    "name" => 'someRemotable',
                    "filename" => "C:\\Users\\Roland\\Win-Mac Sharing\\Bancha Release\\app/Plugin/Bancha/webroot/js/Bancha.js",
                    "linenr" => 779,
                    "href" => "Bancha.html#Bancha-method-createModel"
                ),
            ),
                     
            "filename" => "C:\\Users\\Roland\\Win-Mac Sharing\\Bancha Release\\app/Plugin/Bancha/webroot/js/Bancha.js",
            "linenr" => 18,
            "author" => "Roland Schuetz <mail@rolandschuetz.at>",
        );
        
        // no extra view file needed, simply output in  JsonP format
		$this->response->body(sprintf("Ext.data.JsonP.%s(%s)", $controllerName, json_encode($api)));
        return;
	}

}
