<?php
require_once dirname(__FILE__) . '/../../../../classes/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Taxonomy;

switch($_action) {
	case 'dataTables':
		$aColumns = array("taxonomyId", "taxonomyTitle", "taxonomyRate", "taxonomySorting");
		echo $model->dataTables($aColumns, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'save':
		$formvars = array_merge($_POST, $_FILES);
		//$model->mungeFormData($formvars);
		//if($model->isValidForm($formvars)) {
			$model->saveEntry($formvars, array("i18n"=>true));
			header("Location: " . $_SERVER["PHP_SELF"]);
		//} else {
			//$model->displayTemplate("admin", $model->sTable.'_form', $formvars);
		//}
		break;
	case 'edit':
		$data["model"] = $model->getEntry($_REQUEST[$model->sIndexColumn]);
		$data["i18n"] = $model->getEntryWithLanguages($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'new':
		$data["i18n"] = $model->getEntryWithLanguages($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'view':
	default:
		$model->displayTemplate("admin", $model->sTable.'_list');
		break;
}