<?php
class CasBase extends CasDatabase
{

	// smarty template object
	var $tpl = null;
	// messages
	var $msg = null;
	// database field
	var $field = null;
	

	var $sTable = null;
	var $aAllField = null;

	var $sIndexColumn = null;
	var $sIndexColumnFull = null;

	var $sTableI18n = null;
	var $aAllFieldI18n = null;

	var $sIndexColumnI18n = null;
	var $sIndexColumnI18nFull = null;

	var $sIso639ColumnI18n = null;
	var $sIso639ColumnI18nFull = null;


	function __construct()
	{
		
		global $project;
		parent::__construct($project['dbname']);

	}


	function _____getInfoTable($tableName)
	{
		$rows = $this->run("describe " . $tableName);
		if ($rows) {
			$arr["TableName"] = $tableName;
			foreach ($rows as $row)
			{
				$arr["AllField"][] = $row["Field"];
				if ($row["Key"]=='PRI')
				{
					$arr["PrimaryField"][] = $row["Field"];
				}
			}
			return ($arr);
		}
		else {
			return false;
		}
	}

	// Common methods

	/**
	 * display the template
	 *
	 * @param array $data the data
	 * @param string $tpl the template file
	 */
	public function displayTemplate($module, $tpl, $data=null, $tpl_number=null)
	{
		global $smarty;
		
		// assign javascript files
		global $JAVASCRIPT_FILES_LIST;
		$smarty->assign("JAVASCRIPT_FILES", $JAVASCRIPT_FILES_LIST);
		
		/*
		if ($module == null) {
			$dir = _PS_THEMES_DIR_ . $smarty->getVariable("_THEME_B2C_NAME") . "/";
		}
		else {
			$dir = _PS_MODULE_DIR_ . $module . "/";
		}
		*/
		
		$dir = _PS_THEMES_DIR_ . $module . "/" . $smarty->getVariable("_THEME_".strtoupper($module)."_NAME") . "/";
		
		$smarty->assign('data', $data);
		$smarty->assign('msg', $this->msg);
		
		$smarty->assign('tpl_header', $dir."layout_header");
		$smarty->assign('tpl_footer', $dir."layout_footer");
		
		$ext = ($tpl_number == null)?"":"_".$tpl_number;
		$smarty->assign('tpl_leftbar', $dir."layout_leftbar".$ext);
		$smarty->assign('tpl_rightbar', $dir."layout_rightbar".$ext);
				
		$smarty->assign('tpl_content', $tpl);

		if ($smarty->getVariable("_SITE_CODEPACKING") == "1") {
			$smarty->loadFilter('output', 'trimwhitespace');
			$smarty->loadFilter('output', 'javascriptpacker');
		}

		$smarty->display($dir.'layout.tpl');
	}
	
	/**
	 *
	 * merge two arrays
	 * @param array $vals
	 * @param array $row
	 */
	public function merge($vals, $row) {
		while (list($k,$v) = each($row)) {
			if (intval($k)=="") {
				$vals[$k] = $v;
			}
		}
		return $vals;
	}

	/**
	 * fix up form data if necessary
	 *
	 * @param array $formvars the form variables
	 */
	function mungeFormData(&$formvars)
	{
		// trim off excess whitespace
		foreach ($this->aAllField as $field) {
			if (is_string($formvars[$field])) {
				$formvars[$field] = trim($formvars[$field]);
			}
		}
	}

	/**
	 * test if form information is valid
	 *
	 * @param array $formvars the form variables
	 */
	function isValidForm($formvars)
	{
		global $smarty;
		
		// reset message
		$this->msg = null;

		$diff = array_diff($this->aAllField, (array) $this->sIndexColumn);

		// check if empty
		foreach ($diff as $field) {
			if (is_string($formvars[$field])) {
				if(strlen($formvars[$field]) == 0) {
					$this->msg = $smarty->getConfigVariable("ALERT_Required");
					return false;
				}
			}
		}

		// form passed validation
		return true;
	}

