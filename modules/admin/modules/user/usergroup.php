<?php
require_once dirname(__FILE__) . '/../../../../classes/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Usergroup;

switch($_action)
{
	case 'dataTables':
		echo $model->dataTables($model->aAllField, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'delete':
		$model->removeEntry($_REQUEST[$model->sIndexColumn]);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'save':
		$usergroupId = $model->saveEntry($_POST);
		$model->delete("usergroup_user", "usergroupId = :usergroupId", array("usergroupId"=>$usergroupId));
		if (isset($_POST["userId"])) {
			foreach ($_POST["userId"] as $userId) {
				$model->insert("usergroup_user", array("usergroupId"=>$usergroupId, "userId"=>$userId));
			}
		}
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'edit':
		$data["model"] = $model->getEntry($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;
		
		$user = new User();
		$data["user"] = $user->getUsers();
		//print_r($data);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'new':
		$user = new User();
		$data["user"] = $user->getUsers();
		//print_r($data);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'view':
	default:
		$model->displayTemplate("admin", $model->sTable.'_list');
		break;
}