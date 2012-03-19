<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productgroup;

switch($_action)
{
	case 'show':
		$data["model"] = $model->getEntry($_REQUEST[$model->sIndexColumn], array("i18n"=>true));
		
		$products_list = $productattribute->getProductattributes(array("iDisplayStart"=>0,"iDisplayLength"=>100,"sType"=>"productgroup","productgroupId"=>$_REQUEST[$model->sIndexColumn]), false);
		parseProductsList($products_list["aaData"], $data["products_list"]);
		
		/* BANNERS */
		getBanners($data["banner_files"]);
		
		//print_r($data);exit;
		$model->displayTemplate("b2c", "productgroup_show", $data);
		break;
	case 'view':
	default:
		$model->displayTemplate("b2c", "productgroup_list", $data);
		break;
}