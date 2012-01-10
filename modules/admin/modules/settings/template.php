<?php
require_once dirname(__FILE__) . '/../../../../config/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Setting;

switch($_action)
{
	case 'save':
		$model->update($model->sTable, array("settingValue"=>$_POST["settingValue"]), "settingParameter = :settingParameter", array("settingParameter"=>$_POST["settingParameter"]));
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'view':
	default:
		$dir = _PS_THEMES_DIR_;
		$filesystem = new CasFilesystem();
		$data["templates"] = $filesystem->listDirectories(_PS_THEMES_DIR_ . "b2c/");
		
		$a = $model->select($model->sTable, "settingParameter = :param", array("param"=>"_THEME_B2C_NAME"), "settingValue");
		$data["template"] = $a[0]["settingValue"];
		//print_r($data);exit;
		
		$model->displayTemplate("admin", 'template', $data);
		break;
}