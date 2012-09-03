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

App::uses('DocCommentHelper', 'BanchaDeveloperRemoteApi.BanchaDeveloperRemoteApi');


/**
 * DocCommentHelperTest
 *
 * @package       Bancha
 * @category      tests
 */
class DocCommentHelperTest extends CakeTestCase {
    
	public function testGetFormatedAuthor() {
        $docCommentHelper = new DocCommentHelper(
            '/** \n'.
            ' * test Author Format - none\n'.
            ' */\n');
        $this->assertEquals('',$docCommentHelper->getFormatedAuthor());
		
		
        $docCommentHelper = new DocCommentHelper(
            "/** 
             * test Author Format 1
             * @author \"Roland Schuetz\" <roland@banchaproject.com>
             */");
        $this->assertEquals('<a href="mailto:roland@banchaproject.com">Roland Schuetz</a>',
        		$docCommentHelper->getFormatedAuthor());
		
		
        $docCommentHelper = new DocCommentHelper(
            "/** 
             * test Author Format 1
             * @author Roland Schuetz <roland@banchaproject.com>
             */");
        $this->assertEquals('<a href="mailto:roland@banchaproject.com">Roland Schuetz</a>',
        		$docCommentHelper->getFormatedAuthor());
		
		
        $docCommentHelper = new DocCommentHelper(
            "/** 
             * test Author Format 1
             * @author Roland Schuetz
             */");
        $this->assertEquals('Roland Schuetz',
        		$docCommentHelper->getFormatedAuthor());
    }

	public function testGetShortDoc() {
        $docCommentHelper = new DocCommentHelper(
            "/** 
             * One block comment
             * @author Roland Schuetz
             */");
        $this->assertEquals('One block comment',
        		$docCommentHelper->getShortDoc());
        
        
        $docCommentHelper = new DocCommentHelper(
            "/** 
             * Very long one block comment Very long one block comment Very long one block comment Very long one block comment Very long one block comment
             * @author Roland Schuetz
             */");
        $this->assertEquals('Very long one block comment Very long one block comment Very long one block comment Very long one ...',
        		$docCommentHelper->getShortDoc());
		
        $docCommentHelper = new DocCommentHelper(
            "/** 
             * Very long two block comment Very long two block comment Very long two block comment Very long two block comment Very long two block comment
             *
             * Very long two block comment
             * @author Roland Schuetz
             */");
        $this->assertEquals('Very long two block comment Very long two block comment Very long two block comment Very long two ...',
        		$docCommentHelper->getShortDoc());
		
		
        $docCommentHelper = new DocCommentHelper(
            "/** 
             * Two block comment
             *
             * second block
             * @author Roland Schuetz
             */");
        $this->assertEquals('Two block comment ...',
        		$docCommentHelper->getShortDoc());
    }
    
	public function testGetLongDoc() {
        $docCommentHelper = new DocCommentHelper(
            "/** 
             * One block comment
             * @author Roland Schuetz
             */");
        $this->assertEquals('One block comment',
        		$docCommentHelper->getLongDoc());
		
		
        $docCommentHelper = new DocCommentHelper(
            "/** 
             * Two block comment
             *
             * second block
             * @author Roland Schuetz
             */");
        $this->assertEquals('Two block comment<p>second block</p>',
        		$docCommentHelper->getLongDoc());
    }

	public function testGetParams() {
		$reflectionClass = new ReflectionClass('DocCommentHelperTestSample');
		$reflectionMethod = $reflectionClass->getMethod('testGetParams');
		
		// retrieve this from reflection
		$expected = array(
			array(
				'name'		=> 'mandatory',
				'type'		=> 'NotProvided',
				'doc'		=> '',
				'optional'	=> false,
				'default'	=> false
			),
			array(
				'name'		=> 'optionalDefaultNull',
				'type'		=> 'NotProvided',
				'doc'		=> '',
				'optional'	=> true,
				'default'	=> 'NULL'
			),
			array(
				'name'		=> 'optionalDefaultFalse',
				'type'		=> 'NotProvided',
				'doc'		=> '',
				'optional'	=> true,
				'default'	=> 'False'
			),
			array(
				'name'		=> 'optionalDefaultTrue',
				'type'		=> 'NotProvided',
				'doc'		=> '',
				'optional'	=> true,
				'default'	=> 'True'
			),
			array(
				'name'		=> 'optionalDefaultEmptyString',
				'type'		=> 'NotProvided',
				'doc'		=> '',
				'optional'	=> true,
				'default'	=> '""'
			),
			array(
				'name'		=> 'optionalDefaultString',
				'type'		=> 'NotProvided',
				'doc'		=> '',
				'optional'	=> true,
				'default'	=> '"lala"'
			),
		);
        $docCommentHelper = new DocCommentHelper(
            "/** 
             * No params info
             */");
        $this->assertEquals($expected,$docCommentHelper->getParams($reflectionMethod));
		
		// add phpdocs data
		$expected[0]['type'] = 'string';
		$expected[0]['doc'] = 'This is totally mandatory';
        $docCommentHelper = new DocCommentHelper(
            "/** 
             * With params info
             * @param string \$mandatory This is totally mandatory
             */");
        $this->assertEquals($expected,$docCommentHelper->getParams($reflectionMethod));
	}

	public function testGetReturn() {
		
		// default
		$expected = array(
			'type'		=> 'NotProvided',
			'doc'		=> '',
		);
        $docCommentHelper = new DocCommentHelper(
            "/** 
             * No return info
             */");
        $this->assertEquals($expected,$docCommentHelper->getReturn());
		
		// add phpdocs data
		$expected = array(
			'type'		=> 'string',
			'doc'		=> 'Return is some string',
		);
        $docCommentHelper = new DocCommentHelper(
            "/** 
             * With return info
             * @return string Return is some string
             */");
        $this->assertEquals($expected,$docCommentHelper->getReturn());
	}
}

class DocCommentHelperTestSample {
    public function testGetParams($mandatory,$optionalDefaultNull=null,$optionalDefaultFalse=false,
    		$optionalDefaultTrue=true,$optionalDefaultEmptyString='',$optionalDefaultString='lala') {}

}

