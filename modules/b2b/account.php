<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

Permission::checkPermissionRedirect("b2b");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new User();

switch($_action)
{
	case 'updateAccountInfo':
		$user = new User();
		if ($success = $user->isValidAccountForm($_POST)) {
			$_POST["userId"] = $_SESSION["userId"];
			//$_POST["userStatus"] = 1;
			$user->updateAccountInfo($_POST);
		}
		echo(json_encode(array("success"=>$success, "msg"=>$user->msg, "field"=>$user->field)));
		break;
	case 'view':
	default:
		$data["model"] = $model->getEntry($_SESSION["userId"]);
		$data["model"]['userTcknNew'] = $data["model"]['userTckn'];
		$data["model"]['userEmailNew'] = $data["model"]['userEmail'];
		$data["model"]['userBirthdate'] = implode(".", array_reverse(explode("-", $data["model"]['userBirthdate'])));
		//print_r($data);exit;
		addJavascript("assets/extension/classes/User.js");
		
		$model->displayTemplate("b2b", "account", $data);
		break;
}