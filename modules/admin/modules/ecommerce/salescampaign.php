<?php
require_once dirname(__FILE__) . '/../../../../config/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Salescampaign;

switch($_action)
{
	case 'setDefaultPicture':
		$model->setDefaultPicture($_REQUEST[$model->sIndexColumn], $_REQUEST["pictureId"]);
		header("Location: " . $_SERVER["HTTP_REFERER"]);
		break;
	case 'uploadPictures':
		$formvars = array_merge($_POST, $_FILES);
		$model->saveFiles($formvars);
		header("Location: " . $_SERVER["HTTP_REFERER"]);
		break;
	case '________deletePictures':
		$picture = new Picture;
		$picture->removeEntriesByProductId($_REQUEST["productId"]);
		header("Location: " . $_SERVER["HTTP_REFERER"]);
		break;
	case 'deletePicture':
		$model->unlinkPicture($_REQUEST["pictureId"]);
		header("Location: " . $_SERVER["HTTP_REFERER"]);
		break;
	case 'ajaxSaveSalescampaign':
		$id = $model->saveSalescampaign($_POST);
		echo(json_encode(array($model->sIndexColumn=>$id)));
		break;
	case 'ajaxDeleteSalescampaign':
		$model->removeEntry($_REQUEST[$model->sIndexColumn]);
		break;
	case 'jsonProductattributes':
		$productattribute = new Productattribute;
		echo($productattribute->getProductattributes($_GET));
		break;
		
		
	case 'delete':
		$model->removeEntry($_REQUEST[$model->sIndexColumn], true);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'save':
		$formvars = array_merge($_POST, $_FILES);
		$model->saveEntry($formvars, array("picture"=>array("resize"=>array(720, 300), "isDefault"=>true)));
		$model->delete("salescampaign_productattribute", "salescampaignId = :salescampaignId", array("salescampaignId"=>$_POST[$model->sIndexColumn]));
		foreach ($_POST["productattributeId"] as $productattributeId) {
			$model->insert("salescampaign_productattribute", array("salescampaignId"=>$_POST[$model->sIndexColumn], "productattributeId"=>$productattributeId));
		}
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'edit':
		$data["model"] = $model->getSalescampaign($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;
		$productattribute = new Productattribute;
		$data["productattribute"] = $productattribute->getEntries();
		//print_r($data);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'new':
		$productattribute = new Productattribute;
		$data["productattribute"] = $productattribute->getEntries();
		//print_r($data);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'dataTables':
		echo $model->dataTables($model->aAllField, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'view':
	default:
		$model->displayTemplate("admin", $model->sTable.'_list');
		break;
}