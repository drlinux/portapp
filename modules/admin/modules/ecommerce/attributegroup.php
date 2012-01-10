<?php
require_once dirname(__FILE__) . '/../../../../config/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Attributegroup;

switch($_action)
{
	
	case 'jsonAttribute':
		$attribute = new Attribute;
		echo(json_encode($attribute->getAttributesByAttributegroupId($_REQUEST[$model->sIndexColumn])));
		break;
	case 'dataTables':
		$aColumns = array("attributegroupId", "attributegroupTitle");
		echo $model->dataTables($aColumns, $model->sIndexColumn, $model->sTable, $_GET);
		break;





	case 'deleteAttribute':
		$attribute = new Attribute();
		$attribute->removeEntry($_REQUEST[$attribute->sIndexColumn]);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'saveAttribute':
		$attribute = new Attribute();
		$attribute->saveEntry($_POST, array("i18n"=>true));
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'edit-attribute':
		$attribute = new Attribute();
		$data["attribute"] = $attribute->getEntry($_REQUEST[$attribute->sIndexColumn]);
		$data["attributegroup"] = $model->getEntry($data["attribute"]["attributegroupId"], array("i18n"=>true));
		$data["i18n"] = $attribute->getEntryWithLanguages($_REQUEST[$attribute->sIndexColumn]);
		//print_r($data);exit;

		$model->displayTemplate("admin", $attribute->sTable.'_form', $data);
		break;
	case 'new-attribute':
		$data["attributegroup"] = $model->getEntry($_REQUEST[$model->sIndexColumn], array("i18n"=>true));
		$attribute = new Attribute();
		$data["i18n"] = $attribute->getEntryWithLanguages($_REQUEST[$attribute->sIndexColumn]);
		//print_r($data);exit;

		$model->displayTemplate("admin", $attribute->sTable.'_form', $data);
		break;




	case 'deleteAttributegroup':
		$model->removeEntry($_REQUEST[$model->sIndexColumn]);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'saveAttributegroup':
		//$model->mungeFormData($_POST);
		//if($model->isValidForm($_POST)) {
		$model->saveEntry($_POST, array("i18n"=>true));
		header("Location: " . $_SERVER["PHP_SELF"]);
		//} else {
		//$model->displayTemplate("admin", $model->sTable.'_form', $formvars);
		//}
		break;
	case 'edit-attributegroup':
		$data["model"] = $model->getEntry($_REQUEST[$model->sIndexColumn]);
		$data["i18n"] = $model->getEntryWithLanguages($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;

		$attribute = new Attribute;
		$data["attribute"] = $attribute->getAttributesByAttributegroupId($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;

		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'new-attributegroup':
		$data["i18n"] = $model->getEntryWithLanguages($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;

		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'view':
	default:
		$data = $model->getAttributegroupsWithAttributes();
		//print_r($data);exit;

		$model->displayTemplate("admin", $model->sTable.'_list', $data);
		break;
}