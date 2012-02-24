<?php
/**/
require(dirname(__FILE__) . '/../classes/lib/cas.database.php');
require(dirname(__FILE__) . '/../classes/lib/cas.base.php');
require(dirname(__FILE__) . '/../classes/lib/cas.filesystem.php');
require(dirname(__FILE__) . '/../classes/lib/cas.string.php');
require(dirname(__FILE__) . '/../classes/lib/cas.mailer.php');
require(dirname(__FILE__) . '/../classes/lib/SimpleImage.php');

// PEAR
//require_once('Pager.php');

require(dirname(__FILE__) . '/../classes/model/Attribute.php');
require(dirname(__FILE__) . '/../classes/model/Attributegroup.php');
require(dirname(__FILE__) . '/../classes/model/Attributeimpact.php');
require(dirname(__FILE__) . '/../classes/model/Bank.php');
require(dirname(__FILE__) . '/../classes/model/Bankbin.php');
require(dirname(__FILE__) . '/../classes/model/Banner.php');
require(dirname(__FILE__) . '/../classes/model/Brand.php');
require(dirname(__FILE__) . '/../classes/model/Category.php');
require(dirname(__FILE__) . '/../classes/model/Company.php');
require(dirname(__FILE__) . '/../classes/model/Creditcard.php');
require(dirname(__FILE__) . '/../classes/model/Currency.php');
require(dirname(__FILE__) . '/../classes/model/Fxrate.php');
require(dirname(__FILE__) . '/../classes/model/Iso639.php');
require(dirname(__FILE__) . '/../classes/model/Livetv.php');
require(dirname(__FILE__) . '/../classes/model/Messaging.php');
require(dirname(__FILE__) . '/../classes/model/Optinout.php');
require(dirname(__FILE__) . '/../classes/model/Page.php');
require(dirname(__FILE__) . '/../classes/model/Payment.php');
require(dirname(__FILE__) . '/../classes/model/Paymentgroup.php');
require(dirname(__FILE__) . '/../classes/model/Permission.php');
require(dirname(__FILE__) . '/../classes/model/Picture.php');
require(dirname(__FILE__) . '/../classes/model/Postaladdress.php');
require(dirname(__FILE__) . '/../classes/model/Product.php');
require(dirname(__FILE__) . '/../classes/model/Productattribute.php');
require(dirname(__FILE__) . '/../classes/model/Productattributemovement.php');
require(dirname(__FILE__) . '/../classes/model/Productcomment.php');
require(dirname(__FILE__) . '/../classes/model/Salescampaign.php');
require(dirname(__FILE__) . '/../classes/model/Productgroup.php');
require(dirname(__FILE__) . '/../classes/model/Productimpact.php');
require(dirname(__FILE__) . '/../classes/model/ProductOdbc.php');
require(dirname(__FILE__) . '/../classes/model/Productorder.php');
require(dirname(__FILE__) . '/../classes/model/Productorderstatus.php');
require(dirname(__FILE__) . '/../classes/model/Productsalesmovement.php');
require(dirname(__FILE__) . '/../classes/model/Retailer.php');
require(dirname(__FILE__) . '/../classes/model/Role.php');
require(dirname(__FILE__) . '/../classes/model/Setting.php');
require(dirname(__FILE__) . '/../classes/model/Supplier.php');
require(dirname(__FILE__) . '/../classes/model/Survey.php');
require(dirname(__FILE__) . '/../classes/model/Taxonomy.php');
require(dirname(__FILE__) . '/../classes/model/Transportation.php');
require(dirname(__FILE__) . '/../classes/model/User.php');
require(dirname(__FILE__) . '/../classes/model/Usergroup.php');
require(dirname(__FILE__) . '/../classes/model/Userpoint.php');
require(dirname(__FILE__) . '/../classes/model/Userpointtype.php');
require(dirname(__FILE__) . '/../classes/model/Userticket.php');
require(dirname(__FILE__) . '/../classes/model/Usertrack.php');
require(dirname(__FILE__) . '/../classes/model/Voucher.php');
require(dirname(__FILE__) . '/../classes/model/Warranty.php');


require(dirname(__FILE__) . '/../classes/bank/Akbank.php');
require(dirname(__FILE__) . '/../classes/bank/Denizbank.php');
require(dirname(__FILE__) . '/../classes/bank/Garanti.php');
require(dirname(__FILE__) . '/../classes/bank/YKB.php');

/**/

/*
require_once(dirname(__FILE__) . '/../classes/lib/AutoLoader.php');
$autoLoader = new AutoLoader();
$autoLoader->register();
*/
/*
function __autoload($className)
{
	if (!class_exists($className, false))
	{
		if (function_exists('smartyAutoload') AND smartyAutoload($className)) 
			return true;
		if (file_exists(dirname(__FILE__).'/../classes/'.$className.'.php'))
		{
			require_once(dirname(__FILE__).'/../classes/'.str_replace(chr(0), '', $className).'.php');
			if (file_exists(dirname(__FILE__).'/../override/classes/'.$className.'.php'))
				require_once(dirname(__FILE__).'/../override/classes/'.$className.'.php');
			else
			{
				$coreClass = new ReflectionClass($className.'Core');
				if ($coreClass->isAbstract())
					eval('abstract class '.$className.' extends '.$className.'Core {}');
				else
					eval('class '.$className.' extends '.$className.'Core {}');
			}
		}
		else
			return ;
	}
}
*/