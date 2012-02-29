<?php
require_once dirname(__FILE__) . '/../../../../classes/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Setting;

switch($_action)
{
	case 'save':
		$model->update($model->sTable, array("settingValue"=>$_POST[$_POST["module"]]), "settingParameter = :settingParameter", array("settingParameter"=>"_THEME_".strtoupper($_POST["module"])."_NAME"));
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'view':
	default:
		$dir = _PS_THEMES_DIR_;
		$filesystem = new CasFilesystem();
		$data["templates"] = $filesystem->listDirectories(_PS_THEMES_DIR_);
		foreach ($data["templates"] as $template) {
			$data["templates"][$template] = $filesystem->listDirectories(_PS_THEMES_DIR_ . $template . "/");
			$a = $model->select($model->sTable, "settingParameter = :param", array("param"=>"_THEME_".strtoupper($template)."_NAME"), "settingValue");
			$data["template"][$template] = $a[0]["settingValue"];
		}
		//print_r($data);exit;
		
		$model->displayTemplate("admin", 'template', $data);
		break;
}