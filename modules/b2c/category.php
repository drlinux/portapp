<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Category();

switch($_action)
{
	case 'show':
		$data["model"] = $model->getEntry($_REQUEST[$model->sIndexColumn], array("i18n"=>true));
		//print_r($data);exit;
		$products_list = $productattribute->getProductattributes(array("iDisplayStart"=>0,"iDisplayLength"=>100,"sType"=>"category","categoryId"=>$_REQUEST[$model->sIndexColumn]), false);
		parseProductsList($products_list["aaData"], $data["products_list"]);
		
		$model->displayTemplate("b2c", "category_show", $data);
		break;
		
	case 'view':
	default:
		$model->displayTemplate("b2c", "category_list");
		break;
}