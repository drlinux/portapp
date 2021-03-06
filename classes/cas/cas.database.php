<?php
/*
 * PHP PDO Wrapper Class
 * http://www.imavex.com/php-pdo-wrapper-class/
 */
class CasDatabase
{
	protected $db;
	
	private $error;
	private $sql;
	private $bind;
	private $errorCallbackFunction;
	private $errorMsgFormat;
	
	private $pdo;
	
	public function __construct($dbname)
	{
		global $smarty;
		
		$smarty->configLoad('Settings.properties', 'database');
		
		$host			= $smarty->getConfigVariable("host");
		$username		= $smarty->getConfigVariable("username");
		$password		= $smarty->getConfigVariable("password");
		//$dbname			= $smarty->getConfigVariable("dbname");
		$tables_prefix	= $smarty->getConfigVariable("tables_prefix");
		$adapter		= $smarty->getConfigVariable("adapter");
		$port			= $smarty->getConfigVariable("port");
		$charset		= $smarty->getConfigVariable("charset");
		$timezone		= "+03:00";
		
		if(empty($this->pdo) || !is_a($this->pdo, 'PDO'))
		{
			if ($adapter == "PDO_MYSQL") {
				$dsn = "mysql:host=".$host.";port=".$port.";dbname=".$dbname;
			}
			else if ($adapter == "mssql") {
				$dsn = "mssql:host=".$host.";port=".$port.";dbname=".$dbname;
			}
			else if ($adapter == "sybase") {
				$dsn = "sybase:host=".$host.";port=".$port.";dbname=".$dbname;
			}
			else if ($adapter == "sqlite") {
				$dsn = "sqlite:my/database/path/database.db";
			}
			else if ($adapter == "odbc") {
				$dsn = "odbc:Driver={SQL Server};Server=".$host.";Database=".$dbname.";";
			}
			
			try {
				$this->pdo = new PDO($dsn, $username, $password, array(
					//PDO::ATTR_PERSISTENT => true,
					//PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . $charset . ", time_zone='{$timezone}'"
				));
			} catch (PDOException $e) {
				$this->error = $e->getMessage();
				trigger_error($e->getMessage(), E_USER_ERROR);
			}
		}
		
	}

	private function debug() {
		if(!empty($this->errorCallbackFunction)) {
			$error = array("Error" => $this->error);
			if(!empty($this->sql))
				$error["SQL Statement"] = $this->sql;
			if(!empty($this->bind))
				$error["Bind Parameters"] = trim(print_r($this->bind, true));

			$backtrace = debug_backtrace();
			if(!empty($backtrace)) {
				foreach($backtrace as $info) {
					if($info["file"] != __FILE__)
						$error["Backtrace"] = $info["file"] . " at line " . $info["line"];	
				}		
			}

			$msg = "";
			if($this->errorMsgFormat == "html") {
				if(!empty($error["Bind Parameters"]))
					$error["Bind Parameters"] = "<pre>" . $error["Bind Parameters"] . "</pre>";
				$css = trim(file_get_contents(dirname(__FILE__) . "/error.css"));
				$msg .= '<style type="text/css">' . "\n" . $css . "\n</style>";
				$msg .= "\n" . '<div class="db-error">' . "\n\t<h3>SQL Error</h3>";
				foreach($error as $key => $val)
					$msg .= "\n\t<label>" . $key . ":</label>" . $val;
				$msg .= "\n\t</div>\n</div>";
			}
			elseif($this->errorMsgFormat == "text") {
				$msg .= "SQL Error\n" . str_repeat("-", 50);
				foreach($error as $key => $val)
					$msg .= "\n\n$key:\n$val";
			}

			$func = $this->errorCallbackFunction;
			$func($msg);
		}
	}

	public function delete($table, $where, $bind="") {
		$sql = "DELETE FROM " . $table . " WHERE " . $where . ";";
		
		//echo($sql);exit;
		return $this->run($sql, $bind);
	}

