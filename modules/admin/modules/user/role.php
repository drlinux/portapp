<?php
require_once dirname(__FILE__) . '/../../../../classes/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Role;

switch($_action)
{
	case 'jsonPermissions':
		$permission = new Permission;
		$permissions_selected = $permission->getPermissionsByRoleId($_REQUEST[$model->sIndexColumn]);
		echo($permission->jsonTree(null, $permissions_selected["selected"]));
		break;
	case 'ajaxDeleteRole':
		$model->removeEntry($_REQUEST[$model->sIndexColumn]);
		break;
	case 'ajaxSaveRole':
		$id = $model->saveRole($_POST);
		echo(json_encode(array($model->sIndexColumn=>$id)));
		break;
	case 'edit':
		$data["model"] = $model->getEntry($_REQUEST[$model->sIndexColumn]);
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