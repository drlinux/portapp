<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

Permission::checkPermissionRedirect("b2c");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new User();

switch($_action)
{
	case 'updateUser':
		$user = new User();
		$user->mungeFormData($_POST);
		if ($success = $user->isValidForm($_POST)) {
			$_POST["userId"] = $_SESSION["userId"];
			$user->saveEntry($_POST);
		}
		echo(json_encode(array("success"=>$success, "msg"=>$user->msg, "field"=>$user->field)));
		break;
	case 'view':
	default:
		$data["model"] = $model->getEntry($_SESSION["userId"]);
		$data["model"]['userTcknNew'] = $data["model"]['userTckn'];
		$data["model"]['userEmailNew'] = $data["model"]['userEmail'];
		$data["model"]['userNameNew'] = $data["model"]['userName'];
		$data["model"]['userBirthdate'] = implode(".", array_reverse(explode("-", $data["model"]['userBirthdate'])));
		//print_r($data);exit;
		
		$model->displayTemplate("b2c", "user", $data);
		break;
}