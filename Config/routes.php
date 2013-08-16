<?php
/**
 * Routes configuration
 *
 * This file configures BanchaDeveloperRemoteApi routing.
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
 * Enable support for the file extension js
 *
 * In CakePHP 2.2 and above Router:setExtensions could be used,
 * for legacy support we need the bug fix version below
 */
if(Router::extensions() !== true) { // if all extensions are supported we are done

	// add json and javascript to the extensions
	$extensions = Router::extensions();
	if(!is_array($extensions)) {
		$extensions = array('json','js');
	} else {
		array_push($extensions, 'json');
		array_push($extensions, 'js');
	}

	call_user_func_array('Router::parseExtensions', $extensions);
}

/**
 * connect the remote api descriptor
 */
Router::redirect('/developer-remote-api.html', 'BanchaDeveloperRemoteApi/developer-remote-api.html',array('status'=>302));
Router::connect('/bancha-controller-description/:controllerName', array('plugin' => 'BanchaDeveloperRemoteApi', 
				'controller' => 'RemoteApiDescriptor', 'action' => 'index'),array('pass'=>array('controllerName')));
Router::connect('/bancha-file-viewer/:controllerName', array('plugin' => 'BanchaDeveloperRemoteApi', 
				'controller' => 'RemoteApiDescriptor', 'action' => 'displayFile'),array('pass'=>array('controllerName')));