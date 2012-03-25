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
	 * Returns the $tagName Tag
	 */
	protected function getTag($tagName) {
		foreach($this->getTags() as $tag) {
			if($tag->getName() == $tagName) {
				return $tag;
			}
		}
		return null;
	}
}

