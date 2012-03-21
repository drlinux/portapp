<?php
$JAVASCRIPT_FILES_LIST = "";

function addJavascript($path)
{
	global $JAVASCRIPT_FILES_LIST;
	
	$JAVASCRIPT_FILES_LIST .= '<script type="text/javascript" src="' . $path . '"></script>';
}

function loadWholeJavascripts()
{
	addJavascript("assets/extension/classes/Attributegroup.js");
	addJavascript("assets/extension/classes/Attributeimpact.js");
	addJavascript("assets/extension/classes/Banner.js");
	addJavascript("assets/extension/classes/Brand.js");
	addJavascript("assets/extension/classes/Category.js");
	addJavascript("assets/extension/classes/CommonItems.js");
	addJavascript("assets/extension/classes/Company.js");
	addJavascript("assets/extension/classes/GMAPHelper.js");
	addJavascript("assets/extension/classes/Iso639.js");
	addJavascript("assets/extension/classes/Page.js");
	addJavascript("assets/extension/classes/Payment.js");
	addJavascript("assets/extension/classes/Postaladdress.js");
	addJavascript("assets/extension/classes/Productattribute.js");
	addJavascript("assets/extension/classes/Productattributemovement.js");
	addJavascript("assets/extension/classes/Productcomment.js");
	addJavascript("assets/extension/classes/Productimpact.js");
	addJavascript("assets/extension/classes/Productorder.js");
	addJavascript("assets/extension/classes/Survey.js");
	addJavascript("assets/extension/classes/Transportation.js");
	addJavascript("assets/extension/classes/User.js");
	addJavascript("assets/extension/classes/Userticket.js");
	addJavascript("assets/extension/classes/Voucher.js");
}

addJavascript("assets/extension/classes/CommonItems.js");
addJavascript("assets/extension/classes/Productattribute.js");