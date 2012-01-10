<?php
error_reporting (E_ALL ^ E_NOTICE);

/* Improve PHP configuration to prevent issues */
ini_set('upload_max_filesize', '100M');
ini_set('default_charset', 'utf-8');
ini_set('magic_quotes_runtime', 0);

//$path = 'E:\sdk\xampp\htdocs\portapp\assets\piwik\libs\Zend';
//set_include_path(get_include_path() . PATH_SEPARATOR . $path);
//echo get_include_path();exit;

date_default_timezone_set("Europe/Istanbul");
set_time_limit(500);
//print_r(ini_get_all());exit;

/* Correct Apache charset */
header('Content-type: text/html; charset=utf-8');

session_start();

require_once(dirname(__FILE__).'/settings.inc.php');

/* Include all defines */
require_once(dirname(__FILE__).'/defines.inc.php');

/* Autoload */
require(dirname(__FILE__).'/autoload.php');

/* Redefine REQUEST_URI if empty (on some webservers...) */
if (!isset($_SERVER['REQUEST_URI']) OR empty($_SERVER['REQUEST_URI']))
{
	if (substr($_SERVER['SCRIPT_NAME'], -9) == 'index.php')
		$_SERVER['REQUEST_URI'] = dirname($_SERVER['SCRIPT_NAME']).'/';
	else
	{
		$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
		if (isset($_SERVER['QUERY_STRING']) AND !empty($_SERVER['QUERY_STRING']))
			$_SERVER['REQUEST_URI'] .= '?'.$_SERVER['QUERY_STRING'];
	}
}


/* Smarty */
require_once(dirname(__FILE__).'/smarty.config.inc.php');
