<?php
class ConnectionFactory
{
	private static $factory;
	
	public static function getFactory()
	{
		if (!self::$factory)
		{
			self::$factory = new ConnectionFactory();
		}
		return self::$factory;
	}

	private $db;

	public function getConnection() {
		if (!$this->db)
		{
			$dbType = strtolower(_DB_TYPE_);
			switch ($dbType)
			{
				case 'sqlite':
					$this->db = new PDO("sqlite:my/database/path/database.db");
					break;
				case 'mssql':
				case 'sybase':
				case 'mysql':
				default:
					$this->db = new PDO(
						$dbType.":host="._DB_SERVER_.";dbname="._DB_NAME_, 
						_DB_USER_, 
						_DB_PASSWD_, 
						array(/*PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, */PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
					);
					break;
			}
		}
		return $this->db;
	}
	
}