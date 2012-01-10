<?php
require_once dirname(__FILE__) . '/../../../../config/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Supplier;

switch($_action) {
	case 'dataTables':
		echo $model->dataTables($model->aAllField, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'delete':
		$model->removeSupplier($_REQUEST[$model->sIndexColumn]);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'save':
		$formvars = array_merge($_POST, $_FILES);
		//$model->mungeFormData($formvars);
		//if($model->isValidForm($formvars)) {
		$model->saveSupplier($formvars);
		header("Location: " . $_SERVER["PHP_SELF"]);
		//} else {
		//$model->displayTemplate("admin", $model->sTable.'_form', $formvars);
		//}
		break;
	case 'edit':
		$data = $model->getSupplierBySupplierId($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;

		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'new':
		$model->displayTemplate("admin", $model->sTable.'_form');
		break;
	case 'view':
	default:
		$model->displayTemplate("admin", $model->sTable.'_list');
		break;
}