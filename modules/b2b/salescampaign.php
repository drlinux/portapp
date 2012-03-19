<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

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
		if ($salescampaignId == null) header("Location: " . $project['url'] . "modules/b2b/");
		$data = array_merge($data, $model->getSalescampaign($salescampaignId));
		//print_r($data);exit;
		
		$model->displayTemplate("b2b", "salescampaign_show", $data);
		break;
	case 'view':
	default:
		$data["campaigns"] = $model->getSalescampaigns();
		
		$model->displayTemplate("b2b", "salescampaign", $data);
		break;
}