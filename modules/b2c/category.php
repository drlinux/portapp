<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Category();

switch($_action)
{
	case 'show':
		$data["model"] = $model->getEntry($_REQUEST[$model->sIndexColumn], array("i18n"=>true));
		//print_r($data);exit;

		$model->displayTemplate("b2c", "category_show", $data);
		break;
	case 'view':
	default:
		$model->displayTemplate("b2c", "category_list");
		break;
}