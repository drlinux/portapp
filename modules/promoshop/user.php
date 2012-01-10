<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

Permission::checkPermissionRedirect("promoshop");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new User();

switch($_action)
{
	case 'save':
		$user = new User();
		$user->mungeFormData($_POST);
		if($user->isValidForm($_POST)) {
			$_POST["userId"] = $_SESSION["userId"];
			$user->saveEntry($_POST);
			header("Location: " . $_SERVER["PHP_SELF"]);
		} else {
			$data["model"] = $_POST;
			$data["model"]['userBirthdate'] = implode(".", array_reverse(explode("-", $data["model"]['userBirthdate'])));
			$user->displayTemplate("promoshop", 'user_form', $data);
		}
		break;
	case 'edit':
		$data["model"] = $model->getEntry($_SESSION["userId"]);
		$data["model"]['userTcknNew'] = $data["model"]['userTckn'];
		$data["model"]['userEmailNew'] = $data["model"]['userEmail'];
		$data["model"]['userNameNew'] = $data["model"]['userName'];
		$data["model"]['userBirthdate'] = implode(".", array_reverse(explode("-", $data["model"]['userBirthdate'])));
		//print_r($data);exit;
		
		$model->displayTemplate("promoshop", "user_form", $data);
		break;
	case 'view':
	default:
		$data = $model->getEntry($_SESSION["userId"]);
		$data['userBirthdate'] = implode(".", array_reverse(explode("-", trim($data['userBirthdate']))));
		$model->displayTemplate("promoshop", "user_show", $data);
		break;
}