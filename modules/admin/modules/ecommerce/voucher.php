<?php
require_once dirname(__FILE__) . '/../../../../classes/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Voucher();

switch($_action) {
	case 'dataTables':
		echo $model->dataTables($model->aAllField, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'generate':
		$voucherId = $_POST["voucherId"];
		$voucherQuantity = $_POST["voucherQuantity"];
		
		$casstring = new CasString();
		for ($i = 1; $i <= $voucherQuantity; $i++) {
			$code = $casstring->randomUniqueString();
			$model->insert("vouchercode", array(
				"voucherId"=>$voucherId,
				"voucherCode"=>$code
			));
		}
		header("Location: " . $_SERVER["PHP_SELF"] . "?action=edit&voucherId=" . $voucherId);
		break;
	case 'delete':
		$model->removeEntry($_REQUEST[$model->sIndexColumn]);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'save':
		$model->saveEntry($_POST);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'edit':
		$data["model"] = $model->getEntry($_REQUEST[$model->sIndexColumn]);
		$data["vouchercode"] = $model->getVouchercodeByVoucherId($_REQUEST[$model->sIndexColumn]);
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