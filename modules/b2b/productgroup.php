<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

Permission::checkPermissionRedirect("b2b");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productgroup;

switch($_action)
{
	case 'show':
		$data["model"] = $model->getEntry($_REQUEST[$model->sIndexColumn], array("i18n"=>true));
		//print_r($data);exit;
		
		$model->displayTemplate("b2b", "productgroup_show", $data);
		break;
	case 'view':
	default:
		$model->displayTemplate("b2b", "productgroup_list");
		break;
}