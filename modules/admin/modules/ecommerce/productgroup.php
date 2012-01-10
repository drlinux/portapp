<?php
require_once dirname(__FILE__) . '/../../../../config/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Productgroup();

switch($_action) {
	case 'dataTables':
		$aColumns = array("productgroupId", "productgroupTitle");
		echo $model->dataTables($aColumns, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'save':
		$model->saveEntry($_POST, array("i18n"=>true));
		$model->delete("productgroup_product", "productgroupId = :productgroupId", array("productgroupId"=>$_POST[$model->sIndexColumn]));
		if (isset($_POST["productId"])) {
			foreach ($_POST["productId"] as $productId) {
				$model->insert("productgroup_product", array("productgroupId"=>$_POST[$model->sIndexColumn], "productId"=>$productId));
			}
		}
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'edit':
		//$data["model"] = $model->getEntry($_REQUEST[$model->sIndexColumn]);
		$data["model"] = $model->getProductgroup($_REQUEST[$model->sIndexColumn]);
		$data["i18n"] = $model->getEntryWithLanguages($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;
		
		$product = new Product();
		$data["product"] = $product->getProducts();
		//print_r($data["product"]);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'new':
		$data["i18n"] = $model->getEntryWithLanguages($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;
		
		$product = new Product();
		$data["product"] = $product->getEntries();
		//print_r($data);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'view':
	default:
		$model->displayTemplate("admin", $model->sTable.'_list');
		break;
}