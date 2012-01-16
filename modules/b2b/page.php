<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

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
		$data = $model->getDefaultPage();
		//print_r($data);exit;
		
		$usertrack = new Usertrack();
		$usertrack->addTrack(4, "pageId=" . $data["pageId"]);
		
		//foreach ($g_project->retrieveModules() as $k=>$v) {
		//if ($row["pageRedirect"]==$k) {header("Location: modules/$k/index.php");exit();}
		//}
		if ($data["pageRedirect"]!="") {
			header("Location: " . _MODULE_DIR_ . $data["pageRedirect"] . "/index.php");
		}
		else {
			$model->displayTemplate("b2b", "page", $data);
		}
		break;
}