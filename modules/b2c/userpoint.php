<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';

Permission::checkPermissionRedirect("b2c");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Userpoint();

switch($_action)
{
	case 'view':
	default:
		$data["userpoints"] = $model->getUserpointsOwned();
		//print_r($data);exit;
		
		$model->displayTemplate("b2c", "userpoint", $data);
		break;
}