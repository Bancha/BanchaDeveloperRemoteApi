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
 * connect the remote api descriptor
 */
Router::parseExtensions('js');
Router::redirect('/developer-remote-api.html', 'BanchaDeveloperRemoteApi/developer-remote-api.html',array('status'=>302));
Router::connect('/bancha-controller-description/:controllerName', array('plugin' => 'BanchaDeveloperRemoteApi', 
				'controller' => 'RemoteApiDescriptor', 'action' => 'index'),array('pass'=>array('controllerName')));
Router::connect('/bancha-file-viewer/:controllerName', array('plugin' => 'BanchaDeveloperRemoteApi', 
				'controller' => 'RemoteApiDescriptor', 'action' => 'displayFile'),array('pass'=>array('controllerName')));