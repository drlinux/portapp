<?php
class Company extends CasBase
{
	private $sLinkTable;

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("companyId", "companyTax", "companyTitle", "companyPhone", "companyFax", "companyAddress");
		$this->sIndexColumn		= "companyId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
		
		// EXTENDED
		$this->sLinkTable = "user_company";
		$this->sUserTable = "user";
	}
	
	function addCompany($formvars)
	{
		global $smarty;
		if($this->insert($this->sTable, $formvars))
		{
			if($companyId = $this->lastInsertId())
			{
				if($this->addToLinkTable($companyId, $formvars["userId"]))
				{
					return true;
				}
				else
				{
					$this->msg = $smarty->getConfigVariable("ALERT_ErrorOccured");
					return false;
				}
			}
			else
			{
				$this->msg = $smarty->getConfigVariable("ALERT_ErrorOccured");
				return false;
			}
		}
	}
	
	function addToLinkTable($companyId, $userId)
	{
		return $this->insert($this->sLinkTable, array("userId"=>$userId, "companyId"=>$companyId));
	}
	
	function updateCompany($companyId, $variables)
	{
		global $smarty;
		
		if($this->update($this->sTable, $variables, $this->sIndexColumn . "=:id", array("id"=>$companyId)))
		{
			$this->msg = $smarty->getConfigVariable("ALERT_SaveSucceed");
			return true;
		}
		else
		{
			$this->msg = $smarty->getConfigVariable("ALERT_ErrorOccured");
			return false;
		}
	}
	
	function selectCompany($companyId)
	{
		$data = $this->select($this->sTable, $this->sIndexColumn . "=:id", array("id"=>$compantId));
		return $data[0];
	}
	
	function selectCompanyByUserId($userId)
	{
		$query  = "SELECT * FROM {$this->sTable} AS c ";
		$query .= "LEFT JOIN {$this->sLinkTable} AS uc ON c.companyId=uc.companyId ";
		$query .= "WHERE uc.userId=:id";
		
		$data = $this->run($query, array("id"=>$userId));
		return $data[0];
	}
	
	function listCompanies()
	{
		return $this->select($this->sTable);
	}
	
	function deleteCompany($companyId)
	{
		return $this->delete($this->sTable, $this->sIndexColumn . "=:id", array("id"=>$compantId)) &&
				$this->delete($this->sLinkTable, $this->sIndexColumn . "=:id", array("id"=>$compantId));
	}
	
}