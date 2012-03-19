<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

Permission::checkPermissionRedirect("b2b");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Brand();

switch($_action)
{
	case 'show':
		$data["model"] = $model->getEntry($_REQUEST[$model->sIndexColumn]);
		
		$products_list = $productattribute->getProductattributes(array("iDisplayStart"=>0,"iDisplayLength"=>100,"sType"=>"brand","brandId"=>$_REQUEST[$model->sIndexColumn]), false);
		
		parseProductsList($products_list["aaData"], $data["products_list"]);
		
		//print_r($data);exit;

		$model->displayTemplate("b2b", "brand_show", $data);
		break;
	case 'view':
	default:
		
		$data["brand_list"] = $brand->getBrandsFromProductHavingPicture();
		
		$model->displayTemplate("b2b", "brand_list", $data);
		break;
}