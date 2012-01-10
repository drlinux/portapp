<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Survey;

switch($_action)
{
	case 'voteSurvey':
		foreach ($_POST["surveyq"] as $surveyqId=>$surveyaId) {
			$model->insert("surveyr", array(
				"userId"=>$_SESSION["userId"],
				"surveyId"=>$_POST["surveyId"],
				"surveyqId"=>$surveyqId,
				"surveyaId"=>$surveyaId,
				"surveyrDatetime"=>date("Y-m-d H:i:s")
			));
		}
		echo(json_encode(array("success"=>true)));
		break;
	case 'jsonSurvey':
		echo(json_encode($model->getSurvey($_REQUEST[$model->sIndexColumn])));
		break;
	case 'view':
	default:
		$data["surveyId"] = 2;
		$model->displayTemplate("casict", "index", $data);
		break;
}