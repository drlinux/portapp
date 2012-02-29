<?php
require_once dirname(__FILE__) . '/../../../../classes/config.inc.php';

Permission::checkPermissionRedirect();

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Survey;

switch($_action)
{
	case 'deleteSurvey':
		$_table = $_POST["table"];
		$_id = $_POST["id"];
		$model->delete($_table, $_table."Id = :id", array("id"=>$_id));
		echo(json_encode(array("success"=>true)));
		break;
	case 'saveSurvey':
		$id = explode("_", $_POST["id"]);
		$_table = $_POST["table"];//$id[0];
		$_id = $_POST["id"];//$id[1];
		$_value = $_POST["value"];
		
		if ($_id > 0) {
			$model->update($_table, array($_table."Title"=>$_value), $_table."Id = :id", array("id"=>$_id));
		}
		else {
			if ($_table == "surveyq") {
				$model->insert($_table, array($_table."Title"=>$_value, "surveyId"=>$_POST["surveyId"]));
			}
			elseif ($_table == "surveya") {
				$model->insert($_table, array($_table."Title"=>$_value, "surveyqId"=>$_POST["surveyqId"]));
			}
		}
		echo(json_encode($_POST));
		break;
	case 'jsonSurvey':
		echo(json_encode($model->getSurvey($_REQUEST[$model->sIndexColumn])));
		break;
	case 'dataTables':
		$aColumns = array("surveyId", "surveyTitle", "surveyStart", "surveyEnd");
		echo $model->dataTables($aColumns, $model->sIndexColumn, $model->sTable, $_GET);
		break;
	case 'delete':
		$model->removeEntry($_REQUEST[$model->sIndexColumn]);
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'save':
		$model->mungeFormData($_POST);
		if($model->isValidForm($_POST)) {
			$model->saveEntry($_POST);
			header("Location: " . $_SERVER["PHP_SELF"]);
		} else {
			$model->displayTemplate("admin", $model->sTable.'_form', $_POST);
		}
		break;
	case 'edit':
		$data = $model->getEntry($_REQUEST[$model->sIndexColumn]);
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