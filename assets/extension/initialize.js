$(InitializePortapp);

// Predefined Variables
var global_settings = {};
var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
var emailblockReg = /^([\w-\.]+@(?!gmail.com)(?!yahoo.com)(?!hotmail.com)([\w-]+\.)+[\w-]{2,4})?$/;

// Class Variables
var Attributegroup;
var Attributeimpact;
var Banner;
var Brand;
var Category;
var CommonItems;
var Company;
var GMAPHelper;
var Iso639;
var Payment;
var Postaladdress;
var Productattribute;
var Productattributemovement;
var Productcomment;
var Productimpact;
var Productorder;
var Survey;
var Transportation;
var User;
var Userticket;
var Voucher;


function InitializePortapp()
{
	var defaults = {
		use_jqzoom: true
	};

	global_settings = $.extend(defaults, global_settings);
	
	fixMenus();
	fixContentsWidth();
}

function fixMenus()
{
	var currentLink = window.location.href;
	
	if(currentLink.match(/productgroupId=[0-9]+/))
	{
		var match = currentLink.match(/productgroupId=[0-9]+/).toString();
		var matchedArray = match.split('=');
		var productgroupId = matchedArray[1];
		$("#menuOuter a[href*='productgroupId=" + productgroupId + "']").addClass("selected");
	}
	else if(currentLink.match(/pageId=[0-9]+/))
	{
		var match = currentLink.match(/pageId=[0-9]+/).toString();
		var matchedArray = match.split('=');
		var pageId = matchedArray[1];
		$("#menuOuter a[href*='pageId=" + pageId + "']").addClass("selected");
	}
}

function fixContentsWidth()
{
	var leftBar =$("#leftBarOuter");
	var rightBar =$("#rightBarOuter");
	var contents=  $("#contentsOuter");
	var wholeContents =  $("#wholeContentsOuter");
	var hasLeftBar =leftBar.length > 0 ? true : false;
	var hasRightBar  =rightBar.length > 0 ? true : false;
	var leftBarWidth  =hasLeftBar ? parseInt(leftBar.outerWidth(true)) : 0;
	var rightBarWidth  =hasRightBar ? parseInt(rightBar.outerWidth(true)) : 0;
	var contentsWidth  =parseInt(contents.outerWidth(true)); // margin değerini hesaa katmak istersen outerWidth(true) olarak kullan
	var wholeContentsWidth  =  parseInt(wholeContents.width());
	var calculatedWidth =  0;

	if(!hasLeftBar || !hasRightBar )
	{
		var calculatedWidth = 0;
		if(!hasLeftBar && !hasRightBar)
		{
			calculatedWidth = wholeContentsWidth - (leftBarWidth + rightBarWidth);
		}
		else if(!hasLeftBar)
		{
			calculatedWidth = wholeContentsWidth - rightBarWidth;
		}
		else
		{
			calculatedWidth = wholeContentsWidth - leftBarWidth;
			//alert("right: " + rightBar.length);
		}
	
		// contents objesinin margin, padding ve border değerlerinin toplamını 
		// alıp kullanacağın genişlik değerinden çıkarki taşma olmasın
		var extraWidth = contentsWidth - parseInt(contents.width()); 
		calculatedWidth -= extraWidth;
	
		contents.width(calculatedWidth);
	}
	 
	// Fix CasContents
	contents.find(".casContent").each(function(){
		var usableArea = $(this).parent();
		var usableWidth  = parseInt(usableArea.width());
		var thisWidth = parseInt($(this).width()); 
		var thisExtraWidth = parseInt($(this).outerWidth()) - thisWidth; // margin değerini hesaa katmak istersen outerWidth(true) olarak kullan
		var calculatedWidth = usableWidth - thisExtraWidth;
		$(this).width(calculatedWidth);
	});
}


// EXTEND JQUERY  -------------------------------------------------------------------------------------------------
$.extend({
	getCss: function(url, media) {
	 jQuery(document.createElement('link')).attr({
	  href	: url,
	  media	: media || 'screen',
	  type	: 'text/css',
	  rel		: 'stylesheet'
	 }).appendTo('head');
	},
	getUrlVars: function() {
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++) {
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	},
	getUrlVarsFromLink: function(link) {
		var vars = [], hash;
		var hashes = link.slice(link.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++) {
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	},
	getUrlVar: function(name){
		return $.getUrlVars()[name];
	},
	getUrlVarFromLink: function(link, name){
		return $.getUrlVarsFromLink(link)[name];
	}
});

jQuery.fn.cleanWhitespace = function() {
	var op = this.val().replace(/\s/gi,'');
	this.val(op);
	return op;
};
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





