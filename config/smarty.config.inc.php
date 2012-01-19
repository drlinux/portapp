<?php
// define smarty lib directory
define('SMARTY_DIR', _PS_ROOT_DIR_ . '/assets/smarty/');
require(SMARTY_DIR . 'Smarty.class.php');

global $smarty;
$smarty = new Smarty();
$smarty->template_dir	= getcwd();
$smarty->compile_dir	= SMARTY_DIR . 'compile';
$smarty->cache_dir		= SMARTY_DIR . 'cache';
$smarty->config_dir		= SMARTY_DIR . 'configs';

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
$smarty->assign("PROJECT_LANGUAGE", $_SESSION["PROJECT_LANGUAGE"]);

$smarty->clearConfig();
// TODO: Seçilen dile göre ilgili properties dosyası seçilecek
$smarty->configLoad('Messages_tr.properties');


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

// TODO: buna bir bak xampp de kullanılmış
/*
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
	$uri = 'https://';
} else {
	$uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'];
header('Location: '.$uri.'/xampp/');
*/
if (isset($_SERVER["HTTP_HOST"]) AND (!empty($_SERVER["HTTP_HOST"])))
{
	if(isset($_SERVER["HTTPS"]) AND (!empty($_SERVER["HTTPS"])) AND strtolower($_SERVER['HTTPS'])!='off')
	{
		$url_scheme = "https://";
	}
	else
	{
		$url_scheme = "http://";

		// FIXME: Always use https
		$url_scheme = "https://";
		header("Location: " . $url_scheme . $_SERVER["HTTP_HOST"] . __PS_BASE_URI__);
	}
	
	
	/*
	if( "www." != substr( $_SERVER[ 'HTTP_HOST' ] , 0 , 4) ){
		header("Location: " . $url_scheme . "www." .  $_SERVER[ 'HTTP_HOST' ] .  __PS_BASE_URI__ , TRUE, 301);
		exit;
	}
	*/
	
	$op = ($_SERVER['QUERY_STRING']=="") ? $_SERVER['PHP_SELF'] : $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'];
	//$op = str_replace("&","&#38;",$op);
	$uri = $url_scheme . $_SERVER['HTTP_HOST'] . $op;
	
	$project['url'] = $url_scheme . $_SERVER["HTTP_HOST"] . __PS_BASE_URI__;
	$project['uri'] = $uri;
	$project['encodedUri'] = urlencode($uri);
	$smarty->assign('project', $project);
}



$setting = new Setting();
$aSetting = $setting->getSettings();
foreach ($aSetting["options"] as $settingParameter=>$settingValue) {
	$smarty->assign($settingParameter, $settingValue);
	// TODO: Bu şekilde yapsak?
	//$smarty->assign('setting', $blabla);
}
