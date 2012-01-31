<?php
class Product extends CasBase
{

	function __construct()
	{
		parent::__construct();

		$this->sTable		= strtolower(__CLASS__);

		$this->aAllField		= array("productId", "productCode", "productTitle", "productContent", "productVideo", "productHit", "categoryId", "brandId", "taxonomyId", "warrantyId");
		$this->sIndexColumn		= "productId";
		$this->sIndexColumnFull	= $this->sTable.".".$this->sIndexColumn;

		$this->sSortingColumn		= $this->sIndexColumn;
		$this->sSortingColumnFull	= $this->sTable.".".$this->sSortingColumn;

		$this->sTitleColumn		= $this->sTable."Title";
		$this->sTitleColumnFull	= $this->sTable.".".$this->sTitleColumn;

	}
	
	function getNumberOfUsersinWishlistByProductgroupId($productgroupId)
	{
		$sql = "SELECT ";
		$sql .= "COUNT(product_user.userId) AS numberOfUsers, ";
		$sql .= "product.productCode, ";
		$sql .= "product.productTitle, ";
		$sql .= "product.productId ";
		$sql .= "FROM productgroup_product ";
		$sql .= "LEFT JOIN product_user ON product_user.productId = productgroup_product.productId ";
		$sql .= "LEFT JOIN product ON product.productId = productgroup_product.productId ";
		$sql .= "WHERE productgroup_product.productgroupId = :productgroupId ";
		$sql .= "GROUP BY productgroup_product.productId ";

		return $this->run($sql, array("productgroupId"=>$productgroupId));
		
	}	
	
	function getUsersinWishlistByProductId($productId)
	{
		$sql = "SELECT ";
		$sql .= "user.userFirstname, ";
		$sql .= "user.userLastname, ";
		$sql .= "user.userEmail ";
		$sql .= "FROM product_user ";
		$sql .= "LEFT JOIN user ON user.userId = product_user.userId ";
		$sql .= "WHERE product_user.productId = :productId ";

		return $this->run($sql, array("productId"=>$productId));
		
	}
		
	function isInWishlist($productId)
	{
		return $this->select("product_user", "userId = :userId AND productId = :productId", array("userId"=>$_SESSION["userId"], "productId"=>$productId));
	}
	
	function getProductsInWishlist()
	{
		$rows = $this->select("product_user", "userId = :userId", array("userId"=>$_SESSION["userId"]));
		$arr["iTotalRecords"] = count($rows);
		if ($arr["iTotalRecords"] > 0) {
			$i=0;
			$productattribute = new Productattribute();
			foreach ($rows as $row) {
				$arr["aaData"][$i] = $productattribute->getProductattributeByProductId($row["productId"]);
				$i++;
			}
		}
		return ($arr);
	}
	
	function setProductHit($productId)
	{
		$sql = "UPDATE product SET productHit=IF(productHit IS NULL, 1, productHit+1) WHERE productId=$productId";
		$this->run($sql);
	}
	
	function getProducts()
	{
		$rows = $this->select($this->sTable);
		$arr["iTotalRecords"] = count($rows);
		if ($arr["iTotalRecords"] > 0) {
			$i=0;
			foreach ($rows as $row) {
				$arr["aaData"][$i] = $row;
				$arr["options"][$row[$this->sIndexColumn]] = $row["productCode"] . ' - ' . $row[$this->sTitleColumn];
				$i++;
			}
		}
		return ($arr);
	}
	
	function getProductByProductId($productId)
	{
		$sQuery = "
			SELECT 
			taxonomy.*,
			product.*
			FROM product
			LEFT JOIN taxonomy ON taxonomy.taxonomyId = product.taxonomyId
			WHERE product.productId = :productId
		";
		$rows = $this->run($sQuery, array("productId" => $productId));
		$row = $rows[0];
		
		$category = new Category;
		$row["category"] = $category->getCategoriesByProductId($productId);
		
		$product = new Product;
		$row["picture"] = $product->getPictures($productId);
		
		//print_r($row);exit;
		return ($row);
	}
	
