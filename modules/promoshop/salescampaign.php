<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

Permission::checkPermissionRedirect("promoshop");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Salescampaign;

switch($_action)
{
	case 'view':
	default:
		$salescampaignId = $_GET["salescampaignId"];
		if ($salescampaignId == null) header("Location: " . PROJECT_URL . "modules/promoshop/");
		$data = $model->getSalescampaign($salescampaignId);
		//print_r($data);exit;
		
		$model->displayTemplate("promoshop", "salescampaign", $data);
		break;
}