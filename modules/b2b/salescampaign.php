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
		$campaign = $model->getSalescampaign($salescampaignId);
		
		if ($salescampaignId == null) 
		{
			header("Location: " . $project['url'] . "modules/b2b/");
		}
		
		$LABEL_DAY = $smarty->getConfigVariable("LABEL_DAY");
		$LABEL_HOUR = $smarty->getConfigVariable("LABEL_HOUR");
		$LABEL_MINUTE = $smarty->getConfigVariable("LABEL_MINUTE");
		$LABEL_SECOND = $smarty->getConfigVariable("LABEL_SECOND");
		$LABEL_REMAINED = $smarty->getConfigVariable("LABEL_REMAINED");
		
		$remaining = strtotime($campaign["salescampaignEnd"]) - time();
			
		$day = intval($campaign["DifDayCount"], "10");
		$hour = intval(date("G", $remaining), "10");
		$minute = intval(date("i", $remaining), "10");
		$second = intval(date("s", $remaining), "10");
			
		$remainingText  = $day > 0 ? "$day $LABEL_DAY, " : "";
		$remainingText .= $hour > 0 ? "$hour $LABEL_HOUR, " : "";
		$remainingText .= $minute > 0 ? "$minute $LABEL_MINUTE,  " : "";
		$remainingText .= $second > 0 ? "$second $LABEL_SECOND  " : "";
		$remainingText .= " $LABEL_REMAINED";
		$data["remainingText"] = $remainingText;
		
		$data = array_merge($data, $campaign);
		//print_r($data);exit;
		
		$model->displayTemplate("b2b", "salescampaign_show", $data);
		break;
	case 'view':
	default:
		$data["campaigns"] = $model->getSalescampaigns();
		
		$model->displayTemplate("b2b", "salescampaign", $data);
		break;
}