	function getProductattributesByProductId($productId)
	{
		$sQuery = "
			SELECT 
			productattribute.*
			FROM productattribute
			WHERE productattribute.productId = :productId
		";
		$rows = $this->run($sQuery, array("productId" => $productId));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		$productattribute = new Productattribute();
		foreach($rows as $row) {
			$arr["aaData"][$i] = $row;
			//$arr["options"][$row["attributeId"]] = $row["attributeTitle"];
			//$arr["aaData"][$i]["attributegroup"] = $productattribute->getAttributeIdsByProductattributeId($row["productattributeId"]);
			$arr["aaData"][$i]["attribute"] = $productattribute->getAttributeIdsByProductattributeId2($row["productattributeId"]);
			$i++;
		}
		//print_r($arr);exit;
		return ($arr);
	}
	
	function getProductimpactByProductId($productId)
	{
		$sQuery = "
			SELECT 
			taxonomy.*,
			role.*,
			productimpact.*
			FROM productimpact
			LEFT JOIN product ON product.productId = productimpact.productId
			LEFT JOIN taxonomy ON taxonomy.taxonomyId = product.taxonomyId
			LEFT JOIN role ON role.roleId = productimpact.roleId
			WHERE productimpact.productId = :productId
		";
		$rows = $this->run($sQuery, array("productId" => $productId));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach($rows as $row) {
			$arr["aaData"][$i] = $row;
			$i++;
		}
		//print_r($arr);exit;
		return ($arr);
	}

	function getAttributeimpactByProductId($productId)
	{
		$sQuery = "
			SELECT *
			FROM attributeimpact
			WHERE attributeimpact.productId = :productId
		";
		$rows = $this->run($sQuery, array("productId" => $productId));
		$arr["iTotalRecords"] = count($rows);
		$i=0;
		foreach($rows as $row) {
			$arr["aaData"][$i] = $row;
			$i++;
		}
		//print_r($arr);exit;
		return ($arr);
	}
	
	
	function getProductByProductCode($productCode)
	{
		$rows = $this->select($this->sTable, "productCode = :productCode", array(":productCode" => $productCode));
		return $rows[0];
	}

