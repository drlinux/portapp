<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

Permission::checkPermissionRedirect("promoshop");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productorder;

switch($_action)
{
	case 'view':
	default:
		$data = $model->getProductordersOwned();
		//print_r($data);exit;

		$model->displayTemplate("promoshop", "order", $data);
		break;
}