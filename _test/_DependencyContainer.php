<?php
class DependencyContainer {
	
	private $_instances = array();
	private $_params = array();

	public function __construct($params)
	{
		$this->_params = $params;
	}

	public function getDb()
	{
		if(empty($this->_instances['db']) || !is_a($this->_instances['db'], 'PDO'))
		{
			$this->_instances['db'] = new PDO($this->_params['dsn'], $this->_params['dbUser'], $this->_params['dbPwd']);
		}
		return $this->_instances['db'];
	}
	
	public function getMessageHandler()
	{
		echo "getMessageHandler() function: " . __CLASS__;
	}
	
}