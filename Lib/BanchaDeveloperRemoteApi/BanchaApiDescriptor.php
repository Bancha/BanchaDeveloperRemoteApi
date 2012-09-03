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
		$reflectionClass = new ReflectionClass($controllerClass);
		
		$description = array(
			'name'		=> $stubsName,
			'crud'		=> $this->getRemoteApiCrudDescription($controllerClass),
			'remotable'	=> $this->getRemoteApiRemoteControllerMethodsDescription($reflectionClass),
		);
		
		// add the class description
		$description = array_merge($description, $this->getClassDescription($reflectionClass));
		
		return $description;
	}

	/**
	 * Loads all class descriptions
	 * @param ReflectionClass $reflectionClass controller class
	 */
	protected function getClassDescription($reflectionClass) {
		$docComment = new DocCommentHelper($reflectionClass->getDocComment());
		
		return array(
			'shortDoc'		=> $docComment->getShortDoc(),
			'doc'			=> $docComment->getLongDoc(),
			
			"filename" => $reflectionClass->getFileName(),
			"author" => $docComment->getFormatedAuthor(),
		);
	}
	
	/**
	 * Loads all crud method phpdoc information about a specific controller
	 * 
	 * @param string $controllerClass The class name of the controller to reflect on
	 * @return crud method descriptions in a jsduck-similar way
	 */
	protected function getRemoteApiCrudDescription($controllerClass) {
		$methods = $this->getClassMethods($controllerClass);

		$addFormHandler = false;
		$crudDescription_editIndex = 0;
		$crudDescriptions = array();
		foreach ($methods as $method) {
			if ('add' === $method->name || 'edit' == $method->name) {
				$addFormHandler = true;
				if('edit' == $method->name) {
					$crudDescription_editIndex = count($crudDescriptions)+1;
				}
			}
			
			if(!isset($this->crudMapping[$method->name])) {
				continue; // no crud method
			}
			
			// parse data and add description
			$crudDescription = $this->getRemoteApiMethodDescription($controllerClass,$method,$this->crudMapping[$method->name]['name']);
            
            // adopt to mapping for stores
            if('view' === $method->name) {
                $crudDescription['params'][0]['name'] = 'extFilterData';
                $crudDescription['params'][0]['type'] = 'Array';
            }
            if('edit' === $method->name) {
                $crudDescription['params'][0]['name'] = 'recordData';
                $crudDescription['params'][0]['type'] = 'Array';
                $crudDescription['params'][0]['optional'] = false;
            }
            if('delete' === $method->name) {
                $crudDescription['params'][0]['optional'] = false;
            }
            
            // add
            $crudDescriptions[] = $crudDescription;
		}

		// If this controller supports a form handler submit, add it to the crud actions.
		if ($addFormHandler) {
			$submit = array_merge($crudDescriptions[$crudDescription_editIndex],array( // take edit as template
				'name'			=> 'submit',
				'mappedFrom' 	=> $controllerClass.'::add/edit',
				'formHandler'	=> true,
				'shortDoc'		=> 'This function can be used in forms to submit data and files.',
				'doc'			=> 'This function can be used in forms to submit data and files.'.
								   '<p>If an id is provided it will be applied to add from above, '.
								   'otherwise to edit. Please see this for more information</p>',
				'params'		=> array(),
				'return'		=> array( 'type' => 'NotProvided', 'doc' => 'See add or edit.'),
				'linenr'		=> 0
			));
			
			$crudDescriptions[] = $submit;
		}
		
		return $crudDescriptions;
	}

	/**
	 * Loads all with @banchaRemotable marked methods and their phpdoc information from a specific controller
	 * 
	 * @param ReflectionClass $reflectionClass controller class
	 * @return crud method descriptions in a jsduck-similar way
	 */
	protected function getRemoteApiRemoteControllerMethodsDescription($reflectionClass) {
		$remotableDescriptions = array();
		
		foreach ($reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
			if (preg_match('/@banchaRemotable/', $method->getDocComment())) {
				
				$remotableDescriptions[] = $this->getRemoteApiMethodDescription($reflectionClass->name,$method,$method->name);
			}
		}
		
		return $remotableDescriptions;
	}
	
	
	
	
	/**
	 * Builds the method description array for $method
	 * 
	 * @param String		   $controllerClass the name of the controller class
	 * @param ReflectionMethod $method the method to reflect on
	 * @param String		   $mappedTo the client side name
	 */
	protected function getRemoteApiMethodDescription($controllerClass,$method,$mappedTo) {
			
		$docComment = new DocCommentHelper($method->getDocComment());
		
		return array(
			'name'			=> $mappedTo,
			'mappedFrom'	=> ($method->name!=$mappedTo) ? $controllerClass.'::'.$method->name : '', // only display this if it differs
			'tagname'		=> 'method',
			'formHandler'	=> false,
			
			'shortDoc'		=> $docComment->getShortDoc(),
			'doc'			=> $docComment->getLongDoc(),
			
			'return'		=> $docComment->getReturn(),
			'params'		=> $docComment->getParams($method),
			
			'filename'		=> $method->getFileName(),
			'linenr'		=> $method->getStartLine(),
		);
	}
}