	/**
	 * 
	 * get the entry
	 * @param array $params (i18n, picture, company, company_picture)
	 * @return array
	 */
	public function getEntry($id, $params=null)
	{
		$sql = array();
		array_push($sql, "select");
		if ($params["i18n"]) {
			array_push($sql, $this->sTableI18n.".*,");
		}
		if ($params["picture"]) {
			array_push($sql, "picture.*,");
		}
		if ($params["company"]) {
			array_push($sql, "company.*,");
			if ($params["company_picture"]) {
				array_push($sql, "picture.*,");
			}
		}
		array_push($sql, $this->sTable.".*");
		array_push($sql, "from " . $this->sTable);
		if ($params["i18n"]) {
			array_push($sql, "left join " . $this->sTableI18n . " on " . $this->sIndexColumnI18nFull . " = " . $this->sIndexColumnFull . " and " . $this->sIso639ColumnI18nFull . " = :iso639");
		}
		if ($params["picture"]) {
			// TODO: bazı join table larda isDefault yok. Sorun olur mu? test yap.
			array_push($sql, "left join ".$this->sTable."_picture on ".$this->sTable."_picture.".$this->sIndexColumn." = " . $this->sIndexColumnFull . " AND ".$this->sTable."_picture.isDefault = true");
			//array_push($sql, "left join ".$this->sTable."_picture on ".$this->sTable."_picture.".$this->sIndexColumn." = " . $this->sIndexColumnFull);
			array_push($sql, "left join picture on picture.pictureId = ".$this->sTable."_picture.pictureId");
		}
		if ($params["company"]) {
			array_push($sql, "left join ".$this->sTable."_company on ".$this->sTable."_company.".$this->sIndexColumn." = " . $this->sIndexColumnFull);
			array_push($sql, "left join company on company.companyId = ".$this->sTable."_company.companyId");
			if ($params["company_picture"]) {
				array_push($sql, "left join company_picture on company_picture.companyId = company.companyId");
				array_push($sql, "left join picture on picture.pictureId = company_picture.pictureId");
			}
		}
		array_push($sql, "where " . $this->sIndexColumnFull . " = :id");
		array_push($sql, "limit 1");
		$sql = implode(" ", $sql);
		//echo($sql);exit;

		if ($params["i18n"]) $rows = $this->run($sql, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"], "id"=>$id));
		else $rows = $this->run($sql, array("id"=>$id));
		return (array) $rows[0];
	}
	
	function getEntryOwned($id, $params=null)
	{
		$entry = $this->getEntry($id, $params);
		return ($_SESSION["userId"]==$entry["userId"])?$entry:false;
	}


	function getEntryWithLanguages($id)
	{
		$iso639 = new Iso639;
		$data = $iso639->getEntries(false, false, "iso639Status = true");
		//print_r($data);exit;

		foreach ($data["aaData"] as $key=>$value) {
			$arr[$value["iso639Id"]]["iso639"] = $value;
			$rows = $this->select($this->sTableI18n, $this->sIndexColumn . " = :id and " . $this->sIso639ColumnI18n . " = :iso639", array("id"=>$id, "iso639"=>$value["iso639Id"]));
			$arr[$value["iso639Id"]]["model"] = $rows[0];
		}

		//print_r($arr);exit;
		return ($arr);
	}



	/**
	 * 
	 * Enter description here ...
	 * @param array $params
	 * @param string $where
	 * @param array $bind
	 * @param string $fields
	 * @return array
	 */
	function getEntries($params=null, $where="", $bind="", $fields="*")
	{
		$sql = array();
		array_push($sql, "select");
		if ($params["i18n"]) {
			array_push($sql, $this->sTableI18n.".*,");
		}
		if ($params["picture"]) {
			array_push($sql, "picture.*,");
		}
		array_push($sql, $this->sTable.".*");
		array_push($sql, "from " . $this->sTable);
		if ($params["i18n"]) {
			array_push($sql, "left join " . $this->sTableI18n . " on " . $this->sIndexColumnI18nFull . " = " . $this->sIndexColumnFull . " and " . $this->sIso639ColumnI18nFull . " = :iso639");
		}
		if ($params["picture"]) {
			array_push($sql, "left join ".$this->sTable."_picture on ".$this->sTable."_picture.".$this->sIndexColumn." = " . $this->sIndexColumnFull);
			array_push($sql, "left join picture on picture.pictureId = ".$this->sTable."_picture.pictureId");
		}
		if ($where != "") {
			array_push($sql, "where " . $where);
		}
		array_push($sql, "order by");
		array_push($sql, $this->sSortingColumnFull . " asc");
		$sql = implode(" ", $sql);
		//echo($sql);exit;

		if ($where != "") {
			$rows = $this->run($sql, $bind);
		}
		elseif ($params["i18n"]) {
			$rows = $this->run($sql, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"]));
		}
		else {
			$rows = $this->run($sql);
		}
		
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

	function getEntriesOwned($where="", $bind="", $fields="*")
	{
		return $this->getEntries(null, "userId = :userId", array("userId"=>$_SESSION["userId"]));
	}

	
	
	function getPictures($id)
	{
		$sQuery = "
			SELECT *
			FROM ".$this->sTable."_picture
			LEFT JOIN picture ON picture.pictureId = ".$this->sTable."_picture.pictureId
			WHERE ".$this->sTable."_picture.".$this->sIndexColumn." = :id
		";
		//echo $sQuery;exit;
		
		$rows = $this->run($sQuery, array("id"=>$id));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach ($rows as $row) {
			$arr["aaData"][$i] = $row;
			if ($row["isDefault"] == true) {
				$arr["defaultx"] = $row;
			}
			$i++;
		}
		//print_r($arr);exit;
		return ($arr);
	}
	
	
	
	/**
	 *
	 * save an entry (updates or inserts based on given index id)
	 * added picture and i18n support
	 * @param array $formvars
	 * @param array $params - [i18n], [picture], [picture][isDefault], [picture][thumbnail]
	 * @return int $id
	 */
	function saveEntry($formvars, $params=null)
	{
		$table = $this->sTable;
		$where = $this->sIndexColumn . " = :id";
		$bind = array("id"=>$formvars[$this->sIndexColumn]);
		
		$diff = array_diff($this->aAllField, (array) $this->sIndexColumn);
		foreach ($diff as $d) {
			$formvars2[$d] = ($formvars[$d]=="")?null:$formvars[$d];
		}
		
		if ($params["picture"] && $fileInfo = $this->uploadFile(
			array(
				"multipart"=>$formvars["pictureFile"],
				"picture"=>$params["picture"]
			)
		))
		{
			$this->insert("picture", array("pictureFile"=>$fileInfo["fileNameWithExtension"]));
			$rows = $this->run("select LAST_INSERT_ID() as last_insert_id;");
			$pictureId = $rows[0]["last_insert_id"];
		}
		
		if ($rows = $this->select($table, $where, $bind))
		{
			if ($params["picture"] && $fileInfo) $this->unlinkModelPicture($rows[0][$this->sIndexColumn]);
			$this->update($table, $formvars2, $where, $bind);
			$id = $formvars[$this->sIndexColumn];
		}
		else
		{
			$this->insert($table, $formvars2);
			$rows = $this->run("select LAST_INSERT_ID() as last_insert_id;");
			$id = $rows[0]["last_insert_id"];
		}
		
		if ($params["picture"] && $fileInfo) {
			if ($params["picture"]["isDefault"]) $info = array($this->sIndexColumn=>$id, "pictureId"=>$pictureId, "isDefault"=>true);
			else $info = array($this->sIndexColumn=>$id, "pictureId"=>$pictureId);
			$this->insert($this->sTable."_picture", $info);
		}
		
		if ($params["i18n"])
		{
			$diffI18n = array_diff($this->aAllFieldI18n, array($this->sIndexColumnI18n, $this->sIso639ColumnI18n));
			foreach ($diffI18n as $dI18n) {
				$formvarsI18n[$dI18n] = $formvars[$dI18n];
			}
			
			$iso639 = new Iso639;
			$iso639Dataset = $iso639->getEntries();
			foreach ($iso639Dataset["aaData"] as $iso639Data)
			{
				$tI18n = $this->sTableI18n;
				$wI18n = $this->sIndexColumnI18n . " = :id and " . $this->sIso639ColumnI18n . " = :iso639";
				$bI18n = array("id"=>$id, "iso639"=>$iso639Data["iso639Id"]);
				
				$d = array();
				foreach ($formvarsI18n as $k=>$v) {
					$d[$k] = $v[$iso639Data["iso639Id"]];
				}
				
				if ($hede = $this->select($tI18n, $wI18n, $bI18n))
				{
					$this->update(
						$tI18n,
						$d,
						$wI18n,
						$bI18n
					);
				}
				else
				{
					$e = array_merge(
						$d,
						array(
							$this->sIndexColumnI18n=>$id,
							$this->sIso639ColumnI18n=>$iso639Data[$this->sIso639ColumnI18n]
						)
					);
					$this->insert(
						$tI18n,
						$e
					);
				}
			}
		}
		
		return $id;
	}


	function saveFiles($formvars, $params=null)
	{
		if ($fileInfos = $this->uploadFiles(
			array(
				"multipart"=>$formvars["pictureFile"],
				"picture"=>$params["picture"]
			)
		))
		{
			foreach ($fileInfos as $fileInfo)
			{
				$this->insert(
					"picture",
					array(
						"pictureFile"=>$fileInfo["fileNameWithExtension"]
					)
				);
	
				$rows = $this->run("select LAST_INSERT_ID() as last_insert_id;");
				$pictureId = $rows[0]["last_insert_id"];
	
				$this->insert(
					$this->sTable."_picture",
					array(
						$this->sIndexColumn=>$formvars[$this->sIndexColumn],
						"pictureId"=>$pictureId
					)
				);
			}
			return true;
		}
		else
		{
			trigger_error("No file was uploaded");
			return false;
		}
	}
	
	function removeEntry($id, $unlinkModelPicture=false)
	{
		if ($unlinkModelPicture) $this->unlinkModelPicture($id);
		return $this->delete($this->sTable, $this->sIndexColumn." = :id", array("id"=>$id));
	}

	function unlinkModelPicture($id)
	{
		$sQuery = "
			SELECT *
			FROM ".$this->sTable."_picture
			LEFT JOIN picture ON picture.pictureId = ".$this->sTable."_picture.pictureId
			WHERE ".$this->sTable."_picture.".$this->sIndexColumn." = :id
		";
		$rows = $this->run($sQuery, array("id"=>$id));
		$row = $rows[0];
		
		$this->delete("picture", "pictureId = :pictureId", array("pictureId"=>$row["pictureId"]));

		unlink(_PS_IMG_DIR_.$this->sTable."/".$row["pictureFile"]);
	}

	function unlinkPicture($pictureId, $params=null)
	{
		$picture = new Picture;
		$row = $picture->getEntry($pictureId);
		//print_r($row);exit;
		
		$picture->removeEntry($pictureId);
		
		unlink(_PS_IMG_DIR_.$this->sTable."/".$row["pictureFile"]);
		if ($params["scale"]) {
			foreach ($params["scale"] as $key=>$scale) {
				unlink(_PS_IMG_DIR_.$this->sTable."/".($key+1)."_".$row["pictureFile"]);
			}
		}
	}
	
	
	
	public function setDefaultPicture($id, $pictureId) {
		$this->update($this->sTable."_picture", array("isDefault"=>null), $this->sIndexColumn." = :id", array("id"=>$id));
		$this->update($this->sTable."_picture", array("isDefault"=>true), "pictureId = :pictureId", array("pictureId"=>$pictureId));
		return true;
	}
	
	
	
	
	/**
	 * remove an owned entry
	 * @param int $id
	 */
	function removeEntryOwned($id)
	{
		$entry = $this->getEntryOwned($id);
		return ($entry==false)?false:$this->removeEntry($id);
	}


	/**
	 * sorts up or down a record
	 *
	 * @param array $formvars the form variables (action=uarr,darr; sIndexColumn)
	 */
	function udarr($formvars)
	{
		$udarr = $formvars[action];
		$id = $formvars[$this->sIndexColumn];

		$detail = $this->getEntry($id);
		switch ($udarr) {
			case 'uarr':
				$osid = $detail[$this->sSortingColumn] - 1;
				break;
			case 'darr':
				$osid = $detail[$this->sSortingColumn] + 1;
				break;
		}

		$orows = $this->select($this->sTable, $this->sSortingColumn . " = :osid", array("osid"=>$osid));
		$orow = $orows[0];
		$oid = $orow[$this->sIndexColumn];

		switch ($udarr) {
			case 'uarr':
				$sql1 = "update `" . $this->sTable . "` set ";
				$sql1 .= "`" . $this->sSortingColumn . "` = `" . $this->sSortingColumn . "` - 1 ";
				$sql1 .= "where `" . $this->sIndexColumn . "` = :id ";

				$sql2 = "update `" . $this->sTable . "` set ";
				$sql2 .= "`" . $this->sSortingColumn . "` = `" . $this->sSortingColumn . "` + 1 ";
				$sql2 .= "where `" . $this->sIndexColumn . "` = :oid ";

				break;
			case 'darr':
				$sql1 = "update `" . $this->sTable . "` set ";
				$sql1 .= "`" . $this->sSortingColumn . "` = `" . $this->sSortingColumn . "` + 1 ";
				$sql1 .= "where `" . $this->sIndexColumn . "` = :id ";

				$sql2 = "update `" . $this->sTable . "` set ";
				$sql2 .= "`" . $this->sSortingColumn . "` = `" . $this->sSortingColumn . "` - 1 ";
				$sql2 .= "where `" . $this->sIndexColumn . "` = :oid ";

				break;
		}

		$this->run($sql1, array("id"=>$id));
		$this->run($sql2, array("oid"=>$oid));
		return true;
	}





	function dataTables($aColumns, $sIndexColumn, $sTable, $get=array())
	{

		/*
		 * Paging
		*/
		$sLimit = "";
		if ( isset( $get['iDisplayStart'] ) && $get['iDisplayLength'] != '-1' )
		{
			$sLimit = "LIMIT " . $get['iDisplayStart'] .", " . $get['iDisplayLength'];
		}


		/*
		 * Ordering
		*/
		if ( isset( $get['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $get['iSortingCols'] ) ; $i++ )
			{
				if ( $get[ 'bSortable_'.intval($get['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= $aColumns[ intval( $get['iSortCol_'.$i] ) ] . " " . $get['sSortDir_'.$i] . ", ";
				}
			}

			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" )
			{
				$sOrder = "";
			}
		}


		/*
		 * Filtering
		* NOTE this does not match the built-in DataTables filtering which does it
		* word by word on any field. It's possible to do here, but concerned about efficiency
		* on very large tables, and MySQL's regex functionality is very limited
		*/
		$sWhere = "";
		if ( $get['sSearch'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%" . $get['sSearch'] . "%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}

		/* Individual column filtering */
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $get['bSearchable_'.$i] == "true" && $get['sSearch_'.$i] != '' )
			{
				if ( $sWhere == "" )
				{
					$sWhere = "WHERE ";
				}
				else
				{
					$sWhere .= " AND ";
				}
				$sWhere .= $aColumns[$i]." LIKE '%" . $get['sSearch_'.$i] . "%' ";
			}
		}


		/*
		 * SQL queries
		* Get data to display
		*/
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
			FROM   $sTable
			$sWhere
			$sOrder
			$sLimit
		";
		$rResult = $this->run($sQuery);


		/* Data set length after filtering */
		$sQuery = "
			SELECT FOUND_ROWS() as iFilteredTotal
		";
		$aResultFilterTotal = $this->run($sQuery, PDO::FETCH_NUM);
		$iFilteredTotal = $aResultFilterTotal[0]["iFilteredTotal"];

		/* Total data set length */
		$sQuery = "
			SELECT COUNT(".$sIndexColumn.") as iTotal
			FROM   $sTable
		";
		$aResultTotal = $this->run($sQuery);
		$iTotal = $aResultTotal[0]["iTotal"];


		/*
		 * Output
		*/
		$output = array(
			"sEcho" => intval($get['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);

		foreach ($rResult as $aRow)
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] == "version" )
				{
					/* Special output formatting for 'version' column */
					$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
				}
				else if ( $aColumns[$i] != ' ' )
				{
					/* General output */
					$row[] = $aRow[ $aColumns[$i] ];
				}
			}
			$output['aaData'][] = $row;
		}
		//print_r($output);exit;
		
		if ( isset($get['callback']) )
		{
			return $get['callback'].'('.json_encode( $output ).');';
		}
		else
		{
			return json_encode( $output );
		}
	}


	/**
	 * upload a file
	 * http://php.net/manual/en/features.file-upload.errors.php
	 *
	 * @param array $params formvars(files, post), inputName, uploadTo, picture(resize, thumbnail, isDefault), fileType, debug
	 * @return array $fileInfo fileName, fileNameWithExtension, fileType, fileSize
	 */
	public function uploadFile($params)
	{
		if (empty($params['multipart'])) {
			//trigger_error("parameter 'multipart' must not be empty");
			return false;
		}
		if (empty($params['fileType'])) {
			//trigger_error("parameter 'fileType' must not be empty");
			$aFileType = array("image/png", "image/jpeg", "image/jpg");
		}
		if (empty($params['uploadTo'])) {
			//trigger_error("parameter 'uploadTo' must not be empty");
			$uploadTemp = _PS_IMG_DIR_;
			$uploadTo = $uploadTemp.$this->sTable."/";
			if (!file_exists($uploadTemp)) mkdir($uploadTemp);
			if (!file_exists($uploadTo)) mkdir($uploadTo);
		}
		
		$multipart = $params['multipart'];

		switch ($multipart["error"]) {
			case UPLOAD_ERR_OK:
				//trigger_error("completed");
				//return true;
				break;
			case UPLOAD_ERR_INI_SIZE:
				//trigger_error("The uploaded file exceeds the upload_max_filesize directive in php.ini.");
				return false;
				break;
			case UPLOAD_ERR_FORM_SIZE:
				//trigger_error("The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.");
				return false;
				break;
			case UPLOAD_ERR_PARTIAL:
				//trigger_error("The uploaded file was only partially uploaded.");
				return false;
				break;
			case UPLOAD_ERR_NO_FILE:
				//trigger_error("No file was uploaded.");
				return false;
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				//trigger_error("Missing a temporary folder.");
				return false;
				break;
			case UPLOAD_ERR_CANT_WRITE:
				//trigger_error("Failed to write file to disk.");
				return false;
				break;
			case UPLOAD_ERR_EXTENSION:
				//trigger_error("A PHP extension stopped the file upload.");
				return false;
				break;
		}

		if (!in_array(strtolower($multipart["type"]), $aFileType)) {
			//$this->msg = 'ALERT_IllegalFileFormat';
			//trigger_error("illegal file format");
			return false;
		}
		else {
			$extension = CasString::getExtension(basename($multipart['name']));
			$fileName = time();
			$fileNameWithExtension = $fileName . '.' . $extension;

			$fileSize = $multipart['size'];
			$fileType = $multipart['type'];
			$fileNameWithPath = $uploadTemp . $fileNameWithExtension;

			if (!move_uploaded_file($multipart['tmp_name'], $fileNameWithPath)) {
				//$this->msg = 'ALERT_IllegalFileSize';
				//trigger_error("illegal file size");
				return false;
			}
			else {

				//list($src_width, $src_height, $src_type, $src_wh) = getimagesize($fileNameWithPath);
				//$src_type = image_type_to_mime_type($src_type);
				//echo('$src_width: '. $src_width. ' $src_height: '. $src_height. ' $src_type: '. $src_type. ' $src_wh: '. $src_wh);exit;
				
				$file  = addslashes(fread(fopen($fileNameWithPath, "r"), filesize($fileNameWithPath)));
				
				if ($params["picture"]) {
					$picture = $params["picture"];
					
					// Resize original picture
					if ($picture["resize"])
					{
						$width = $picture["resize"][0];
						$height = $picture["resize"][1];
					}
					else {
						$width = 1000;
						$height = 1000;
					}
					
					$fileNameResizeWithExtension = sprintf("%s.%s", $fileName, $extension);
					$fileNameResizeWithPath = $uploadTo . $fileNameResizeWithExtension;
					
					$image = new SimpleImage();
					$image->load($fileNameWithPath);
					if ($image->getWidth() > $image->getHeight()) $image->resizeToWidth($width);
					else $image->resizeToHeight($height);
					$image->save($fileNameResizeWithPath);
					
					
					if ($picture["scale"])
					{
						foreach ($picture["scale"] as $key=>$thumbnail)
						{
							//$width = $thumbnail[0];
							//$height = $thumbnail[1];
							$scale = $thumbnail[0];
							
							//if (!file_exists($uploadTo)) mkdir($uploadTo);
							//$fileNameThumbWithExtension = sprintf("%s_%sx%s.%s", $fileName, $width, $height, $extension);
							$fileNameThumbWithExtension = sprintf("%s_%s.%s", ($key+1), $fileName, $extension);
							$fileNameThumbWithPath = $uploadTo . $fileNameThumbWithExtension;
							
							$image->load($fileNameResizeWithPath);
							$image->scale($scale);
							$image->save($fileNameThumbWithPath);
							
							usleep(1);//1sec=1000000
						}
					}

				}
				
				unlink($fileNameWithPath);
				//$this->msg = 'ALERT_Completed';
				//trigger_error("completed");
				return array("error"=>$multipart["error"], "fileName"=>$fileName, "fileNameWithExtension"=>$fileNameWithExtension, "fileType"=>$fileType, "fileSize"=>$fileSize);
				//return true;

			}
		}
	}


	public function uploadFiles($params)
	{
		if (empty($params['multipart'])) {
			//trigger_error("parameter 'multipart' must not be empty");
			return false;
		}
		if (empty($params['fileType'])) {
			//trigger_error("parameter 'fileType' must not be empty");
			$aFileType = array("image/png", "image/jpeg", "image/jpg");
		}
		if (empty($params['uploadTo'])) {
			//trigger_error("parameter 'uploadTo' must not be empty");
			$uploadTemp = _PS_IMG_DIR_;
			$uploadTo = $uploadTemp.$this->sTable."/";
			if (!file_exists($uploadTemp)) mkdir($uploadTemp);
			if (!file_exists($uploadTo)) mkdir($uploadTo);
		}
		

		$multipart = $params['multipart'];

		$arr = array();
		$uploaded = 0;
		$message = array();

		foreach ($multipart["error"] as $i=>$error)
		{
			if ($error == UPLOAD_ERR_OK)
			{
				$name = $multipart["name"][$i];

				if (!in_array(strtolower($multipart["type"][$i]), $aFileType)) {
					//$message[] = "$name - illegal file format";
					continue;
				}
				else {
					$extension = CasString::getExtension(basename($multipart['name'][$i]));
					$fileName = time();
					//$fileNameWithExtension = $fileName . '-' . ($i+1) . '.' . $extension;
					$fileNameWithExtension = $fileName . '.' . $extension;

					$fileSize = $multipart['size'][$i];
					$fileType = $multipart['type'][$i];
					$fileNameWithPath = $uploadTemp . $fileNameWithExtension;

					if (!move_uploaded_file($multipart['tmp_name'][$i], $fileNameWithPath)) {
						//$message[] = "$name - illegal file size";
						continue;
					}
					else {

						$file  = addslashes(fread(fopen($fileNameWithPath, "r"), filesize($fileNameWithPath)));

						if ($params["picture"]) {
							$picture = $params["picture"];
							
							if ($picture["resize"])
							{
								$width = $picture["resize"][0];
								$height = $picture["resize"][1];
							}
							else {
								$width = 1000;
								$height = 1000;
							}
							
							$fileNameResizeWithExtension = sprintf("%s.%s", $fileName, $extension);
							$fileNameResizeWithPath = $uploadTo . $fileNameResizeWithExtension;
								
							$image = new SimpleImage();
							$image->load($fileNameWithPath);
							if ($image->getWidth() > $image->getHeight()) $image->resizeToWidth($width);
							else $image->resizeToHeight($height);
							$image->save($fileNameResizeWithPath);
							
							
							if ($picture["scale"])
							{
								foreach ($picture["scale"] as $key=>$thumbnail)
								{
									//$width = $thumbnail[0];
									//$height = $thumbnail[1];
									$scale = $thumbnail[0];
									
									//if (!file_exists($uploadTo)) mkdir($uploadTo);
									//$fileNameThumbWithExtension = sprintf("%s-%s.%s", $fileName, ($i+1), $extension);
									//$fileNameThumbWithExtension = sprintf("%s_%sx%s.%s", $fileName, $width, $height, $extension);
									$fileNameThumbWithExtension = sprintf("%s_%s.%s", ($key+1), $fileName, $extension);
									$fileNameThumbWithPath = $uploadTo . $fileNameThumbWithExtension;
									
									$image->load($fileNameResizeWithPath);
									$image->scale($scale);
									$image->save($fileNameThumbWithPath);
									
									usleep(1);//1sec=1000000
								}
							}
	
						}
						
						unlink($fileNameWithPath);
						$arr[$i] = array("error"=>$multipart["error"][$i], "fileName"=>$fileName, "fileNameWithExtension"=>$fileNameWithExtension, "fileType"=>$fileType, "fileSize"=>$fileSize);

						//$message[] = "$name - completed";
						$uploaded++;
						continue;
					}
				}
			}
			usleep(1);//1sec=1000000
		}

		//echo $uploaded . ' files uploaded.' . PHP_EOL;
		//foreach ($message as $error) echo $error . PHP_EOL;

		return ($arr);


	}

}