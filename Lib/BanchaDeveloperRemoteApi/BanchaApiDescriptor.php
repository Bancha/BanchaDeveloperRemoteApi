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

/**
 * BanchaApiDescriptor
 * Does the actual for for BanchaApiDescriptorController
 * @author        Roland Schuetz <roland@banchaproject.com>
 */
class BanchaApiDescriptor extends BanchaApi {

	/**
	 * Load all class descriptions
	 * 
	 * @param The Bancha Remote API Stubs Name (controller name in singular)
	 */
	public function getRemoteApiClassDescription($stubsName) {
		$controllerClass = $this->getControllerClassByModelClass($stubsName);
		
		$description = array(
			'name'  => $stubsName,
			//'crud'  => $banchaApi->getRemoteApiCrudDescription($controllerClass),
		);
		
		// add the class description
		$description = array_merge($description, $this->getClassDescription($controllerClass));
		
		pr($description);
		exit();
		
		/*
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
		);
		*/

	}

	/**
	 * Loads all class descriptions
	 * @param string $controllerClass controller class name
	 */
	protected function getClassDescription($controllerClass) {
		$reflection = new ReflectionClass($controllerClass);
		$docComment = new DocCommentHelper($reflection->getDocComment());
		
		return array(
			"filename" => $reflection->getFileName(),
			"author" => $docComment->getFormatedAuthor(),
		);
	}
	
	/**
	 * Loads all crud method phpdoc information about a specific controller
	 * Used for https://github.com/Bancha/BanchaDeveloperRemoteApi
	 * 
	 * @param string $controllerClass The class name of the controller to reflect on
	 * @return crud method descriptions in a jsduck-similar way
	 */
	protected function getRemoteApiCrudDescription($controllerClass) {
		$methods = $this->getClassMethods($controllerClass);

		$addFormHandler = false;
		$crudDescriptions = array();
		foreach ($methods as $method) {
			if ('add' === $method->name || 'edit' == $method->name) {
				$addFormHandler = true;
			}
			
			if(!isset($this->crudMapping[$method->name])) {
				continue; // no crud method
			}
			
			// that's how it looks for the client
			$clientMethod = $this->crudMapping[$method->name];
			
			$crudDescriptions[] = array(
				'name'			=> $clientMethod['name'],
				'mappedfrom'	=> $controllerClass.'::'.$method->name,
				'tagname'		=> 'method',
				
				'doc'			=> $reflector->getLongDescription(),
				'shortDoc'		=> $reflector->getShortDescription(),
				
				'tags'			=> $reflector->getTags()
			);
			exit($crudDescriptions);
		}

		// If this controller supports a form handler submit, add it to the crud actions.
		if ($addFormHandler) {
			$crudDescriptions[] = array(
				'name'			=> 'submit',
				'len' 			=> 1,
				'formHandler'	=> true,
			);
		}

		// reflect php and add data
		$crudDescriptions[0] = array_merge($crudDescriptions[0], $this->processMethodPHPDoc($methods[0]));
		
		
		// ReflectioNMethod:
		// ReflectionFunctionAbstract::getFileName 
		// public int ReflectionFunctionAbstract::getStartLine 
		
		return $crudDescriptions;
		
	}
}

