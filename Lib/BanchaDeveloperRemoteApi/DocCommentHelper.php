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
 * A decorator class for phpDocumentor2s DocBlock class
 * @author        Roland Schuetz <roland@banchaproject.com>
 */
class DocCommentHelper extends phpDocumentor_Reflection_DocBlock {

	/**
	 * Expects an phpdocs comment string as input
	 */
	public function __construct($docblock) {
		parent::__construct($docblock);
	}
	
	/**
	 * Loads and formates the author name for output
	 */
	public function getFormatedAuthor() {
		$author = $this->getTag('author');
		
		if(!$author || $author->getContent()=='') {
			return '';
		}
		$author = $author->getContent();
		
		// try to find: "Username" <email>
		if(1 == preg_match('!"(.*?)"\s+<\s*(.*?)\s*>!', $author, $matches)) {
			return '<a href="mailto:'.$matches[2].'">'.$matches[1].'</a>';
		}
		// try to find: Username <email>
		if(1 == preg_match('!(.*?)\s+<\s*(.*?)\s*>!', $author, $matches)) {
			return '<a href="mailto:'.$matches[2].'">'.$matches[1].'</a>';
		}
		
		// probably just the name, return unformated
		return $author;
	}
	
	/**
	 * Returns the doc preview
	 */
	public function getShortDoc() {
		$longDocWithoutFirstLine = $this->getLongDescription()->getContents();
        
        // if first block is longer then 100 chars trim
        $desc = $this->getShortDescription();
        if(strlen($desc) > 100) {
            $desc = substr($desc,0,100);
            // stop at a full word
            $end = strrpos($desc,' ');
            $end = $end==False ? 100 : $end;
            return substr($desc,0,$end).' ...';
        }
        
		if(empty($longDocWithoutFirstLine)) {
			return $desc;
		}
		
		return $desc.' ...';
	}
	
	/**
	 * Returns the full, markdown formated doc description
	 */
	public function getLongDoc() {
		return $this->getShortDescription().$this->getLongDescription()->getFormattedContents();
	}
	
	/**
	 * Returns the return value
	 */
	public function getReturn() {
		$return = $this->getTag('return');
		
        if(!$return) {
            return array(
                'type' => 'NotProvided',
                'doc'  => '',
            );
        }
        
		return array(
            'type' => $return->getType() ? $return->getType() : 'NotProvided',
			'doc'  => $return->getDescription(),
		);
	}
	
	/**
	 * Returns all params
	 * @param ReflectionMethod $method
	 */
	public function getParams($method) {
		
		// we can't just rely on the comments here, so first load reflection data
		$reflectedParams = $method->getParameters();
		
		// in the order of the reflection params build params array
		$params = array();
		foreach($reflectedParams as $param) {
			
			// find reflected param in docs
			$docParam = $this->getParam($param->name);

			// get default value
			$params[] = array(
				'type'		=> $docParam ? $docParam->getType() : 'NotProvided',
				'doc'		=> $docParam ? $docParam->getDescription() : '',
				'name'		=> $param->name,
				'optional'	=> $param->isOptional(),
				'default'	=> $this->getDefaultValue($param)
			);
		}
				
		return $params;
	}
	
	/**
	 * Returns the $tagName Tag
	 * @param String $tagName
	 */
	protected function getTag($tagName) {
		foreach($this->getTags() as $tag) {
			if($tag->getName() == $tagName) {
				return $tag;
			}
		}
		return null;
	}
	/**
	 * Returns the param $paramName
	 * @param String $paramName
	 */
	protected function getParam($paramName) {
		$paramName = '$'.$paramName;
		foreach($this->getTags() as $tag) {
			if($tag->getName() == 'param' && $tag->getVariableName() == $paramName) {
				return $tag;
			}
		}
		return null;
	}
	/**
	 * Returns the default param value as string or false
	 * @param ReflectionParameter $param the reflection parameter to get the default from
	 */
	protected function getDefaultValue($param) {
		if(!$param->isOptional()) {
			// there is no option, $param->getDefaultValue() would trigger an exception
			return false;
		}
		
		// get default value
		$value =  $param->getDefaultValue();
		
		// booleans
		if(gettype($value)=='boolean') {
			return $value ? 'True' : 'False';
		}
		
		// strings
		if(gettype($value)=='string') {
			return '"'.$value.'"';
		}
		
		// probably null
		return gettype($value);
	}
}

