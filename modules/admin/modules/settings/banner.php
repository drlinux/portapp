<?php
require_once dirname(__FILE__) . '/../../../../config/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Banner;

switch($_action)
{
	case 'dataTables':
		echo $model->dataTables($model->aAllField, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'deleteBanners':
		$model->run("delete from " . $model->sTable);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'delete':
		$model->removeEntry($_REQUEST[$model->sIndexColumn], true);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'save':
		$formvars = array_merge($_POST, $_FILES);
		//$model->mungeFormData($formvars);
		//if($model->isValidForm($formvars)) {
			$model->saveEntry($formvars, array("picture"=>array("resize"=>array(720, 300), "isDefault"=>true)));
			header("Location: " . $_SERVER["PHP_SELF"]);
		//} else {
			//$model->displayTemplate("admin", $model->sTable.'_form', $formvars);
		//}
		break;
	case 'edit':
		$data = $model->getEntry($_REQUEST[$model->sIndexColumn], array("i18n"=>false, "picture"=>true));
		//print_r($data);exit;
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'new':
		$model->displayTemplate("admin", $model->sTable.'_form');
		break;
	case 'view':
	default:
		$data = $model->getEntries();
		$model->displayTemplate("admin", $model->sTable.'_list', $data);
		break;
}