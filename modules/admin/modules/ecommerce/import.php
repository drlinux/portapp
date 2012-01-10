<?php
require_once dirname(__FILE__) . '/../../../../config/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Product;

switch($_action)
{
	case 'import':
		if ($fileInfo = $model->uploadFile(
			array(
				"multipart"=>$_FILES["xmlFile"],
				"uploadTo"=>_PS_IMG_DIR_."xml/",
				"fileType"=>array("text/xml", "application/xml")
			)
		))
		{
			$model->importXml(_PS_IMG_DIR_ . "xml/" . $fileInfo["fileNameWithExtension"]);
			header("Location: " . $_SERVER["PHP_SELF"]);
		}
		else {
			trigger_error("Hata oluştu: Dosya yüklenemedi");
		}
		break;
	case 'view':
	default:
		$model->displayTemplate("admin", "import_form");
		break;
}