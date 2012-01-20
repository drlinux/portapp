<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

/*
 echo($_SERVER['HTTP_USER_AGENT']);exit;
Mozilla/5.0 (Windows NT 6.1) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.100 Safari/534.30
Mozilla/5.0 (Windows NT 6.1; rv:5.0) Gecko/20100101 Firefox/5.0
Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0)
Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; SLCC2; .NET CLR 2.0.50727; InfoPath.3; .NET4.0C; Tablet PC 2.0)
*/

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new User();

switch($_action)
{
	case 'changeLanguage':
		if(isset($_GET['language'])) {
			$_SESSION["PROJECT_LANGUAGE"] = $_GET['language'];
		}

		if(isset($_GET["uri"])) {
			$URI = urldecode($_GET['uri']);
		}
		else {
			$URI = $project['url'] . "modules/admin/";
		}

		header("Location: " . $URI);
		break;
	case 'breadcrumbsIso639':
		$iso639 = new Iso639;
		echo(json_encode($iso639->getEntries(false, false, "iso639Status = true")));
		break;
	case 'breadcrumbsMenu':
		Permission::checkPermissionRedirect();
		$permission = new Permission;
		echo($permission->jsonTree(38)); // TODO: Bu numara (38) permission tablosundaki ADMIN ana menüye ait.
		break;


	case 'jsonProductorder':
		Permission::checkPermissionRedirect();
		$productorder = new Productorder;
		echo(json_encode($productorder->getEntries()));
		break;
	case 'jsonUserticket':
		Permission::checkPermissionRedirect();
		$userticket = new Userticket;
		echo(json_encode($userticket->getEntries()));
		break;
	case 'jsonUsertrack':
		Permission::checkPermissionRedirect();
		$usertrack = new Usertrack;
		echo(json_encode($usertrack->getEntries()));
		break;


	case 'checkAuthenticated':
		echo(json_encode(array("authenticated"=>Permission::checkPermission("b2c"))));
		break;
	case 'loginUser':
		echo(json_encode(array("success"=>$model->authenticate($_POST), "uri"=>$_POST["uri"], "msg"=>$model->msg)));
		break;
	case 'login':
		if (isset($_SESSION["userId"])) header("Location: " . $project['url'] . "modules/admin/");
		$model->displayTemplate("admin", "login_form", $_REQUEST);
		break;
	case 'logout':
		$usertrack = new Usertrack();
		$usertrack->addTrack(2);
		$language = $_SESSION["PROJECT_LANGUAGE"];
		$_SESSION = array();
		session_destroy();
		session_start();
		$_SESSION["PROJECT_LANGUAGE"] = $language;
		header("Location: " . $project['url'] . "modules/admin/");
		break;


	case 'submit':
		$model->mungeFormData($_POST);
		if($model->isValidForm($_POST) && $model->authenticate($_POST)) {
			if (!isset($_POST["uri"]) || $_POST["uri"]=="") {
				$redir = $project['url'] . "modules/admin/";
			}
			else {
				$redir = $_POST["uri"];
			}
			header("Location: $redir");

		} else {
			$data["username"] = $_POST["username"];
			$data["password"] = $_POST["password"];
			$data["uri"] = $_POST["uri"];
			$model->displayTemplate("admin", "login_form", $data);
		}
		break;
	case 'view':
	default:
		Permission::checkPermissionRedirect();
		$model->displayTemplate("admin", "index");
		break;
}