	private function filter($table, $info) {
		$driver = $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
		if($driver == 'sqlite') {
			$sql = "PRAGMA table_info('" . $table . "');";
			$key = "name";
		}
		elseif($driver == 'mysql') {
			$sql = "DESCRIBE " . $table . ";";
			$key = "Field";
		}
		else {	
			$sql = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $table . "';";
			$key = "column_name";
		}	

		if(false !== ($list = $this->run($sql))) {
			$fields = array();
			foreach($list as $record)
				$fields[] = $record[$key];
			return array_values(array_intersect($fields, array_keys($info)));
		}
		return array();
	}

	private function cleanup($bind) {
		if(!is_array($bind)) {
			if(!empty($bind))
				$bind = array($bind);
			else
				$bind = array();
		}
		return $bind;
	}

	public function insert($table, $info) {
		$fields = $this->filter($table, $info);
		$sql = "INSERT INTO " . $table . " (" . implode($fields, ", ") . ") VALUES (:" . implode($fields, ", :") . ");";
		//echo($sql) . "<br /><br />";//exit;
		
		$bind = array();
		foreach($fields as $field) {
			$bind[":$field"] = $info[$field];
		}
		return $this->run($sql, $bind);
	}

	public function run($sql, $bind="", $fetch_style=PDO::FETCH_ASSOC) {
		$this->sql = trim($sql);
		$this->bind = $this->cleanup($bind);
		$this->error = "";
		
		try {
			$pdostmt = $this->pdo->prepare($this->sql);
			if($pdostmt->execute($this->bind) !== false) {
				if(preg_match("/^(" . implode("|", array("select", "describe", "pragma")) . ") /i", $this->sql))
					return $pdostmt->fetchAll($fetch_style);
				elseif(preg_match("/^(" . implode("|", array("delete", "insert", "update")) . ") /i", $this->sql))
					return $pdostmt->rowCount() || true;
			}	
		} catch (PDOException $e) {
			$this->error = $e->getMessage();	
			$this->debug();
			return false;
		}
	}

	public function select($table, $where="", $bind="", $fields="*") {
		$sql = "SELECT " . $fields . " FROM " . $table;
		if(!empty($where))
			$sql .= " WHERE " . $where;
		$sql .= ";";
		//echo($sql);exit;
		//print_r($bind);exit;
		return $this->run($sql, $bind);
	}
	
	public function lastInsertId()
	{
		$data = $this->run("select LAST_INSERT_ID() as last_insert_id;");
		return $data[0]["last_insert_id"];
	}

	public function setErrorCallbackFunction($errorCallbackFunction, $errorMsgFormat="html") {
		//Variable functions for won't work with language constructs such as echo and print, so these are replaced with print_r.
		if(in_array(strtolower($errorCallbackFunction), array("echo", "print")))
			$errorCallbackFunction = "print_r";

		if(function_exists($errorCallbackFunction)) {
			$this->errorCallbackFunction = $errorCallbackFunction;	
			if(!in_array(strtolower($errorMsgFormat), array("html", "text")))
				$errorMsgFormat = "html";
			$this->errorMsgFormat = $errorMsgFormat;	
		}	
	}

	public function update($table, $info, $where, $bind="") {
		$fields = $this->filter($table, $info);
		$fieldSize = sizeof($fields);

		$sql = "UPDATE " . $table . " SET ";
		for($f = 0; $f < $fieldSize; ++$f) {
			if($f > 0)
				$sql .= ", ";
			$sql .= $fields[$f] . " = :update_" . $fields[$f]; 
		}
		$sql .= " WHERE " . $where . ";";
		
		
		$bind = $this->cleanup($bind);
		foreach($fields as $field) {
			$bind[":update_$field"] = $info[$field];
		}
		//print_r($bind);exit;
		return $this->run($sql, $bind);
	}
}