<?php
require_once dirname(__FILE__) . '/../../classes/config.inc.php';
require_once dirname(__FILE__) . '/__master__.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Page();

switch($_action)
{
	case 'jsonPage':
		$id = isset($_GET[$model->sIndexColumn])?$_GET[$model->sIndexColumn]:null;
		echo(json_encode($model->arrayPage(false, $id)));
		break;
		
	case 'view':
	default:
		$page = $model->getDefaultPage();
		$data["page"] = $page;
		//print_r($data);exit;
		
		$usertrack = new Usertrack();
		$usertrack->addTrack(4, "pageId=" . $page["pageId"]);
		
		if ($page["pageRedirect"]!="") {
			header("Location: " . _MODULE_DIR_ . $page["pageRedirect"] . "/index.php");
		}
		else {
			$model->displayTemplate("b2c", "page", $data);
		}
		break;
}