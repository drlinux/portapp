<?php
require_once dirname(__FILE__) . '/../../../../config/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new User;

switch($_action)
{
	case 'updateUser':
		$user = new User();
		$user->mungeFormData($_POST);
		if ($success = $user->isValidForm($_POST)) {
			$user->saveEntry($_POST);
		}
		echo(json_encode(array("success"=>$success, "msg"=>$user->msg, "field"=>$user->field)));
		break;
	case 'dataTables':
		$aColumns = array( 'userId', 'userFirstname', 'userLastname', 'userName', 'userEmail', 'userTckn' );
		echo $model->dataTables($aColumns, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'saveRole':
		$model->delete("user_role", $model->sIndexColumn." = :id", array("id"=>$_REQUEST[$model->sIndexColumn]));
		foreach ($_POST["roleId"] as $roleId) {
			$model->insert("user_role", array($model->sIndexColumn=>$_REQUEST[$model->sIndexColumn], "roleId"=>$roleId));
		}
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'save':
		$model->mungeFormData($_POST);
		if($model->isValidForm($_POST)) {
			$model->saveEntry($_POST);
			header("Location: " . $_SERVER["PHP_SELF"]);
		} else {
			$data["model"] = $_POST;
			$data["model"]['userBirthdate'] = implode(".", array_reverse(explode("-", $data["model"]['userBirthdate'])));
			$model->displayTemplate("admin", $model->sTable.'_form', $data);
		}
		break;
	case 'edit':
		$data["model"] = $model->getEntry($_REQUEST[$model->sIndexColumn]);
		$data["model"]['userTcknNew'] = $data["model"]['userTckn'];
		$data["model"]['userEmailNew'] = $data["model"]['userEmail'];
		$data["model"]['userNameNew'] = $data["model"]['userName'];
		$data["model"]['userBirthdate'] = implode(".", array_reverse(explode("-", $data["model"]['userBirthdate'])));
		//print_r($data);exit;
		
		$role = new Role;
		$data["role"] = $role->getEntries();
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