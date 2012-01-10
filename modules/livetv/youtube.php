<?php
require_once(dirname(__FILE__) . '/../../config/config.inc.php');

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Livetv();

switch($_action)
{
	case 'jsonLivetvs':
		$data = $model->getEntries();
		//print_r($data);exit;
		echo(json_encode($data));
		break;
	case 'view':
	default:
		$model->displayTemplate("casict", "youtube");
		break;
}