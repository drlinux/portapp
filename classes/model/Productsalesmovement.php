<?php
class Productsalesmovement extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("productsalesmovementId", "productorderId", "productattributeId", "productsalesmovementQuantity", "productsalesmovementPrice", "currencyId");
		$this->sIndexColumn		= "productsalesmovementId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;
		
	}
	

	/**
	 * test if form information is valid
	 *
	 * @param array $formvars the form variables
	 */
	function isValidForm($formvars) {

		// reset message
		$this->msg = null;

		if(!is_int($formvars['quantity'])) {
			$this->msg = 'quantity_error';
			return false;
		}

		// form passed validation
		return true;
	}

	function getProductsalesmovementByProductattributeIds($productattributeIds=null)
	{
		$sql = array();
		array_push($sql, "select *,");
		array_push($sql, "sum(productsalesmovement.productsalesmovementQuantity) as productsalesmovementQuantity,");
		array_push($sql, "sum(productsalesmovement.productsalesmovementQuantity*productsalesmovement.productsalesmovementPrice) as productsalesmovementRevenue");
		array_push($sql, "from " . $this->sTable);
		array_push($sql, "left join productattribute on productattribute.productattributeId = productsalesmovement.productattributeId");
		array_push($sql, "left join productorder on productorder.productorderId = productsalesmovement.productorderId");
		if ($productattributeIds!=null) array_push($sql, "where productsalesmovement.productattributeId = " . join(" or productsalesmovement.productattributeId = ", $productattributeIds));
		array_push($sql, "group by productsalesmovement.productattributeId");
		$sql = implode(" ", $sql);
		//echo($sql);exit;
		
		$rows = $this->run($sql);
		//print_r($rows);exit;
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach ($rows as $row) {
			$arr["productattributeIds"][$i] = $row["productattributeId"];
			$arr["aaData"][$i] = $row;
			
			$productattribute = new Productattribute;
			$arr["aaData"][$i]["attributeIds"] = $productattribute->getAttributeIdsByProductattributeId($row["productattributeId"]);

			$attribute = new Attribute;
			foreach ($arr["aaData"][$i]["attributeIds"] as $k=>$attributeId) {
				$arr["aaData"][$i]["attributegroups"][$k] = $attribute->getAttribute($attributeId);
			}

			$productsalesmovementQuantityTotal += $row["productsalesmovementQuantity"];
			$productsalesmovementRevenueTotal += $row["productsalesmovementRevenue"];
			$i++;
		}
		$arr["productsalesmovementRevenueTotal"] = number_format($productsalesmovementRevenueTotal, 2);
		$arr["productsalesmovementQuantityTotal"] = $productsalesmovementQuantityTotal;
		$arr["productsalesmovementPriceUnit"] = ($productsalesmovementQuantityTotal>0)?number_format($productsalesmovementRevenueTotal/$productsalesmovementQuantityTotal, 2):0;
		//print_r($arr);exit;
		return ($arr);
	}

	function getProductsalesmovementByProductorderId($productorderId=null) {
		if ($productorderId == null) return null;

		$sql = array();
		array_push($sql, "select *");
		array_push($sql, "from " . $this->sTable);
		array_push($sql, "left join productattribute on productattribute.productattributeId = productsalesmovement.productattributeId");
		array_push($sql, "left join product on product.productId = productattribute.productId");
		if ($productorderId != null) {
			array_push($sql, "where productsalesmovement.productorderId = " . $productorderId);
		}
		$sql = implode(" ", $sql);
		//echo($sql);exit;
		
		$rows = $this->run($sql);
		//print_r($rows);exit;
		
		return ($rows);
	}
	
}