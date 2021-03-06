<?php
define('SMARTY_DIR', _PS_ROOT_DIR_ . '/assets/smarty/');
require(SMARTY_DIR . 'Smarty.class.php');

global $smarty;
$smarty = new Smarty();
$smarty->template_dir	= getcwd();
$smarty->compile_dir	= SMARTY_DIR . 'compile';
$smarty->cache_dir		= SMARTY_DIR . 'cache';
$smarty->config_dir		= _PS_ROOT_DIR_ . '/configs';

//$smarty->testInstall();
//$smarty->allow_php_templates= true;
$smarty->debugging		= false;
$smarty->caching		= false;
$smarty->force_compile	= true;
$smarty->compile_check	= false;
$smarty->cache_lifetime	= 120;

// Set default language
if (!isset($_SESSION["PROJECT_LANGUAGE"])) {
	$_SESSION["PROJECT_LANGUAGE"] = 1;
}

$sLanguage = ($_SESSION["PROJECT_LANGUAGE"]==1)?"tr":"en";

$smarty->clearConfig();
$smarty->configLoad("Messages_$sLanguage.properties");


// Set default currency
if (!isset($_SESSION["CURRENCY_ID"])) {
	$_SESSION["CURRENCY_ID"] = 1;
}

// Set if homepage selected
if(basename($_SERVER["SCRIPT_FILENAME"],".php") == "index")
{
	$smarty->assign("HOME_PAGE_SELECTED"," selected "); 
}


// TODO: bunu başka nerelerde kullanabilirim?
$config['date'] = '%I:%M %p';
$config['time'] = '%H:%M:%S';
$config['datetime'] = '%d.%m.%Y %H:%M';
$smarty->assign('config', $config);


if(isset($_SERVER["HTTPS"]) AND (!empty($_SERVER["HTTPS"])) AND strtolower($_SERVER['HTTPS'])!='off')
{
	$url_scheme = "https://";
}
else
{
	$url_scheme = "http://";

	// FIXME: Always use https
	//$url_scheme = "https://";
	//header("Location: " . $url_scheme . $_SERVER["SERVER_NAME"] . __PS_BASE_URI__);
}


/*
if( "www." != substr( $_SERVER[ 'SERVER_NAME' ] , 0 , 4) ){
	header("Location: " . $url_scheme . "www." .  $_SERVER[ 'SERVER_NAME' ] .  __PS_BASE_URI__ , TRUE, 301);
	exit;
}
*/

$op = ($_SERVER['QUERY_STRING']=="") ? $_SERVER['PHP_SELF'] : $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
//$op = str_replace("&","&#38;",$op);
$uri = $url_scheme . $_SERVER['SERVER_NAME'] . $op;


$project['url'] = $url_scheme . $_SERVER["SERVER_NAME"] . __PS_BASE_URI__;
$project['uri'] = $uri;
$project['encodedUri'] = urlencode($uri);
$project['language'] = $_SESSION["PROJECT_LANGUAGE"];
$smarty->assign('project', $project);



$setting = new Setting();
$aSetting = $setting->getSettings();
foreach ($aSetting["options"] as $settingParameter=>$settingValue) {
	$smarty->assign($settingParameter, $settingValue);
	// TODO: Bu şekilde yapsak?
	//$smarty->assign('setting', $blabla);
}
