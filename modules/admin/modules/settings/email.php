<?php
require_once dirname(__FILE__) . '/../../../../classes/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Setting;

switch($_action)
{
	case 'save':
		$model->delete($model->sTable, "settingParameter LIKE '_EMAIL_%'");
		
		foreach ($_POST["setting"] as $settingParameter=>$settingValue) {
			$model->insert($model->sTable, array("settingParameter"=>$settingParameter, "settingValue"=>$settingValue));
		}
		
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'view':
	default:
		$model->displayTemplate("admin", 'email');
		break;
}