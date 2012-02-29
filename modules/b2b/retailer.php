<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';

Permission::checkPermissionRedirect("b2b");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Retailer;

switch($_action)
{
	case 'view':
	default:
		$data["model"] = $model->getRetailerByUserId($_SESSION["userId"]);
		//print_r($data);exit;
		
		$model->displayTemplate("b2b", "retailer", $data);
		break;
}