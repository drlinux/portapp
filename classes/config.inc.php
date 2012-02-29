<?php
ob_start("ob_gzhandler");

global $project;
$aHost = explode(".", $_SERVER["SERVER_NAME"]);
$project['dbname'] = $aHost[0];

//error_reporting (E_ALL ^ E_NOTICE);
if (false) {//DEVELOPMENT_ENVIRONMENT == true
	error_reporting(E_ALL);
	ini_set('display_errors','On');
}
else {
	error_reporting(E_ALL);
	ini_set('display_errors','Off');
	ini_set('log_errors', 'On');
	ini_set('error_log', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . $project['dbname'] . '.error.log');
}


/* Improve PHP configuration to prevent issues */
ini_set('upload_max_filesize', '100M');
ini_set('default_charset', 'utf-8');
ini_set('magic_quotes_runtime', 0);

date_default_timezone_set("Europe/Istanbul");
//setlocale(LC_ALL, 'tr_TR.UTF-8', 'tr_TR', 'tr', 'turkish');
set_time_limit(500);
//print_r(ini_get_all());exit;

/* Correct Apache charset */
header('Content-type: text/html; charset=utf-8');
//header('Content-type: text/html; charset=iso-8859-9');
//echo strftime("%Y-%B-%d", strtotime("+30 days"));exit;
//echo date("Y-M-d", strtotime("now"));exit;


session_start();

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
