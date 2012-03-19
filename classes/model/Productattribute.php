<?php
/**
*
* @package    model
* @subpackage CasBase
* @copyright  Copyright (c) cas.ict (http://www.casict.com/)
* @license    http://www.casict.com/license/new-bsd     New BSD License
* @author cas.ict
*
*/
class Productattribute extends CasBase
{

	function __construct()
	{
		parent::__construct();
		
		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("productattributeId", "productId", "productattributeCode", "productattributeQuantity", "productattributeCost", "productattributePrice");
		$this->sIndexColumn		= "productattributeId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sTitleColumn			= $this->sTable."Code";
		$this->sTitleColumnFull		= $this->sTable.".".$this->sTitleColumn;
		
		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;
	}
	
	function isValidForm($formvars)
	{
		global $smarty;
		
		$fields = array("productattributeCode", "productattributeQuantity");
		
		// check if empty
		foreach ($fields as $field) {
			if(strlen($formvars[$field]) == 0) {
				$this->msg = $smarty->getConfigVariable("ALERT_PleaseFillOutThisField");
				$this->field = $field;
				return false;
			}
		}
		
		// check others
		if ($this->isExistByProductattributeCode($formvars["productattributeCode"])) {
			$this->msg = "code exist";//$smarty->getConfigVariable("ALERT_ExistCode");
			return false;
		}
		
		// form passed validation
		return true;
		
	}
	
	public function isExistByProductattributeCode($productattributeCode, $current=null)
	{
		if ($current == null) {
			$rows = $this->select($this->sTable, "productattributeCode = :productattributeCode", array("productattributeCode"=>$productattributeCode));
		}
		else {
			$rows = $this->select($this->sTable, "productattributeCode = :productattributeCode and productattributeCode <> :current", array("productattributeCode"=>$productattributeCode, "current"=>$current));
		}
		$row = $rows[0];
		return $row;
	}
	
	function getProductattributes($get=array(), $json = true)
	{
		$aColumns = array("productId", "productCode", "productTitle");
	
		//$limit = (isset($get["limit"]))?intval($get["limit"]):12;
		/*
		 * Paging
		*/
		$sLimit = "";
		if ( isset( $get['iDisplayStart'] ) && $get['iDisplayLength'] != '-1' )
		{
			$sLimit = "LIMIT " . $get['iDisplayStart'] .", " . $get['iDisplayLength'];
		}
		//echo $sLimit;exit;
	
		/*
		 * Ordering
		*/
		$sOrder = "ORDER BY product.productId desc ";
	
	
		/*
		 * Custom Filtering
		*/
		$sWhere = "";
		$sWhere .= "WHERE productattribute.productattributeQuantity > 0 ";
		$sWhere .= "AND productattribute.productattributeQuantity IS NOT NULL ";
		if ( $get['sSearch'] != "" )
		{
			$sWhere .= "AND (product.productCode LIKE '%".$get['sSearch']."%' OR product.productTitle LIKE '%".$get['sSearch']."%' ) ";
		}
	
		/*
		 * benim oluşturduğum tipler
		*/
		if ( $get['sType'] != "" )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
	
			if ( $get["sType"] == "productgroup" ) {
				$sWhere .= "productgroup_product.productgroupId = " . $get["productgroupId"] . " ";
			}
			elseif ( $get["sType"] == "category" ) {
				$sWhere .= "product_category.categoryId = " . $get["categoryId"] . " ";
			}
			elseif ( $get["sType"] == "brand" ) {
				$sWhere .= "product.brandId = " . $get["brandId"] . " ";
			}
			elseif ( $get["sType"] == "similar" ) {
				$sWhere .= "product_category.categoryId = " . $get["categoryId"] . " ";
			}
			elseif ( $get["sType"] == "promoted" ) {
				$sWhere .= "product.productId = 1 ";
			}
			/*
			elseif ( $get["sType"] == "discount" ) {
				$sWhere .= "productimpact.productimpactDiscountRate is not null and productimpact.productimpactDiscountRate > 0 ";
			}
			*/
	
		}
	
	
	
