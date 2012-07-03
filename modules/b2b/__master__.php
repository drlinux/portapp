<?php

$permission = new Permission;
$page = new Page();
$category = new Category();
$brand = new Brand();
$productattribute = new Productattribute;

$data["slider_theme"] = "default";

// MAIN MENU
$data["main_menu"] = $page->arrayPage(false, null);

// LOGIN MENU & PERSONAL INFO
if(Permission::checkPermission("b2b") || (basename($_SERVER["SCRIPT_FILENAME"], ".php") === "page"))
{
	$menuitems = $permission->arrayTree(30, null, 1);
	
	$menuHtml = '<ul>';
	foreach($menuitems as $mi)
	{
		$menuHtml .= '<li><a href="' . $mi["href"] . '">' . $mi["title"] . '</a></li>';
	}
	$menuHtml .= '</ul>';
}

$data["user_menu"] = $menuHtml;

// CATEGORIES MENU
$linkTemplate = '<a href="modules/b2b/category.php?action=show&categoryId={$categoryId}">{$categoryTitle}</a>';
$data["categories_menu"] = $category->htmlTree($linkTemplate);

// BRANDS MENU
$brands = $brand->getBrandsFromProductHavingPicture();
foreach($brands["aaData"] as $b)
{
	$brandsHtml .= '<li><a href="modules/b2b/brand.php?action=show&brandId=' . $b["brandId"] .'">' . $b["brandTitle"] . '</a></li>';
}
$data["brands_menu"] = $brandsHtml;


// FOOTER MENU
$data["footer_menu"] = $page->arrayPage(false, null);

// CONTRACTS MENU
$data["contracts_menu"] = $page->arrayPage(false, 6);


/*

// EXTRA PARAMETERS
$data["slider_theme"] = "default";

*/


//************************************************************************************************
// FUNCTIONS *************************************************************************************
//************************************************************************************************
function parseProductsList(&$products, &$result)
{
	foreach($products as $p)
	{
		$discountPercent = ($p["productimpactDiscountRate"] == null) ? "dn" : "";
		$discountCount = ($p["productimpactDiscountPrice"] == null) ? "dn" : "";
		$discountText = (($p["productimpactDiscountRate"] == null) && ($p["productimpactDiscountPrice"] == null)) ? "dn" : "";
		$oldCost = (($p["productimpactDiscountRate"] == null) && ($p["productimpactDiscountPrice"] == null)) ? "dn" : "";
	
		$result .= '<li class="productItem">
					<label class="labelDiscount">
						<span class="discountPercent ' . $discountPercent . '">% ' . ($p["productimpactDiscountRate"]*100) . '</span>
						<span class="discountCount ' . $discountCount . '">' . $p["productimpactDiscountPrice"] . '</span>
						<span class="discountText ' . $discountText . '">İndirimli Ürün</span>
					</label>
					<a href="modules/b2b/product.php?action=show&amp;productId=' . $p["productId"] . '" class="productLogoLink">
						<img src="img/product/3_' . $p["pictureFile"] . '" class="productLogo">
					</a>
					<span class="productName">' . $p["productTitle"] . '</span>
					<div class="costsOuter">
						<span class="oldCost ' . $oldCost .  '">
							' . $p["productattributepriceMVCur"] .  '
							<span class="cross"></span>
						</span>
						<span class="currentCost">' . $p["productattributepriceMDVCur"] . '</span>
					</div>
					<a class="btnAddToBasket" href="javascript:void(0);" onclick="Productattribute.updateProductattributebasket2(\'' . $p["productattributeId"] . '\', 1);">Sepete Ekle</a>
				</li>';
	}
}

function getBanners(&$result)
{
	$banner = new Banner();
	$banners = $banner->getBanners();
	
	foreach($banners["aaData"] as $b)
	{
		if($b["bannerHref"] == null)
			$result .= '<img src="img/banner/' . $b["pictureFile"]  . '" title="' . $b["bannerTitle"] . '" />';
		else
			$result .= '<a href="' . $b["bannerHref"] . '"><img src="img/banner/' . $b["pictureFile"]  . '" title="' . $b["bannerTitle"] . '" /></a>';
	}
}

function listCampaigns(&$result, $status = "active", $pictureOrderNum = 1)
{
	global $smarty;
	
	$LABEL_DAY = $smarty->getConfigVariable("LABEL_DAY");
	$LABEL_HOUR = $smarty->getConfigVariable("LABEL_HOUR");
	$LABEL_MINUTE = $smarty->getConfigVariable("LABEL_MINUTE");
	$LABEL_SECOND = $smarty->getConfigVariable("LABEL_SECOND");
	$LABEL_REMAINED = $smarty->getConfigVariable("LABEL_REMAINED");
	
	$campaign = new Salescampaign;
	
	$campaigns = $campaign->getSalescampaigns($status, $pictureOrderNum);
	$campaign_count = $campaigns["iTotalRecords"];
	
	for($i=0; $i<$campaign_count; $i++)
	{
		if($status === "active")
		{
			$remainingText  = "<span class='cDay'><span class='value'></span> $LABEL_DAY, </span>";
			$remainingText .= "<span class='cHour'><span class='value'></span> $LABEL_HOUR, </span>";
			$remainingText .= "<span class='cMinute'><span class='value'></span> $LABEL_MINUTE, </span>";
			$remainingText .= "<span class='cSecond'><span class='value'></span> $LABEL_SECOND </span>";
			$remainingText .= " $LABEL_REMAINED";
			
			$result .= "<li class='banner'><h2 class='name'>" . $campaigns["aaData"][$i]["salescampaignTitle"] . "</h2>";
			$result .= "<p class='timeLeft campaignTimer'>Kampanya Bitimine: <span style='color:#f00;'>" . $remainingText . "</span><span class='endTime' style='display:none;'>" . $campaigns["aaData"][$i]["salescampaignEnd"] . "</span></p>";
			$result .= "<a class='buy' href='modules/b2b/salescampaign.php?action=show&salescampaignId=" . $campaigns["aaData"][$i]["salescampaignId"] . "'>SATIN AL</a>";
			$result .= "<a class='imageLink' href='modules/b2b/salescampaign.php?action=show&salescampaignId=" . $campaigns["aaData"][$i]["salescampaignId"] . "'>";
			$result .= "<img src='img/salescampaign/" . $campaigns["aaData"][$i]["pictureFile"] . "' /></a></li>";
		}
		else if($status === "time_passed")
		{
			$result .= "<li class='banner'>";
			$result .= "<span class='soldOut'>tükendi</span>";
			$result .= "<img src='img/salescampaign/" . $campaigns["aaData"][$i]["pictureFile"] . "' />";
			$result .= "<span class='frame'></span>";
			$result .= "<span class='discountText'>%40 İndirim</span>";
			$result .= "</li>";
		}
	}
	
	if($campaign_count <= 0)
	{
		$result = "not_exist";
	}
}

// Campaigns Menu List
$campaign = new Salescampaign;
$campaigns = $campaign->getSalescampaigns("active", 1);
$campaign_count = $campaigns["iTotalRecords"];

for($i=0; $i<$campaign_count; $i++)
{
	$data["campaignsMenuList"] .= "<li><a href='modules/b2b/salescampaign.php?action=show&salescampaignId=" . $campaigns["aaData"][$i]["salescampaignId"] . "'>" . $campaigns["aaData"][$i]["salescampaignTitle"] . "</a></li>";
}