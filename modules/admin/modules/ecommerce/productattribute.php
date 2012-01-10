<?php
require_once dirname(__FILE__) . '/../../../../config/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productattribute;

switch($_action)
{
	
	/*
	* Productattributemovement
	*/
	case 'deleteProductattributemovement':
		$productattributemovement = new Productattributemovement();
		$productattributemovement->removeEntry($_REQUEST[$productattributemovement->sIndexColumn]);
		echo(json_encode(array("success"=>true)));
		break;
	
	case 'saveProductattributemovement':
		$productattributemovement = new Productattributemovement();
		$productattributemovement->saveEntry($_POST);
		echo(json_encode(array("success"=>true)));
		break;
	
	case 'jsonProductattributemovementByProductattributeId':
		$productattributemovement = new Productattributemovement();
		echo(json_encode($productattributemovement->getProductattributemovementByProductattributeId($_REQUEST[$model->sIndexColumn])));
		break;
	
		
		
		
		
	case 'dataTables':
		echo $model->dataTables($model->aAllField, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'edit':
		$productattributeId = $_REQUEST[$model->sIndexColumn];
		$data["productattribute"] = $model->getEntry($productattributeId);
		//print_r($data);exit;
		
		$supplier = new Supplier();
		$data["supplier"] = $supplier->getSuppliers();
		//print_r($data);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'view':
	default:
		$model->displayTemplate("admin", $model->sTable.'_list');
		break;
}