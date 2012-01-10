<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

//Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Fxrate;

switch($_action) {
	case 'view':
	default:
		$data = $model->getFxrateData();
		//print_r($data);exit;
		
		$model->displayTemplate("admin", "index", $data);
		break;
}