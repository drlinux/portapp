<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

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
			$URI = _MODULE_DIR_ . "b2c/";
		}

		header("Location: " . $URI);
		break;
	case 'breadcrumbsIso639':
		$iso639 = new Iso639;
		echo(json_encode($iso639->getEntries(false, false, "iso639Status = true")));
		break;
	case 'breadcrumbsMenu':
		Permission::checkPermissionRedirect("b2c");
		$permission = new Permission;
		echo($permission->jsonTree(32)); // TODO: Bu numara (32) permission tablosundaki B2C ana menüye ait.
		break;


	case 'checkAuthenticated':
		echo(json_encode(array("authenticated"=>Permission::checkPermission("b2c"))));
		break;
	case 'loginUser':
		echo(json_encode(array("success"=>$model->authenticate($_POST), "uri"=>$_POST["uri"], "msg"=>$model->msg)));
		break;
	case 'login':
		if (isset($_SESSION["userId"])) header("Location: " . _MODULE_DIR_ . "b2c/");
		$model->displayTemplate("b2c", "login_form", $_REQUEST);
		break;
	case 'logout':
		Permission::checkPermissionRedirect("b2c");
		$usertrack = new Usertrack();
		$usertrack->addTrack(2);
		$language = $_SESSION["PROJECT_LANGUAGE"];
		$_SESSION = array();
		session_destroy();
		session_start();
		$_SESSION["PROJECT_LANGUAGE"] = $language;
		header("Location: " . _MODULE_DIR_ . "b2c/");
		break;
		
		

	case 'jsonBanners':
		$banner = new Banner();
		echo(json_encode($banner->getBanners()));
		break;
	case 'jsonBrandsFromProductHavingPicture':
		$brand = new Brand();
		echo(json_encode($brand->getBrandsFromProductHavingPicture()));
		break;
	case 'jsonCategoriesFromProductHavingPicture':
		$category = new Category();
		echo(json_encode($category->getCategoriesFromProductHavingPicture()));
		break;
	case 'jsonAttributegroupsWithAttributes':
		$attributegroup = new Attributegroup();
		echo(json_encode($attributegroup->getAttributegroupsWithAttributes()));
		break;
		
		
		
	case 'jsonProductgroups':
		$productgroup = new Productgroup;
		echo(json_encode($productgroup->getEntries(array("i18n"=>true))));
		break;
	case 'jsonProductattributes':
		$productattribute = new Productattribute;
		echo($productattribute->getProductattributes($_GET));
		break;
		
		
	case 'view':
	default:
		$model->displayTemplate("b2c", "index");
		break;
}