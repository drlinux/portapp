<?php
require_once dirname(__FILE__) . '/../../../../config/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Paymentgroup();

switch($_action) {
	case 'dataTables':
		$aColumns = array("paymentgroupId", "paymentgroupTitle", "paymentgroupSorting", "paymentgroupStatus");
		echo $model->dataTables($aColumns, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'saveTransportation':
		$model->delete("paymentgroup_transportation", $model->sIndexColumn." = :id", array("id"=>$_REQUEST[$model->sIndexColumn]));
		foreach ($_POST["transportationId"] as $transportationId) {
			$model->insert("paymentgroup_transportation", array($model->sIndexColumn=>$_REQUEST[$model->sIndexColumn], "transportationId"=>$transportationId));
		}
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'deletePayment':
		$payment = new Payment;
		$payment->removeEntry($_REQUEST[$payment->sIndexColumn]);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'savePayment':
		$paymentgroupId = $_POST["paymentgroupId"];
		$paymentPeriod = $_POST["paymentPeriod"];
		$paymentimpactWeight = $_POST["paymentimpactWeight"];
		$payment = new Payment;
		if ($p = $payment->isExistByPaymentgroupIdAndPaymentPeriod($paymentgroupId, $paymentPeriod)) {
			$_POST["paymentId"] = $p["paymentId"];
		}
		$payment->saveEntry($_POST);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'delete':
		$model->removeEntry($_REQUEST[$model->sIndexColumn]);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'save':
		$formvars = array_merge($_POST, $_FILES);
		//$model->mungeFormData($formvars);
		//if($model->isValidForm($formvars)) {
			$model->saveEntry($formvars, array("i18n"=>true, "picture"=>array("isDefault"=>true)));
			header("Location: " . $_SERVER["PHP_SELF"]);
		//} else {
			//$model->displayTemplate("admin", $model->sTable.'_form', $formvars);
		//}
		break;
	case 'edit':
		$data["model"] = $model->getPaymentgroup($_REQUEST[$model->sIndexColumn]);
		$data["i18n"] = $model->getEntryWithLanguages($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;
		
		$bank = new Bank();
		$data["bank"] = $bank->getEntries();
		//print_r($data);exit;
		
		$transportation = new Transportation;
		$data["transportation"] = $transportation->getEntries(array("i18n"=>true));
		//print_r($data);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'new':
		$data["i18n"] = $model->getEntryWithLanguages($_REQUEST[$model->sIndexColumn]);
		//print_r($data);exit;
		
		$model->displayTemplate("admin", $model->sTable.'_form', $data);
		break;
	case 'view':
	default:
		$model->displayTemplate("admin", $model->sTable.'_list');
		break;
}