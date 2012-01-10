<?php
//str_replace('\\', '/', $path)
$currentDir = dirname(__FILE__);

/* URLs */
define('_THEMES_DIR_', __PS_BASE_URI__.'themes/');
define('_MODULE_DIR_', __PS_BASE_URI__.'modules/');
define('_PS_IMG_', __PS_BASE_URI__.'img/');

/* Directories */
define('_PS_ROOT_DIR_', realpath($currentDir.'/..'));
define('_PS_THEMES_DIR_', _PS_ROOT_DIR_.'/themes/');
define('_PS_MODULE_DIR_', _PS_ROOT_DIR_.'/modules/');
define('_PS_IMG_DIR_', _PS_ROOT_DIR_.'/img/');
