<?php
require_once dirname(__FILE__) . '/../../../../classes/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Permission;

switch($_action) {
	case 'jsonPermissions':
		$permission = new Permission;
		$permissions_selected = $permission->getPermissionsByRoleId($_REQUEST[$model->sIndexColumn]);
		echo($permission->jsonTree(null, $permissions_selected["selected"]));
		break;
	case 'jsonTree':
		echo($model->jsonTree());
		break;
	case 'dataTables':
		$aColumns = array("permissionId", "permissionTitle", "permissionKeywords");
		echo $model->dataTables($aColumns, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'save':
		$_POST["display"] = !isset($_POST["display"]) ? -1 : $_POST["display"];
		$formvars = array_merge($_POST, $_FILES);

		$permissionId = $model->saveEntry($formvars, array("i18n"=>true));
		
		global $smarty;
		$model->insert("role_permission", array("roleId"=>$smarty->getVariable("_USER_ROLE_ADMIN_LEVEL1"), "permissionId"=>$permissionId));
		
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'delete':
		$model->removeEntry($_REQUEST[$model->sIndexColumn]);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'edit':
		$data["model"] = $model->getEntry($_REQUEST[$model->sIndexColumn]);
		$data["i18n"] = $model->getEntryWithLanguages($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;
		
		$permission = new Permission;
		$data["permission"] = $permission->getEntries();
		//print_r($data);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'new':
		$data["i18n"] = $model->getEntryWithLanguages($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;
		
		$permission = new Permission;
		$data["permission"] = $permission->getEntries();
		//print_r($data);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'view':
	default:
		$model->displayTemplate("admin", $model->sTable.'_list');
		break;
}