	function importXml($file)
	{
		$category = new Category;
		$productattribute = new Productattribute;
		$productattributemovement = new Productattributemovement;
		$attribute = new Attribute;

		$xmlstr = file_get_contents($file);
			
		$Root = new SimpleXMLElement($xmlstr);
			
			
		//$productattributeCode = "UrunID";
		$productattributeCode = "productattributeCode";
		//$productTitle = "UrunAdi";
		$productTitle = "productTitle";
		//$productContent = "UrunAciklamasi";
		$productContent = "productContent";
			
		//$colorCode = "RenkCode";
		$colorCode = "colorCode";
		$colorTitle = "colorTitle";
		//$sizeCode = "BedenCode";
		$sizeCode = "sizeCode";
		$sizeTitle = "sizeCode";//code ile title aynı olacak
			
		//$productattributemovementPriceOC = "ListeFiyat";
		$productattributemovementPriceOC = "productattributemovementPriceOC";
		//$priceDiscount = "OzelFiyat";
		$productimpactDiscountRate = "productimpactDiscountRate";
			
		//$productattributemovementQuantity = "StokAdedi";
		$productattributemovementQuantity = "productattributemovementQuantity";
		//$productCode = "VaryantGroupID";
		$productCode = "productCode";
			
		$categoryCode = "categoryCode";
		//$categoryTitle = "KategoriAdi";
		$categoryTitle = "categoryTitle";
			
			
		foreach ($Root->Row as $row)
		{

			// attribute
			$attributegroupId = 1;/*RENK*/
			if ($fv = $attribute->getAttributeByAttributeCodeAndAttributegroupId($row->{$colorCode}, $attributegroupId)) {
				$attributeIdForColor = $fv["attributeId"];
				$attribute->update(
				$attribute->sTable,
				array(
						"attributeCode"=>$row->{$colorCode}
				),
					"attributeId = :attributeId",
				array(
						"attributeId"=>$attributeIdForColor
				)
				);
				$attribute->update(
					"attribute_i18n",
				array(
					"attributeTitle"=>$row->{$colorTitle}
				),
					"attributeId = :attributeId and iso639Id = :iso639",
				array(
						"attributeId"=>$attributeIdForColor,
						"iso639"=>1
				)
				);
			}
			else {
				$attribute->insert(
				$attribute->sTable,
				array(
						"attributegroupId"=>$attributegroupId,
						"attributeCode"=>$row->{$colorCode}
				)
				);
				$rows = $attribute->run("select LAST_INSERT_ID() as last_insert_id;");
				$attributeIdForColor = $rows[0]["last_insert_id"];
				$attribute->insert(
					"attribute_i18n",
				array(
						"attributeId"=>$attributeIdForColor,
						"iso639Id"=>1,
						"attributeTitle"=>$row->{$colorTitle}
				)
				);
			}


			$attributegroupId = 2;/*BEDEN*/
			if ($fv = $attribute->getAttributeByAttributeCodeAndAttributegroupId($row->{$sizeCode}, $attributegroupId)) {
				$attributeIdForSize = $fv["attributeId"];
				$attribute->update(
				$attribute->sTable,
				array(
						"attributeCode"=>$row->{$sizeCode}
				),
					"attributeId = :attributeId",
				array(
						"attributeId"=>$attributeIdForSize
				)
				);
				$attribute->update(
					"attribute_i18n",
				array(
						"attributeTitle"=>$row->{$sizeTitle}
				),
					"attributeId = :attributeId and iso639Id = :iso639",
				array(
						"attributeId"=>$attributeIdForSize,
						"iso639"=>1
				)
				);
			}
			else {
				$attribute->insert(
				$attribute->sTable,
				array(
						"attributegroupId"=>$attributegroupId,
						"attributeCode"=>$row->{$sizeCode}
				)
				);
				$rows = $attribute->run("select LAST_INSERT_ID() as last_insert_id;");
				$attributeIdForSize = $rows[0]["last_insert_id"];
				$attribute->insert(
					"attribute_i18n",
				array(
						"attributeId"=>$attributeIdForSize,
						"iso639Id"=>1,
						"attributeTitle"=>$row->{$sizeTitle}
				)
				);
			}


			// category
			if ($c = $category->getCategoryByCategoryCode($row->{$categoryCode})) {
				$categoryId = $c["categoryId"];
				$category->update(
				$category->sTable,
				array(
						"categoryCode"=>$row->{$categoryCode}
				),
					"categoryId = :categoryId",
				array(
						"categoryId"=>$categoryId
				)
				);
				$category->update(
					"category_i18n",
				array(
						"categoryTitle"=>$row->{$categoryTitle}
				),
					"categoryId = :categoryId and iso639Id = :iso639",
				array(
						"categoryId"=>$categoryId,
						"iso639"=>1
				)
				);
			}
			else {
				$category->insert(
				$category->sTable,
				array(
						"categoryCode"=>$row->{$categoryCode}
				)
				);
				$rows = $category->run("select LAST_INSERT_ID() as last_insert_id;");
				$categoryId = $rows[0]["last_insert_id"];
				$category->insert(
					"category_i18n",
				array(
						"categoryId"=>$categoryId,
						"iso639Id"=>1,
						"categoryTitle"=>$row->{$categoryTitle}
				)
				);
			}


			//productattributeCode check
			if ($ps = $productattribute->getProductattributeByProductattributeCode($row->{$productattributeCode}))
			{
					
				$productattributeId = $ps["productattributeId"];
				$productId = $ps["productId"];
					
				// product update
				$this->update(
				$this->sTable,
				array(
						"productimpactDiscountRate"=>$row->{$productimpactDiscountRate},
						"productTitle"=>$row->{$productTitle},
						"productContent"=>$row->{$productContent},
						"brandId"=>1,
						"categoryId"=>$categoryId
				),
					"productId = :productId",
				array(
						"productId"=>$productId
				)
				);
					
					
				//productattribute update
				$productattribute->update(
				$productattribute->sTable,
				array(
						"warrantyId"=>1
				),
					"productattributeId = :productattributeId",
				array(
						"productattributeId"=>$productattributeId
				)
				);
					
				//$productimpactDiscountRate = number_format(($row->{$productattributemovementPriceOC}-$row->{$priceDiscount})/$row->{$productattributemovementPriceOC}, 2);
					
				//productattributemovement check by productattributeId
				if ($pam = $productattributemovement->getProductattributemovementByProductattributeId($productattributeId)) {
					//productattributemovement update
					$productattributemovement->update(
						$productattributemovement->sTable,
						array(
							"productattributemovementQuantity"=>$row->{$productattributemovementQuantity},
							"productattributemovementPriceOC"=>$row->{$productattributemovementPriceOC},
							"currencyId"=>1,
							"productattributemovementDate"=>date("Y-m-d"),
							"supplierId"=>1
						),
						"productattributeId = :productattributeId",
						array(
							"productattributeId"=>$productattributeId
						)
					);
				}
				else {
					//productattributemovement insert
					$productattributemovement->insert(
						$productattributemovement->sTable,
						array(
							"productattributeId"=>$productattributeId,
							"productattributemovementQuantity"=>$row->{$productattributemovementQuantity},
							"productattributemovementPriceOC"=>$row->{$productattributemovementPriceOC},
							"currencyId"=>1,
							"productattributemovementDate"=>date("Y-m-d"),
							"supplierId"=>1
						)
					);
				}
					
					
			}
			else {
					
				//productId check
				if ($p = $this->getProductByProductCode($row->{$productCode})) {
					$productId = $p["productId"];
					$this->update(
					$this->sTable,
					array(
							"productimpactDiscountRate"=>$row->{$productimpactDiscountRate},
							"productTitle"=>$row->{$productTitle},
							"productContent"=>$row->{$productContent},
							"brandId"=>1,
							"categoryId"=>$categoryId
					),
						"productId = :productId",
					array(
							"productId"=>$productId
					)
					);
				}
				else {
					$this->insert(
					$this->sTable,
					array(
							"productimpactDiscountRate"=>$row->{$productimpactDiscountRate},
							"productCode"=>$row->{$productCode},
							"productTitle"=>$row->{$productTitle},
							"productContent"=>$row->{$productContent},
							"brandId"=>1,
							"categoryId"=>$categoryId
					)
					);
					$rows = $this->run("select LAST_INSERT_ID() as last_insert_id;");
					$productId = $rows[0]["last_insert_id"];
				}
					
					
				//productattribute insert
				$productattribute->insert(
				$productattribute->sTable,
				array(
						"productattributeCode"=>$row->{$productattributeCode},
						"productId"=>$productId,
						"warrantyId"=>1
				)
				);
				$rows = $productattribute->run("select LAST_INSERT_ID() as last_insert_id;");
				$productattributeId = $rows[0]["last_insert_id"];
					
					
				//productattributemovement insert
				$productattributemovement->insert(
				$productattributemovement->sTable,
				array(
						"productattributeId"=>$productattributeId,
						"productattributemovementQuantity"=>$row->{$productattributemovementQuantity},
						"productattributemovementPriceOC"=>$row->{$productattributemovementPriceOC},
						"currencyId"=>1,
						"productattributemovementDate"=>date("Y-m-d"),
						"supplierId"=>1
				)
				);
					
					
			}


			//insert product_category
			$category->insert(
				"product_category",
			array(
					"categoryId"=>$categoryId,
					"productId"=>$productId
			)
			);


			//productattribute_attribute insert for color
			$productattribute->insert(
				"productattribute_attribute",
			array(
					"productattributeId"=>$productattributeId,
					"attributeId"=>$attributeIdForColor
			)
			);
			//productattribute_attribute insert for size
			$productattribute->insert(
				"productattribute_attribute",
			array(
					"productattributeId"=>$productattributeId,
					"attributeId"=>$attributeIdForSize
			)
			);

		}
	}


	function saveProduct($formvars)
	{
		$table = $this->sTable;
		$where = $this->sIndexColumn . " = :id";
		$bind = array("id"=>$formvars[$this->sIndexColumn]);

		if (!empty($formvars[$this->sIndexColumn]) && $rows = $this->select($table, $where, $bind))
		{
			$this->update($table, $formvars, $where, $bind);
			$id = $formvars[$this->sIndexColumn];
		}
		else
		{
			$this->insert($table, $formvars);
			$rows = $this->run("select LAST_INSERT_ID() as last_insert_id;");
			$id = $rows[0]["last_insert_id"];
		}

		$this->delete("product_category", $this->sIndexColumn." = :id", array("id"=>$id));
		foreach ($formvars["categoryIds"] as $categoryId) {
			$this->insert("product_category", array($this->sIndexColumn=>$id, "categoryId"=>$categoryId));
		}
		
		return $id;
	}

}