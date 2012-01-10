<?php
/**
 * 
 * http://joshosopher.tumblr.com/post/1271596379/the-new-keyword-autoloading-and-namespaces-in-php-5-3
 * @author Cem Selman
 *
 */
class AutoLoader
{
	protected static $_instance;

	public static function getInstance() {
		if(   !self::$_instance instanceof self )
		self::$_instance = new self;
		return self::$_instance;
	}

	private $_extensions;
	private $_path;

	function __construct( $path = null, $exts = null )
	{
		// sets default path if none specified by argument
		if( is_null( $path ))
		$path = __DIR__;
		// use setPath in order to easily overload in subclasses
		if( is_string( $path ))
		$this->setPath( $path );
		// sets default extension if none specified by argument
		if( is_null( $exts ) )
		$exts = 'php';
		// adds single extension to extension array if string specified by argument
		// or sets extensions from array if array specified by argument
		if( is_string( $exts ))
		$this->addExtension($exts );
		elseif( is_array( $exts ))
		$this->setExtensions( $exts );
	}

	function getPath()
	{
		return $this->_path;
	}

	function setPath( $path )
	{
		$this->_path = $path;
	}

	function addExtension( $ext )
	{
		// prepends period to extension if none found
		if( substr( $ext, 0, 1) !== '.' )
		$ext = '.'.$ext;
		$this->_extensions[ $ext ] = $ext;
	}

	function removeExtension( $ext )
	{
		unset( $this->_extensions[ $ext ]);
	}

	function getExtensions()
	{
		return $this->_extensions;
	}

	function setExtensions( array $extensions )
	{
		foreach( $extension as $ext )
		$this->addExtension( $ext );
	}

	function register()
	{
		set_include_path( $this->_path );
		// comma-delimited list of valid source-file extensions
		spl_autoload_extensions(implode(',',$this->_extensions) );

		spl_autoload_register();  // default behavior without callback
	}
}