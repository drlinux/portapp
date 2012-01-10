<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Brand;

switch($_action)
{
	case 'show':
		$data["model"] = $model->getEntry($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;

		$model->displayTemplate("b2b", "brand_show", $data);
		break;
	case 'view':
	default:
		$model->displayTemplate("b2b", "brand_list");
		break;
}