		/*
		 * SQL queries
		* Get data to display
		*/
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS product.productId, product.productCode, product.productTitle,
			productattribute.productattributeId, productattribute.productattributeQuantity, COUNT(product_picture.pictureId)
			FROM productattribute
			LEFT JOIN product ON product.productId = productattribute.productId
			LEFT JOIN product_picture ON product_picture.productId = product.productId
			LEFT JOIN productgroup_product ON productgroup_product.productId = product.productId
			LEFT JOIN product_category ON product_category.productId = product.productId
			LEFT JOIN productgroup ON productgroup.productgroupId = productgroup_product.productgroupId
			LEFT JOIN productgroup_i18n ON productgroup_i18n.productgroupId = productgroup.productgroupId and productgroup_i18n.iso639Id = :iso639
			$sWhere
			GROUP BY productattribute.productId
			HAVING COUNT(product_picture.pictureId) > 0
			$sOrder
			$sLimit
		";
		//echo $sQuery;exit;
		$rResult = $this->run($sQuery, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"]));
		//print_r($rResult);exit;
	
	
		/* Data set length after filtering */
		$sQuery = "
				SELECT FOUND_ROWS() as iFilteredTotal
			";
		$aResultFilterTotal = $this->run($sQuery, PDO::FETCH_NUM);
		$iFilteredTotal = $aResultFilterTotal[0]["iFilteredTotal"];
		//echo $iFilteredTotal;exit;
	
		/* Total data set length */
		$sQuery = "
			SELECT SQL_CALC_FOUND_ROWS product.productId
			FROM productattribute
			LEFT JOIN product ON product.productId = productattribute.productId
			LEFT JOIN product_picture ON product_picture.productId = product.productId
			$sWhere
			GROUP BY productattribute.productId
			HAVING COUNT(product_picture.pictureId) > 0
		";
		$aResultTotal = $this->run($sQuery);
		$sQuery = "
				SELECT FOUND_ROWS() as iTotal
			";
		$aResultTotal = $this->run($sQuery, PDO::FETCH_NUM);
		$iTotal = $aResultTotal[0]["iTotal"];
		//echo $iTotal;exit;
	
	
		/*
		 * Output
		*/
		$output = array(
			"sEcho" => intval($get['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		//print_r($output);exit;
	
	
		foreach ($rResult as $aRow)
		{
			/*
			 $row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
			if ( $aColumns[$i] == "version" )
			{
			// Special output formatting for 'version' column
			$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
			}
			else if ( $aColumns[$i] != ' ' )
			{
			// General output
			$row[] = $aRow[ $aColumns[$i] ];
			}
			}
			$output['aaData'][] = $row;
			*/
			$output['aaData'][] = $this->getProductattributeByProductId($aRow["productId"]);
		}
		//print_r($output);exit;
	
	
		if ( isset($get['callback']) )
		{
			return $get['callback'].'('.json_encode( $output ).');';
		}
		else
		{
			if($json)
				return json_encode( $output );
			else
				return $output;
		}
	
	}
	
	function getProductattributeByProductattributeId($productattributeId)
	{
		global $smarty;
		
		$roleId = ($roleId==null)?(isset($_SESSION["roleId"])?$_SESSION["roleId"]:$smarty->getVariable("_USER_ROLE_B2C")):$roleId;
		
		$sQuery = "
			SELECT 
			view_productattributeprice.*,
			picture.*,
			productimpact.*,
			product.*,
			productattribute.*
			FROM productattribute
			LEFT JOIN product ON product.productId = productattribute.productId
			LEFT JOIN productimpact ON productimpact.productId = product.productId
			LEFT JOIN product_picture ON product_picture.productId = product.productId AND product_picture.isDefault = true 
			LEFT JOIN picture ON picture.pictureId = product_picture.pictureId
			LEFT JOIN view_productattributeprice ON view_productattributeprice.productattributeId = productattribute.productattributeId AND view_productattributeprice.roleId = ".$roleId."
			WHERE productattribute.productattributeId = :productattributeId
		";
		//echo $sQuery;exit;
	
		$rows = $this->run($sQuery, array("productattributeId" => $productattributeId));
		$row = $rows[0];
		
		$currency = new Currency;
		$row["productattributepriceMCur"]	= $currency->formatWithCurrency($row["productattributepriceM"]);
		$row["productattributepriceMDCur"]	= $currency->formatWithCurrency($row["productattributepriceMD"]);
		$row["productattributepriceMVCur"]	= $currency->formatWithCurrency($row["productattributepriceMV"]);
		$row["productattributepriceMDVCur"]	= $currency->formatWithCurrency($row["productattributepriceMDV"]);
		//print_r($row);exit;
		
		$product = new Product;
		$row["picture"] = $product->getPictures($row["productId"]);
		
		$category = new Category;
		$row["category"] = $category->getCategoriesByProductId($row["productId"], $row["categoryId"]);

		$row["attribute"] = $this->getAttributeIdsByProductattributeId2($productattributeId);
		//print_r($row);exit;
		
		$productattributeIds = $this->getProductattributeIdsByProductId($row["productId"]);
		//print_r($productattributeIds);exit;
		
		$attributeIds = $this->getAttributeIdsByProductattributeId($productattributeId);
		//print_r($attributeIds);exit;
		
		$row["attributegroups"] = $this->getAttributegroupsByProductattributeIds(explode(",", $productattributeIds), $attributeIds);
		//print_r($row);exit;
		
		$row["isInWishlist"] = ($product->isInWishlist($row["productId"]))?true:false;
		
		//print_r($row);exit;
		return ($row);
	}
	
	function getProductattributeByProductId($productId, $attributeIds=null, $roleId=null)
	{
		$sQuery = "
			SELECT 
			product.*,
			productattribute.*
			FROM productattribute
			LEFT JOIN product ON product.productId = productattribute.productId
			LEFT JOIN product_picture ON product_picture.productId = product.productId
		";
		
		if ($attributeIds != null && is_array($attributeIds)) {
			foreach ($attributeIds as $k=>$attributeId) {
				$sQuery .= "
					LEFT JOIN productattribute_attribute as t$k on t$k.productattributeId = productattribute.productattributeId
				";
			}
		}
		
		$sQuery .= "
			WHERE productattribute.productId = :productId
			AND productattribute.productattributeQuantity > 0
		";
		
		if ($attributeIds != null && is_array($attributeIds)) {
			foreach ($attributeIds as $k=>$attributeId) {
				$sQuery .= "
					AND t$k.attributeId = $attributeId
				";
			}
		}
		
		$sQuery .= "
			GROUP BY productattribute.productId
			HAVING COUNT(product_picture.pictureId) > 0
		";
		//echo $sQuery;exit;
		
		$rows = $this->run($sQuery, array("productId"=>$productId));
		$row = $rows[0];
		if ($row == null) return null;
		$productattributeId = $row["productattributeId"];
		//print_r($productattributeId);exit;
		$row = $this->getProductattributeByProductattributeId($productattributeId);
		//print_r($row);exit;
		return ($row);
	}
	
	function getProductattributeByProductattributeCode($productattributeCode)
	{
		$rows = $this->select($this->sTable, "productattributeCode = :productattributeCode", array(":productattributeCode" => $productattributeCode));
		return $rows[0];
	}
	
	function getProductattributeWithAttributeIds($productattributeId)
	{
		//$row = $this->getEntry($productattributeId);
		//$row["attributeIds"] = $this->getAttributeIdsByProductattributeId($productattributeId);
		//return $row;
		
		$sql = array();
		array_push($sql, "select *");
		array_push($sql, "from view_productattributeprice");
		array_push($sql, "where productattributeId = :productattributeId");
		$sql = implode(" ", $sql);
		//echo($sql);exit;
		
		$rows = $this->run($sql, array("productattributeId"=>$productattributeId));
		$row = $rows[0];
		return $rows;
	}
	
	function getAttributeIdsByProductattributeId($productattributeId)
	{
		$sql = array();
		array_push($sql, "select *");
		array_push($sql, "from productattribute_attribute");
		array_push($sql, "where productattributeId = :productattributeId");
		$sql = implode(" ", $sql);
		//echo($sql);exit;
		
		$rows = $this->run($sql, array("productattributeId"=>$productattributeId));
		foreach ($rows as $row) {
			$arr[] = $row["attributeId"];
		}
		return ($arr);
	}
	
	function getAttributeIdsByProductattributeId2($productattributeId)
	{
		$sQuery = "
			SELECT 
			GROUP_CONCAT(productattribute_attribute.attributeId) AS attributeIds
			FROM productattribute_attribute
			WHERE productattributeId = :productattributeId
		";
		//echo $sQuery;exit;
	
		$rows = $this->run($sQuery, array("productattributeId"=>$productattributeId));
		$attributeIds = $rows[0]["attributeIds"];
		//return $rows[0]["attributeIds"];
		
		$sQuery = "
			SELECT 
			attributegroup_i18n.*,
			attributegroup.*,
			attribute_i18n.*,
			attribute.*
			FROM attribute
			LEFT JOIN attribute_i18n ON attribute_i18n.attributeId = attribute.attributeId AND attribute_i18n.iso639Id = :iso639
			LEFT JOIN attributegroup ON attributegroup.attributegroupId = attribute.attributegroupId
			LEFT JOIN attributegroup_i18n ON attributegroup_i18n.attributegroupId = attributegroup.attributegroupId AND attributegroup_i18n.iso639Id = :iso639
			WHERE
			attribute.attributeId IN (".$attributeIds.")
			ORDER BY attributegroup.attributegroupId
		";
		//echo $sQuery;exit;
		
		$rows = $this->run($sQuery, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"]));
		return $rows;
	}
	
	function getProductattributeIdsByProductId($productId)
	{
		$sQuery = "
			SELECT GROUP_CONCAT(productattributeId) AS productattributeIds
			FROM productattribute
			WHERE productId = :productId
		";
		//echo $sQuery;exit;
		
		$rows = $this->run($sQuery, array("productId"=>$productId));
		return $rows[0]["productattributeIds"];
	}

	function getAttributegroupsByProductattributeIds($productattributeIds, $attributeIds=null)
	{
		if ($productattributeIds == null) return null;
		if (is_string($productattributeIds) || is_int($productattributeIds)) $productattributeIds = (array) $productattributeIds;
		
		$sql = array();
		array_push($sql, "SELECT");
		array_push($sql, "attributegroup.attributegroupId,");
		array_push($sql, "attributegroup_i18n.attributegroupTitle");
		array_push($sql, "FROM productattribute_attribute");
		array_push($sql, "LEFT JOIN attribute on attribute.attributeId = productattribute_attribute.attributeId");
		array_push($sql, "LEFT JOIN attributegroup on attributegroup.attributegroupId = attribute.attributegroupId");
		array_push($sql, "LEFT JOIN attributegroup_i18n on attributegroup_i18n.attributegroupId = attributegroup.attributegroupId AND attributegroup_i18n.iso639Id = :iso639");
		foreach ($productattributeIds as $k=>$productattributeId) {
			$str = ($k==0)?"WHERE":"OR";
			array_push($sql, "$str productattribute_attribute.productattributeId = $productattributeId");
		}
		array_push($sql, "GROUP BY attribute.attributegroupId");
		$sql = implode(" ", $sql);
		//echo($sql);exit;
		
		$rows = $this->run($sql, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"]));

		$i=0;
		foreach ($rows as $row) {
			$arr[$i] = $row;
			$attributes = $this->getAttributesByProductattributeIds($row["attributegroupId"], $productattributeIds);
			if (is_array($attributes)) {
				$arr[$i]["attributes"] = $attributes;
				$arr[$i]["attributes"]["selected"] = (empty($attributeIds))?null:array_intersect(array_keys($arr[$i]["attributes"]["options"]), $attributeIds);
			}
			$i++;
		}
		//print_r($arr);exit;
		return ($arr);
	}


	function getAttributesByProductattributeIds($attributegroupId, $productattributeIds)
	{
		if ($productattributeIds == null) return null;

		$sql = array();
		array_push($sql, "SELECT");
		array_push($sql, "attribute.*,");
		array_push($sql, "attribute_i18n.*");
		array_push($sql, "FROM productattribute_attribute");
		array_push($sql, "LEFT JOIN attribute on attribute.attributeId = productattribute_attribute.attributeId");
		array_push($sql, "LEFT JOIN attribute_i18n on attribute_i18n.attributeId = attribute.attributeId AND attribute_i18n.iso639Id = :iso639");
		array_push($sql, "WHERE attribute.attributegroupId = :attributegroupId");
		foreach ($productattributeIds as $k=>$productattributeId) {
			$str = ($k==0)?"AND (":"OR";
			array_push($sql, "$str productattribute_attribute.productattributeId = $productattributeId");
		}
		array_push($sql, ")");
		array_push($sql, "GROUP BY productattribute_attribute.attributeId");
		$sql = implode(" ", $sql);
		//echo($sql);exit;
		
		$rows = $this->run($sql, array("iso639"=>$_SESSION["PROJECT_LANGUAGE"], "attributegroupId"=>$attributegroupId));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach($rows as $row) {
			$arr["aaData"][$i] = $row;
			$arr["options"][$row["attributeId"]] = $row["attributeTitle"];
			$i++;
		}
		return ($arr);
		
	}
	

	function getProductattributesFromBasket()
	{
		$pb = $_COOKIE["productattributebasket"];
		if(!$pb) return false;
		
		$currency = new Currency;
		
		$arr["iTotalRecords"] = count($pb);
		$i=0;
		foreach ($pb as $productattributeId=>$productattributebasketQuantity) {
			$arr["aaData"][$i]["productattributebasketQuantity"] = $productattributebasketQuantity;
			$pa = $this->getProductattributeByProductattributeId($productattributeId);
			$arr["aaData"][$i]["productattribute"] = $pa;
			
			$arr["aaData"][$i]["productattributebasketSubtotal"] = $pa["productattributepriceMDV"] * $productattributebasketQuantity;
			$arr["aaData"][$i]["productattributebasketSubtotalCur"] = $currency->formatWithCurrency($arr["aaData"][$i]["productattributebasketSubtotal"]);
			
			$arr["productattributebasketQuantityTotal"] += $productattributebasketQuantity;
			$arr["productattributebasketTotal"] += $arr["aaData"][$i]["productattributebasketSubtotal"];
			$arr["productattributebasketTotalCur"] = $currency->formatWithCurrency($arr["productattributebasketTotal"]);
			
			
			
			//$arr["aaData"][$i]["productattribute"]["attribute"] = $this->getAttributeIdsByProductattributeId2($productattributeId);
			
			//$ps = $this->getProductattributeWithAttributeIds($productattributeId);
			//$arr["aaData"][$i]["productattribute"] = $ps;
			
			//$productId = $pa["productId"];
			//$attributeIds = $this->getAttributeIdsByProductattributeId($productattributeId);
			//$arr["aaData"][$i]["productattribute"] = $this->getProductattributeByProductId($productId, $attributeIds);
			
			/*
			$attributeIds = $ps["attributeIds"];
			if ($attributeIds != null) {
				$j=0;
				foreach ($attributeIds as $attributeId) {
					$attribute = new Attribute;
					$fv = $attribute->getAttribute($attributeId);
					$arr["aaData"][$i]["productattribute"]["attribute"][$j] = $fv;
					$attributes[$j] = $fv["attributegroupTitle"].":".$fv["attributeTitle"];
					$j++;
				}
			}
			
			$arr["aaData"][$i]["product"] = $this->getProductattributeByProductId($ps["productId"]);
			$arr["aaData"][$i]["productattributebasketSubtotal"] = $arr["aaData"][$i]["product"]["productattributepriceMDV"] * $productattributebasketQuantity;
			$arr["aaData"][$i]["productattributebasketSubtotalCur"] = $currency->formatWithCurrency($arr["aaData"][$i]["productattributebasketSubtotal"]);

			$arr["productattributebasketQuantityTotal"] += $productattributebasketQuantity;
			$arr["productattributebasketTotal"] += $arr["aaData"][$i]["productattributebasketSubtotal"];
			$arr["productattributebasketTotalCur"] = $currency->formatWithCurrency($arr["productattributebasketTotal"]);
			*/
			
			$i++;
		}
		
		//print_r($arr);exit;
		return ($arr);
	}

}