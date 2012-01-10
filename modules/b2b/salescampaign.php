<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

Permission::checkPermissionRedirect("b2b");

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Salescampaign;

switch($_action)
{
	case 'jsonSalescampaigns':
		echo(json_encode($model->getSalescampaigns()));
		break;
	case 'show':
		$salescampaignId = $_REQUEST[$model->sIndexColumn];
		if ($salescampaignId == null) header("Location: " . PROJECT_URL . "modules/b2b/");
		$data = $model->getSalescampaign($salescampaignId);
		//print_r($data);exit;
		
		$model->displayTemplate("b2b", "salescampaign_show", $data);
		break;
	case 'view':
	default:
		$model->displayTemplate("b2b", "salescampaign");
		break;
}