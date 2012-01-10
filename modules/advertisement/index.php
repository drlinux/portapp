<?php
require_once dirname(__FILE__) . '/../../config/config.inc.php';

$_action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'view';

$model = new Advertisement;

switch($_action)
{
	case 'sendMessaging':
		$messaging = new Messaging();
		$messaging->insert($messaging->sTable, array(
			"messagingFrom"=>$_SESSION["userId"],
			"messagingTo"=>$_POST["messagingTo"],
			"messagingContent"=>$_POST["messagingContent"]
		));
		
		$mid = $messaging->run("select LAST_INSERT_ID() as last_insert_id;");
		$messagingId = $mid[0]["last_insert_id"];
		
		$messaging->insert("messaging_user_messagingstatus", array(
		"messagingId"=>$messagingId,
		"userId"=>$_SESSION["userId"],
		"messagingstatusId"=>1,
		"messagingstatusDatetime"=>date("Y-m-d H:i:s")
		));
		
		$messaging->insert("messaging_user_messagingstatus", array(
		"messagingId"=>$messagingId,
		"userId"=>$_POST["messagingTo"],
		"messagingstatusId"=>2,
		"messagingstatusDatetime"=>date("Y-m-d H:i:s")
		));
		
		echo(json_encode(array("success"=>true)));
		break;
		
	case 'deleteAdvertisement':
		$model = new Advertisement();
		$model->removeEntry($_REQUEST[$model->sIndexColumn]);
		echo(json_encode(array("success"=>true)));
		break;
		
		
		
	
	case 'saveSearch':
		$model->insert("advertisementsearch", array(
			"advertisementsearchQuery"=>$_POST["q"],
			"advertisementsearchDatetime"=>date("Y-m-d H:i:s")
		));
		$success = true;
		echo(json_encode(array("success"=>$success)));
		break;
	case 'setInappropriate':
		if (isset($_SESSION["userId"])) {
			if ($model->insert("advertisement_flag_user", array(
				"advertisementId"=>$_POST["advertisementId"],
				"flagId"=>1,
				"userId"=>$_SESSION["userId"],
				"datetime"=>date("Y-m-d H:i:s")
			))) {
				$success = true;
				echo(json_encode(array("success"=>$success)));
			}
			else {
				$success = false;
				$msg = "Already flagged as inappropriate";
				echo(json_encode(array("success"=>$success, "msg"=>$msg)));
			}
		}
		else {
			$success = false;
			$msg = "Please login first";
			echo(json_encode(array("success"=>$success, "msg"=>$msg)));
		}
		break;
	case 'saveUser':
		$rows = $model->select("user", "userId = :userId", array("userId"=>$_SESSION["userId"]));
		if ($rows[0]["userEmail"] != $_POST["userEmail"]) {
			$rows = $model->select("user", "userEmail = :userEmail", array("userEmail"=>$_POST["userEmail"]));
			if ($rows) {
				echo(json_encode(array("isExist"=>true)));
			}
			else {
				if ($_POST["userPass"] != null) {
					$sql = "UPDATE user SET userPass = SHA1('".$_POST["userPass"]."'), userName = '".$_POST["userEmail"]."', userEmail = '".$_POST["userEmail"]."', userFirstname = '".$_POST["userFirstname"]."', userCoordinate = GeomFromText('POINT(".$_POST["latitude"]." ".$_POST["longitude"].")') WHERE userId = " . $_SESSION["userId"];
				}
				else {
					$sql = "UPDATE user SET userName = '".$_POST["userEmail"]."', userEmail = '".$_POST["userEmail"]."', userFirstname = '".$_POST["userFirstname"]."', userCoordinate = GeomFromText('POINT(".$_POST["latitude"]." ".$_POST["longitude"].")') WHERE userId = " . $_SESSION["userId"];
				}
				$success = false;
				if ($model->run($sql)) {
					$success = true;
				}
				else {
					$msg = "No change";
				}
				echo(json_encode(array("success"=>$success, "msg"=>$msg)));
			}
		}
		else {
			if ($_POST["userPass"] != null) {
				$sql = "UPDATE user SET userPass = SHA1('".$_POST["userPass"]."'), userFirstname = '".$_POST["userFirstname"]."', userCoordinate = GeomFromText('POINT(".$_POST["latitude"]." ".$_POST["longitude"].")') WHERE userId = " . $_SESSION["userId"];
			}
			else {
				$sql = "UPDATE user SET userFirstname = '".$_POST["userFirstname"]."', userCoordinate = GeomFromText('POINT(".$_POST["latitude"]." ".$_POST["longitude"].")') WHERE userId = " . $_SESSION["userId"];
			}
			$success = false;
			if ($model->run($sql)) {
				$success = true;
			}
			else {
				$msg = "No change";
			}
			echo(json_encode(array("success"=>$success, "msg"=>$msg)));
		}
		break;
	case 'getAdvertisementgroups':
		$advertisementgroup = new Advertisementgroup();
		$data = $advertisementgroup->getEntries();
		echo(json_encode($data));
		//echo(json_encode(array("success"=>true)));
		break;
	case 'resetmypassword':
		$rows = $model->select("user", "userEmail = :userEmail", array("userEmail"=>$_POST["userEmail"]));
		if ($rows) {
			$userPass = CasString::randomStringGenerator();
			$model->update("user", array("userPass"=>sha1($userPass)), "userEmail = :userEmail", array("userEmail"=>$_POST["userEmail"]));
				
			$mailer = new CasMailer();
			$mailer->Subject = $smarty->getConfigVariable("MAIL_SUBJECT_USERREMINDER");
			$mailer->MsgHTML(sprintf($smarty->getConfigVariable("MAIL_BODY_USERREMINDER"), $_POST["userEmail"], $userPass));
			$mailer->AddAddress($_POST["userEmail"]);
			if($mailer->Send())
			{
				echo(json_encode(array("success"=>true)));
				return true;
			}
			else
			{
				echo(json_encode(array("msg"=>"mailer_error")));
				return false;
			}

		}
		else {
			echo(json_encode(array("isExist"=>false)));
		}
		break;
	case 'register':
		$rows = $model->select("user", "userEmail = :userEmail", array("userEmail"=>$_POST["userEmail"]));
		if ($rows) {
			echo(json_encode(array("isExist"=>true)));
		}
		else {
			//echo(json_encode(array("isExist"=>false)));
			$userPass = CasString::randomStringGenerator();
				
			$sql = "INSERT INTO user (userName, userPass, userEmail, userFirstname, userCoordinate) VALUES ('".$_POST["userEmail"]."', '".sha1($userPass)."', '".$_POST["userEmail"]."', '".$_POST["userFirstname"]."', GeomFromText('POINT(".$_POST["latitude"]." ".$_POST["longitude"].")')) ";
				
			if ($model->run($sql))
			{

				$lid = $model->run("select LAST_INSERT_ID() as last_insert_id;");
				$userId = $lid[0]["last_insert_id"];

				$model->insert(
					"user_role",
					array(
						"userId"=>$userId,
						"roleId"=>_ROLE_B2C
					)
				);


				$mailer = new CasMailer();
				$mailer->Subject = $smarty->getConfigVariable("MAIL_SUBJECT_USERREGISTER");
				$mailer->MsgHTML(sprintf($smarty->getConfigVariable("MAIL_BODY_USERREGISTER"), $_POST["userEmail"], $userPass));
				$mailer->AddAddress($_POST["userEmail"], $_POST["userFirstname"] , '');
				if($mailer->Send())
				{
					echo(json_encode(array("success"=>true)));
					return true;
				}
				else
				{
					echo(json_encode(array("msg"=>"mailer_error")));
					return false;
				}

			}
			else {
				echo(json_encode(array("msg"=>"save_error")));
			}
		}
		break;
	case 'checkAuthenticated':
		echo(json_encode(array("authenticated"=>($_SESSION["userId"])?true:false)));
		//echo(json_encode(array("authenticated"=>Permission::checkPermission("b2c"))));
		break;
	case 'showMessaging':
		$messaging = new Messaging();
		$data = $messaging->getMessagingByMessagingId($_REQUEST[$messaging->sIndexColumn]);
		echo(json_encode($data));
		break;
	case 'showAdvertisement':
		//$data = $model->getEntry($_REQUEST[$model->sIndexColumn], array("picture"=>true));
		$data = $model->getAdvertisementByAdvertisementId($_REQUEST[$model->sIndexColumn]);
		echo(json_encode($data));
		break;
	case 'content':
		$_source = isset($_REQUEST['source']) ? $_REQUEST['source'] : 'default';
		echo $smarty->fetch($_source.".tpl");
		break;
	case 'getUserByUserId':
		$rows = $model->select("user", "userId = :userId", array("userId"=>$_SESSION["userId"]), "*, X(userCoordinate) as latitude, Y(userCoordinate) as longitude");
		echo(json_encode($rows[0]));
		break;
	case 'getMessagesByUserId':
		$sql = "select messaging.* from messaging where messagingTo = :messagingTo ";
		$rows = $model->run($sql, array("messagingTo"=>$_SESSION["userId"]));
		$arr["iTotalRecords"] = count($rows);
		if ($arr["iTotalRecords"] > 0) {
			$i=0;
			foreach ($rows as $row) {
				$arr["aaData"][$i] = $row;
				$i++;
			}
		}
		echo(json_encode($arr));
		break;
	case 'getAdvertisementsByUserId':
		echo(json_encode($model->getEntries(array("picture"=>array("isDefault"=>true)), "userId = :userId", array("userId"=>$_SESSION["userId"]))));
		break;
	case 'search':
		//echo(json_encode($model->searchAdvertisements($_GET["q"])));
		echo(json_encode($model->getEntries(array("picture"=>array("isDefault"=>true)), "advertisementContent LIKE '%".$_GET["q"]."%'")));
		break;
	case 'save':
		$formvars = array_merge($_POST, $_FILES);
		$formvars["userId"] = $_SESSION["userId"];
		$advertisementId = $model->saveEntry($formvars, array("picture"=>array("resize"=>array(480, 360), "isDefault"=>true)));
		echo(json_encode(array("success"=>$formvars, "advertisementId"=>$advertisementId)));
		break;
	case 'logout':
		$language = $_SESSION["PROJECT_LANGUAGE"];
		$_SESSION = array();
		session_destroy();
		session_start();
		$_SESSION["PROJECT_LANGUAGE"] = $language;
		header("Location: " . $_SERVER["PHP_SELF"]);
		break;
	case 'login':
		$userLogin = new User();
		echo(json_encode(array("authenticated"=>$userLogin->authenticate($_POST), "uri"=>$_POST["uri"])));
		break;
	case 'view':
	default:
		$model->displayTemplate("advertisement", "index");
		break;
}