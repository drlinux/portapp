<?php
require_once dirname(__FILE__) . '/../../../../classes/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Currency;

switch($_action) {
	case 'dataTables':
		$aColumns = array("currencyId", "currencyTitle", "currencyCode", "currencySign", "currencyConversionRate");
		echo $model->dataTables($aColumns, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'delete':
		$model->removeEntry($_REQUEST[$model->sIndexColumn]);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'save':
		$formvars = array_merge($_POST, $_FILES);
		$model->mungeFormData($formvars);
		if($model->isValidForm($formvars)) {
			$model->saveEntry($formvars);
			header("Location: " . $_SERVER["PHP_SELF"]);
		} else {
			$model->displayTemplate("admin", $model->sTable.'_form', $formvars);
		}
		break;
	case 'edit':
		$data = $model->getEntry($_REQUEST[$model->sIndexColumn]);
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