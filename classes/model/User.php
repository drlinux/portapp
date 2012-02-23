<?php
class User extends CasBase
{

	function __construct()
	{
		parent::__construct();

		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("userId", "userStatus", "userName", "userPass", "userEmail", "userFirstname", "userLastname", "userBirthdate", "userGender", "userPhone", "userTckn"/*, "userCoordinate"*/);
		$this->sIndexColumn		= "userId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;

		$this->sTitleColumn		= $this->sTable."Name";
		$this->sTitleColumnFull	= $this->sTable.".".$this->sTitleColumn;

	}

	function getEntry($id)
	{
		$rows = $this->select($this->sTable, $this->sIndexColumn . " = :id", array("id"=>$id));
		$row = $rows[0];
		$row["role"] = $this->getRoles($row[$this->sIndexColumn]);
		return ($row);
	}

	function getUsers()
	{
		$rows = $this->select($this->sTable);
		$arr["iTotalRecords"] = count($rows);
		if ($arr["iTotalRecords"] > 0) {
			$i=0;
			foreach ($rows as $row) {
				$arr["aaData"][$i] = $row;
				$arr["options"][$row[$this->sIndexColumn]] = $row[$this->sTitleColumn];
				$i++;
			}
		}
		return ($arr);
	}
	
	function getRoles($userId=null)
	{
		if ($userId == null) return null;

		$sql = array();
		array_push($sql, "select *");
		array_push($sql, "from user_role");
		array_push($sql, "left join role on role.roleId = user_role.roleId");
		if ($userId != null) {
			array_push($sql, "where user_role.userId = " .$userId);
		}
		$sql = implode(" ", $sql);
		//echo($sql);exit;

		//$rows = $this->run($sql, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"]));
		$rows = $this->run($sql);
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			$arr["options"][$row["roleId"]] = $row["roleTitle"];
			$arr["selected"][] = $row["roleId"];
			$i++;
		}
		return ($arr);
	}

	function isExistByUsernameAndPassword($userName, $userPass)
	{
		//$rows = $this->select("user", "userName = :userName and userPass = :userPass", array("userName"=>$userName, "userPass"=>$userPass));

		$sQuery = "
			SELECT *
			FROM user
			LEFT JOIN user_role ON user_role.userId = user.userId
			WHERE userName = :userName
			AND userPass = :userPass
		";
		//echo($sQuery);exit;
		$rows = $this->run($sQuery, array("userName"=>$userName, "userPass"=>$userPass));
		$row = $rows[0];
		return $row;
	}

	public function isExistByUsername($userName, $current=null)
	{
		if ($current == null) {
			$rows = $this->select($this->sTable, "userName = :userName", array("userName"=>$userName));
		}
		else {
			$rows = $this->select($this->sTable, "userName = :userName and userName <> :current", array("userName"=>$userName, "current"=>$current));
		}
		$row = $rows[0];
		return $row;
	}

	public function isExistByEmail($email, $current=null)
	{
		if ($current == null) {
			$rows = $this->select($this->sTable, "userEmail = :userEmail", array("userEmail"=>$email));
		}
		else {
			$rows = $this->select($this->sTable, "userEmail = :userEmail and userEmail <> :current", array("userEmail"=>$email, "current"=>$current));
		}
		$row = $rows[0];
		return $row;
	}

	public function isExistByTckn($tckn, $current=null)
	{
		if ($current == null) {
			$rows = $this->select($this->sTable, "userTckn = :userTckn", array("userTckn"=>$tckn));
		}
		else {
			$rows = $this->select($this->sTable, "userTckn = :userTckn and userTckn <> :current", array("userTckn"=>$tckn, "current"=>$current));
		}
		$row = $rows[0];
		return $row;
	}


	function mungeFormData(&$formvars)
	{
		parent::mungeFormData($formvars);
		//$formvars['userBirthdate'] = implode("-", array_reverse(explode("/", $formvars['userBirthdate'])));
		$formvars['userPhone'] = implode("", explode("-", $formvars['userPhone']));
	}

	function isValidForm($formvars)
	{
		global $smarty;

		$new = array(
			"userTcknNew",
			"userEmailNew",
			"userNameNew"
		);

		$merged = array_merge($this->aAllField, $new);
		$diff = array_diff($merged, array($this->sIndexColumn, "userPass", "userName", "userEmail", "userTckn"));

		// check if empty
		/*
		foreach ($diff as $field) {
			if(strlen($formvars[$field]) == 0) {
				$this->msg = $smarty->getConfigVariable("ALERT_PleaseFillOutThisField");
				$this->field = $field;
				return false;
			}
		}
		*/

		// check others
		if (!CasString::isTckimlik($formvars["userTcknNew"])) {
			$this->msg = $smarty->getConfigVariable("ALERT_WrongTCKN");
			return false;
		}

		if ($this->isExistByTckn($formvars["userTcknNew"], $formvars["userTckn"])) {
			$this->msg = $smarty->getConfigVariable("ALERT_ExistTCKN");
			return false;
		}

		if (!CasMailer::ValidateAddress($formvars["userEmailNew"])) {
			$this->msg = $smarty->getConfigVariable("ALERT_PleaseEnterAValidEmailAddress");
			return false;
		}

		if ($this->isExistByEmail($formvars["userEmailNew"], $formvars["userEmail"])) {
			$this->msg = $smarty->getConfigVariable("ALERT_ExistEmail");
			return false;
		}

		if ($this->isExistByUsername($formvars["userNameNew"], $formvars["userName"])) {
			$this->msg = $smarty->getConfigVariable("ALERT_ExistUsername");
			return false;
		}

		// form passed validation
		return true;

	}

	function saveEntry($formvars)
	{
		$formvars2["userStatus"] = $formvars["userStatus"];
		$formvars2["userGender"] = $formvars["userGender"];
		$formvars2["userFirstname"] = $formvars["userFirstname"];
		$formvars2["userLastname"] = $formvars["userLastname"];
		$formvars2["userPhone"] = $formvars["userPhone"];
		//$formvars2["userBirthdate"] = implode("-", array_reverse(explode("/", $formvars["userBirthdate"])));
		$formvars2["userBirthdate"] = $formvars["userBirthdate"]["Date_Year"] . "-" . $formvars["userBirthdate"]["Date_Month"] . "-" . $formvars["userBirthdate"]["Date_Day"];
		
		if ($formvars["userTckn"] != $formvars["userTcknNew"]) {
			$formvars2["userTckn"] = $formvars["userTcknNew"];
		}
		if ($formvars["userEmail"] != $formvars["userEmailNew"]) {
			$formvars2["userEmail"] = $formvars["userEmailNew"];
		}
		if ($formvars["userName"] != $formvars["userNameNew"]) {
			$formvars2["userName"] = $formvars["userNameNew"];
		}
		if ($formvars["userPass"] != "") {
			$formvars2["userPass"] = sha1($formvars["userPass"]);
		}

		//print_r($formvars2);exit;


		$table = $this->sTable;
		$where = $this->sIndexColumn . " = :id";
		$bind = array("id"=>$formvars[$this->sIndexColumn]);

		if ($rows = $this->select($table, $where, $bind))
		{
			return $this->update($table, $formvars2, $where, $bind);
		}
		else
		{
			return $this->insert($table, $formvars2);
		}
	}


	function getDeliveryaddresses()
	{
		$sQuery = "
			SELECT postaladdress.*
			FROM user_deliveryaddress
			LEFT JOIN postaladdress ON postaladdress.postaladdressId = user_deliveryaddress.postaladdressId
			WHERE user_deliveryaddress.userId = :userId
		";
		$rows = $this->run($sQuery, array("userId"=>$_SESSION["userId"]));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			$i++;
		}
		return ($arr);
	}

	function getInvoiceaddresses()
	{
		$sQuery = "
			SELECT postaladdress.*
			FROM user_invoiceaddress
			LEFT JOIN postaladdress ON postaladdress.postaladdressId = user_invoiceaddress.postaladdressId
			WHERE user_invoiceaddress.userId = :userId
		";
		$rows = $this->run($sQuery, array("userId"=>$_SESSION["userId"]));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			$i++;
		}
		return ($arr);
	}

	// UserLogin
	public function authenticate($formvars)
	{
		global $smarty;

		if ($detail = $this->isExistByUsernameAndPassword($formvars['username'], sha1($formvars['password'])))
		{
			if ( $detail["userStatus"] == 0 ) {
				$this->msg = $smarty->getConfigVariable("ALERT_AccountIsNotActive");
				return false;
			}
			elseif ($_SESSION["permissionId"] = $this->fetchPermissionsByUserId($detail["userId"])) {
				$_SESSION["userId"] = $detail["userId"];
				$_SESSION["roleId"] = $detail["roleId"];

				// user tracking
				$usertrack = new Usertrack;
				$usertrack->addTrack();

				$this->msg = $smarty->getConfigVariable("ALERT_LoggedInSuccessfully");
				return true;
			}
			else {
				$this->msg = $smarty->getConfigVariable("ALERT_NoPermission");
				return false;
			}
		}
		else {
			$this->msg = $smarty->getConfigVariable("ALERT_AuthenticationFailed");
			return false;
		}
	}

	private function fetchPermissionsByUserId($userId)
	{
		$sql = "SELECT ";
		$sql .= "role_permission.permissionId ";
		$sql .= "FROM role_permission ";
		$sql .= "INNER JOIN user_role ON user_role.roleId = role_permission.roleId ";
		$sql .= "WHERE user_role.userId = :id ";

		if ($rows = $this->run($sql, array(":id" => $userId))) {
			foreach ($rows as $row) {
				$a[] = $row["permissionId"];
			}
			return array_unique($a);
		}
		else {
			return false;
		}
	}


	// UserReminder
	function isValidReminderForm($formvars)
	{
		global $smarty;

		// reset message
		$this->msg = null;

		$fields = array("userEmail");
		foreach ($fields as $field) {
			if(strlen($formvars[$field]) == 0) {
				$this->msg = $smarty->getConfigVariable("ALERT_Required");
				$this->field = $field;
				return false;
			}
		}

		// check others
		if (!CasMailer::ValidateAddress($formvars["userEmail"])) {
			$this->msg = $smarty->getConfigVariable("ALERT_EmailFormatError");
			return false;
		}

		if (!$this->isExistByEmail($formvars["userEmail"])) {
			$this->msg = $smarty->getConfigVariable("ALERT_EmailAddressDoesNotExist");
			return false;
		}

		// form passed validation
		return true;
	}

	function sendReminderForm($formvars)
	{
		global $smarty;

		$userEmail = $formvars["userEmail"];
		$detail = $this->isExistByEmail($userEmail);

		$usertrack = new Usertrack();
		$usertrack->addTrack(6, "userId=" . $detail["userId"]);

		$userPass = CasString::randomStringGenerator();
		$this->update($this->sTable, array("userPass"=>sha1($userPass)), "userEmail = :userEmail", array("userEmail"=>$userEmail));

		$mailer = new CasMailer();
		$mailer->Subject = $smarty->getConfigVariable("MAIL_SUBJECT_USERREMINDER");
		$mailer->MsgHTML(sprintf($smarty->getConfigVariable("MAIL_BODY_USERREMINDER"), $detail["userName"], $userPass));
		$mailer->AddAddress($userEmail);
		if(!$mailer->Send()) {
			$this->msg = $smarty->getConfigVariable("ALERT_MailerSendError");//$mailer->ErrorInfo
			return false;
		}
		else {
			$this->msg = $smarty->getConfigVariable("ALERT_MailerSendSuccessfully");
			return true;
		}
	}




	//UserRegister
	function mungeRegisterFormData(&$formvars)
	{
		parent::mungeFormData($formvars);
		$formvars['userBirthdate'] = implode("-", array_reverse(explode(".", $formvars['userBirthdate'])));
		$formvars['userPhone'] = implode("", explode("-", $formvars['userPhone']));
	}


	// TODO: Uzun kayıt formu için
	function isValidRegisterForm1($formvars)
	{

		// reset message
		$this->msg = null;

		$fields = array("userGender", "userFirstname", "userLastname", "userBirthdate", "userTckn", "userEmail", "userPhone");
		//$diff = array_diff($this->aAllField, (array) $this->sIndexColumn);
		//$merged = array_merge($diff, array("postaladdressContent", "postaladdressCity", "postaladdressCounty", "postaladdressPostalcode", "postaladdressCountry"));

		// check if empty
		foreach ($fields as $field) {
			if(strlen($formvars[$field]) == 0) {
				$this->msg = $field . '_empty';
				return false;
			}
		}

		// check others
		if (!CasString::isTckimlik($formvars["userTckn"])) {
			$this->msg = 'userTckn_error';
			return false;
		}

		if (!CasMailer::ValidateAddress($formvars["userEmail"])) {
			$this->msg = 'userEmail_error';
			return false;
		}

		if ($this->isExistByEmail($formvars["userEmail"])) {
			$this->msg = 'userEmail_exist';
			return false;
		}

		if (strcmp($formvars["userEmail"], $formvars["userEmailRepeat"]) != 0) {
			$this->msg = 'userEmail_notCompatible';
			return false;
		}

		if (!isset($formvars["userAgreement"])) {
			$this->msg = 'userAgreement_empty';
			return false;
		}

		// form passed validation
		return true;

	}


	function saveRegisterForm1($formvars)
	{
		global $smarty;
		
		$userPass = CasString::randomStringGenerator();

		if ($this->insert(
			$this->sTable,
			array(
					"userName"=>$formvars["userEmail"], 
					"userPass"=>sha1($userPass),
					"userEmail"=>$formvars["userEmail"], 
					"userFirstname"=>$formvars["userFirstname"], 
					"userLastname"=>$formvars["userLastname"], 
					"userBirthdate"=>$formvars["userBirthdate"], 
					"userTckn"=>$formvars["userTckn"],
					"userGender"=>$formvars["userGender"], 
					"userPhone"=>$formvars["userPhone"]
			)
		))
		{

			$rows = $this->run("select LAST_INSERT_ID() as last_insert_id;");
			$userId = $rows[0]["last_insert_id"];

			$usertrack = new Usertrack();
			$usertrack->addTrack(5, "userId=" . $userId);

			$this->insert(
				"user_role",
			array(
					"userId"=>$userId,
					"roleId"=>$smarty->getVariable("_USER_ROLE_B2C")
			)
			);


			$postaladdress = new Postaladdress;
				
			// deliveryaddress
			$postaladdress->insert(
			$postaladdress->sTable,
			array(
					"userId"=>$userId,
					"postaladdressContent"=>$formvars["postaladdressContent"],
					"postaladdressCity"=>$formvars["postaladdressCity"],
					"postaladdressCounty"=>$formvars["postaladdressCounty"],
					"postaladdressPostalcode"=>$formvars["postaladdressPostalcode"],
					"postaladdressCountry"=>$formvars["postaladdressCountry"]
			)
			);
				
			$rows = $postaladdress->run("select LAST_INSERT_ID() as last_insert_id;");
			$postaladdressId = $rows[0]["last_insert_id"];
				
			$this->insert(
				"user_deliveryaddress",
			array(
					"userId"=>$userId,
					"postaladdressId"=>$postaladdressId
			)
			);
				
			// invoiceaddress
			$postaladdress->insert(
			$postaladdress->sTable,
			array(
					"userId"=>$userId,
					"postaladdressContent"=>$formvars["postaladdressContent"],
					"postaladdressCity"=>$formvars["postaladdressCity"],
					"postaladdressCounty"=>$formvars["postaladdressCounty"],
					"postaladdressPostalcode"=>$formvars["postaladdressPostalcode"],
					"postaladdressCountry"=>$formvars["postaladdressCountry"]
			)
			);
				
			$rows = $postaladdress->run("select LAST_INSERT_ID() as last_insert_id;");
			$postaladdressId = $rows[0]["last_insert_id"];
				
			$this->insert(
				"user_invoiceaddress",
			array(
					"userId"=>$userId,
					"postaladdressId"=>$postaladdressId
			)
			);


			$mailer = new CasMailer();
			$mailer->Subject = $smarty->getConfigVariable("MAIL_SUBJECT_USERREGISTER");
			$mailer->MsgHTML(sprintf($smarty->getConfigVariable("MAIL_BODY_USERREGISTER"), $formvars["userEmail"], $userPass));
			$mailer->AddAddress($formvars["userEmail"], $formvars["userFirstname"] . ' ' . $formvars["userLastname"]);
			if($mailer->Send())
			{
				$this->msg = "success";
				return true;
			}
			else
			{
				$this->msg = "mailer_error";//$mailer->ErrorInfo
				return false;
			}

		}
		else
		{
			$this->msg = "save_error";
			return false;
		}
	}


	function isValidRecommendationForm($formvars)
	{
		global $smarty;
		
		if (!CasMailer::ValidateAddress($formvars["userEmail"])) {
			$this->msg = $smarty->getConfigVariable("ALERT_PleaseEnterAValidEmailAddress");
			return false;
		}

		if ( $this->isExistByEmail($formvars["userEmail"]) ) {
			$this->msg = $smarty->getConfigVariable("ALERT_ExistEmail");
			return false;
		}
		
		return true;

	}
	
	function sendRecommendationForm($formvars)
	{
		global $smarty;
		global $project;
		
		$u = $this->getEntry($_SESSION["userId"]);
		$userFullname = $u["userFirstname"] . " " . $u["userLastname"];
		
		$link = $project['url'] . "modules/b2c/register.php?action=view&friendId=".$u["userId"]."&userEmail=" . $formvars["userEmail"];
		
		$mailer = new CasMailer();
		$mailer->Subject = sprintf($smarty->getConfigVariable("MAIL_SUBJECT_USERRECOMMENDATION"), $userFullname);
		$mailer->MsgHTML(sprintf($smarty->getConfigVariable("MAIL_BODY_USERRECOMMENDATION"), $userFullname, $link));
		$mailer->AddAddress($formvars["userEmail"]);
		if(!$mailer->Send()) {
			$this->msg = $smarty->getConfigVariable("ALERT_MailerSendError");//$mailer->ErrorInfo
			return false;
		}
		else {
			$this->msg = $smarty->getConfigVariable("ALERT_MailerSendSuccessfully");
			return true;
		}
		
	}
		
	function isValidRegisterForm($formvars)
	{
		global $smarty;
		
		$diff = array("userFirstname", "userLastname", "userEmail", "userAgreement");

		// check if empty
		foreach ($diff as $field) {
			if(strlen($formvars[$field]) == 0) {
				$this->msg = $smarty->getConfigVariable("ALERT_PleaseFillOutThisField");
				$this->field = $field;
				return false;
			}
		}

		if (!CasMailer::ValidateAddress($formvars["userEmail"])) {
			$this->msg = $smarty->getConfigVariable("ALERT_PleaseEnterAValidEmailAddress");
			return false;
		}

		if ($this->isExistByEmail($formvars["userEmail"])) {
			$this->msg = $smarty->getConfigVariable("ALERT_ExistEmail");
			return false;
		}

		if (!isset($formvars["userAgreement"])) {
			$this->msg = $smarty->getConfigVariable("ALERT_PleaseAcceptUserAgreement");
			return false;
		}

		// form passed validation
		return true;

	}

	function saveRegisterForm($formvars, $roleId, $userStatus)
	{
		global $smarty;

		$userPass = CasString::randomStringGenerator();

		if ($this->insert(
			$this->sTable,
			array(
				"userStatus"=>$userStatus,
				"userName"=>$formvars["userEmail"], 
				"userPass"=>sha1($userPass),
				"userEmail"=>$formvars["userEmail"], 
				"userFirstname"=>$formvars["userFirstname"], 
				"userLastname"=>$formvars["userLastname"]
			)
		))
		{

			$rows = $this->run("select LAST_INSERT_ID() as last_insert_id;");
			$userId = $rows[0]["last_insert_id"];
				
			$usertrack = new Usertrack();
			$usertrack->addTrack(5, "userId=" . $userId);
			
			$this->insert(
				"user_role",
				array(
					"userId"=>$userId,
					"roleId"=>$roleId
				)
			);
			
			if ( isset($formvars["friendId"]) && !empty($formvars["friendId"]) ) {
				$this->insert(
					"user_friends",
					array(
						"userId"=>$userId,
						"friendId"=>$formvars["friendId"]
					)
				);
				$this->insert(
					"user_friends",
					array(
						"userId"=>$formvars["friendId"],
						"friendId"=>$userId
					)
				);
				
				$userpoint = new Userpoint();
				$userpoint->addUserpoint($formvars["friendId"], 4); //TODO: Tavsiye puanı
			}
			
			$userpoint = new Userpoint();
			$userpoint->addUserpoint($userId, 1); //TODO: Üyelik puanı
			
			$mailer = new CasMailer();
			$mailer->Subject = $smarty->getConfigVariable("MAIL_SUBJECT_USERREGISTER");
			$mailer->MsgHTML(sprintf($smarty->getConfigVariable("MAIL_BODY_USERREGISTER"), $formvars["userEmail"], $userPass));
			$mailer->AddAddress($formvars["userEmail"], $formvars["userFirstname"] . ' ' . $formvars["userLastname"]);
			if(!$mailer->Send()) {
				$this->msg = $smarty->getConfigVariable("ALERT_MailerSendError");//$mailer->ErrorInfo
				return false;
			}
			else {
				$this->msg = $smarty->getConfigVariable("ALERT_MailerSendSuccessfully");
				return true;
			}

		}
		else
		{
			$this->msg = $smarty->getConfigVariable("ALERT_ErrorOccured");
			return false;
		}
	}

}