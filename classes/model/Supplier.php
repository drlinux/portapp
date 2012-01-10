<?php
class Supplier extends CasBase
{

	function __construct()
	{
		parent::__construct();

		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("supplierId", "supplierCode");
		$this->sIndexColumn		= "supplierId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;

	}

	function removeSupplier($supplierId)
	{
		$a = $this->getSupplierBySupplierId($supplierId);

		$this->removeEntry($supplierId);

		$company = new Company();
		$company->removeEntry($a["companyId"], true);
	}
	
	function getSuppliers()
	{
		$sQuery = "
			SELECT 
			picture.*,
			company.*,
			supplier.*
			FROM supplier
			LEFT JOIN supplier_company ON supplier_company.supplierId = supplier.supplierId
			LEFT JOIN company ON company.companyId = supplier_company.companyId
			LEFT JOIN company_picture ON company_picture.companyId = company.companyId AND company_picture.isDefault = true
			LEFT JOIN picture ON picture.pictureId = company_picture.pictureId
		";
		//echo $sQuery;exit;
		
		$rows = $this->run($sQuery);
		$arr["iTotalRecords"] = count($rows);
		if ($arr["iTotalRecords"] > 0) {
			$i=0;
			foreach ($rows as $row) {
				$arr["aaData"][$i] = $row;
				$arr["options"][$row[$this->sIndexColumn]] = $row["companyTitle"];
				$i++;
			}
		}
		return ($arr);
	}

	function getSupplierBySupplierId($supplierId)
	{
		$sQuery = "
			SELECT 
			picture.*,
			company.*,
			supplier.*
			FROM supplier
			LEFT JOIN supplier_company ON supplier_company.supplierId = supplier.supplierId
			LEFT JOIN company ON company.companyId = supplier_company.companyId
			LEFT JOIN company_picture ON company_picture.companyId = company.companyId AND company_picture.isDefault = true
			LEFT JOIN picture ON picture.pictureId = company_picture.pictureId
			WHERE supplier.supplierId = :supplierId
		";
		//echo $sQuery;exit;

		$rows = $this->run($sQuery, array("supplierId"=>$supplierId));
		$row = $rows[0];

		//print_r($row);exit;
		return ($row);
	}

	function saveSupplier($formvars)
	{
		$supplierId = $this->saveEntry($formvars);

		if ($sc = $this->select("supplier_company", "supplierId = :id", array("id"=>$supplierId))) {
			$info_company = array(
							"companyId"=>$sc[0]["companyId"],
							"companyTax"=>$formvars["companyTax"],
							"companyTitle"=>$formvars["companyTitle"],
							"companyPhone"=>$formvars["companyPhone"],
							"companyFax"=>$formvars["companyFax"]
			);
			$formvars = array_merge(
				$formvars,
				array(
					"companyId"=>$sc[0]["companyId"]
				)
			);
			$company = new Company();
			$companyId = $company->saveEntry($formvars, array("picture"=>array("isDefault"=>true)));
		}
		else {
			$this->insert("supplier", array("supplierCode"=>$formvars["supplierCode"]));
			$s = $this->run("select LAST_INSERT_ID() as last_insert_id;");
			$supplierId = $s[0]["last_insert_id"];

			$info_company = array(
							"companyTax"=>$formvars["companyTax"],
							"companyTitle"=>$formvars["companyTitle"],
							"companyPhone"=>$formvars["companyPhone"],
							"companyFax"=>$formvars["companyFax"]
			);
			$company = new Company();
			$companyId = $company->saveEntry($formvars, array("picture"=>array("isDefault"=>true)));

			$this->insert("supplier_company", array("supplierId"=>$supplierId, "companyId"=>$companyId));
		}
	}

}