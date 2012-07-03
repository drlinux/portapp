<?php
require_once dirname(__FILE__) . '/../../../../classes/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new User;

switch($_action)
{
	case 'updatePersonalInfo':
		$user = new User();
		$user->mungeFormData($_POST);
		if ($success = $user->updatePersonalInfo($_POST)) {
			echo(json_encode(array("success"=>$success, "msg"=>$user->msg, "field"=>$user->field)));
		}
		break;
		
	case 'saveCompany':
		$company = new Company;
		if($success = $company->updateCompany($_POST["companyId"], $_POST))
		{
			echo(json_encode(array("success"=>$success, "msg"=>$company->msg, "field"=>$company->field)));
		}
		else
		{
			echo(json_encode(array("success"=>$success, "msg"=>$company->msg, "field"=>$company->field)));
		}
		
	break;
	
	case 'dataTables':
		$aColumns = array( 'userId', 'userFirstname', 'userLastname', 'userEmail', 'userTckn' );
		echo $model->dataTables($aColumns, $model->sIndexColumn, $model->sTable, $_GET);
		break;
/*	case 'saveRole':
		$model->delete("user_role", $model->sIndexColumn." = :id", array("id"=>$_REQUEST[$model->sIndexColumn]));
		foreach ($_POST["roleId"] as $roleId) {
			$model->insert("user_role", array($model->sIndexColumn=>$_REQUEST[$model->sIndexColumn], "roleId"=>$roleId));
		}
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;*/

	case 'updateAccountInfo':
		$user = new User();
		if ($success = $user->updateAccountInfo($_POST)) {
			echo(json_encode(array("success"=>$success, "msg"=>$user->msg, "field"=>$user->field)));
		}
		break;
	
	case 'save':
		$model->mungeFormData($_POST);
		if($model->isValidForm($_POST)) {
			$model->saveEntry($_POST);
			header("Location: " . $_SERVER["PHP_SELF"]);
		} else {
			$data["model"] = $_POST;
			//$data["model"]['userBirthdate'] = implode("/", array_reverse(explode("-", $data["model"]['userBirthdate'])));
			$model->displayTemplate("admin", $model->sTable.'_form', $data);
		}
		break;
	case 'edit':
		if($data["model"] = $model->getEntry($_REQUEST[$model->sIndexColumn]))
		{
			$data["model"]['userTcknNew'] = $data["model"]['userTckn'];
			$data["model"]['userEmailNew'] = $data["model"]['userEmail'];
			$data["model"]['userNameNew'] = $data["model"]['userName'];
			//$data["model"]['userBirthdate'] = implode("/", array_reverse(explode("-", $data["model"]['userBirthdate'])));
			//print_r($data);exit;
			
			
			$Company = new Company;
			
			$data["company"] = $Company->selectCompanyByUserId($_REQUEST[$model->sIndexColumn]);
			
			
			$role = new Role;
			$data["role"] = $role->getEntries();
			$isB2B = "false";
			
			foreach($data["role"] as $roleId)
			{
				if($roleId === 4)
					$isB2B = "true";
			}
			
			$data["isB2B"] = $isB2B;
			
			$model->displayTemplate("admin", $model->sTable.'_form', $data);
		}
		else
		{
			header("Location:user.php");
		}
		break;
	case 'new':
		$model->displayTemplate("admin", $model->sTable.'_form');
		break;
	case "deleteUser":
		if($model->deleteUser($_POST["userId"]))
			echo json_encode(array("error"=>false));
		else
			echo json_encode(array("error"=>false, "msg"=>"Hata Oluştu"));
		exit;
	case 'view':
	default:
		$model->displayTemplate("admin", $model->sTable.'_list');
		break;
}