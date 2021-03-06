$(startDefault);

var global_settings = {};
var GMAPHelper;

function startDefault()
{
	var defaults = {
		use_jqzoom: true
	};

	global_settings = $.extend(defaults, global_settings);

	//////////////////////////////////////////////////////////////////////////////
	CommonItems = new CommonItems();
	Company = new Company;
	
	/*GMAPHelper = new GMAPHelper();
	GMAPHelper.loadMap();*/
	
	Productattributemovement = new Productattributemovement();
	Productattributemovement.getProductattributemovementByProductattributeId();

	Iso639 = new Iso639();
	Iso639.getBreadcrumbsIso639();
	
	Userticket = new Userticket();	
	
	Productcomment = new Productcomment();
	Productcomment.getProductcommentsByProductId();
	
	Productorder = new Productorder();
	
	Payment = new Payment();
	
	Transportation = new Transportation();
	
	Postaladdress = new Postaladdress();
	Postaladdress.getDeliveryaddresses();
	Postaladdress.getInvoiceaddresses();
	
	Page = new Page();
	Page.getPage();
	Page.getPageProducts();
	
	Productattribute = new Productattribute();
	Productattribute.whichShoppingbasket();
	Productattribute.checkProductattribute();
	Productattribute.getSearchResults();
	Productattribute.getSearchResultsSalescampaign();
	
	Productattribute.getProductsInWishlist();
	Productattribute.getProductsByProductgroupId();
	Productattribute.getProductsSimilar();
	Productattribute.getProductsByCategoryId();
	Productattribute.getProductsByBrandId();
	Productattribute.getProductgroups();
	
	Productattribute.getProductattributeByProductId();

	User = new User();
	User.getLoginoutButton();
	User.getLoginoutFormAndMenu();
	
	Banner = new Banner();
	Banner.getBanners();
	
	Brand = new Brand();
	Brand.getBrandsFromProductHavingPicture();

	Category = new Category();
	Category.getCategoriesFromProductHavingPicture();

	Survey = new Survey();
	Survey.getSurvey();
	Survey.editSurvey();
	
	Productimpact = new Productimpact();
	Productimpact.getProductimpactByProductId();
	
	Attributegroup = new Attributegroup();
	Attributegroup.getAttributegroupsWithAttributes();
	
	Attributeimpact = new Attributeimpact();
	Attributeimpact.getAttributeimpactByProductId();
	
	Voucher = new Voucher(); 
	
	$(document).bind("onMenuLoaded",function(){
		var currentLink = window.location.href;
		
		if(currentLink.match(/productgroupId=[0-9]+/))
		{
			var match = currentLink.match(/productgroupId=[0-9]+/).toString();
			var matchedArray = match.split('=');
			var productgroupId = matchedArray[1];
			$("#menuOuter a[href*='productgroupId=" + productgroupId + "']").addClass("selected");
		}
	});
	
	fixContentsWidth();
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
 

var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
var emailblockReg = /^([\w-\.]+@(?!gmail.com)(?!yahoo.com)(?!hotmail.com)([\w-]+\.)+[\w-]{2,4})?$/;


jQuery.fn.cleanWhitespace = function() {
	var op = this.val().replace(/\s/gi,'');
	this.val(op);
	return op;
};

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


function Userticket()
{
	var saveUserticket = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'saveUserticket' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						//console.log(response);
						if (response.success == true) {
							CommonItems.casDialog({
								content: jQuery.i18n.prop('ALERT_Completed')
							});
						}
						else {
							CommonItems.casDialog({
								content: response.msg//jQuery.i18n.prop('ALERT_ErrorOccured')
							});
						}
					}
				});
			},
			rules: {
				userticketName: {
					required: true
				},
				userticketEmail: {
					email: true,
					required: true
				},
				userticketPhone: {
					required: true
				},
				userticketSubject: {
					required: true
				},
				userticketMessage: {
					required: true
				}
			},
			messages: {
				userticketName: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userticketEmail: {
					email: jQuery.i18n.prop('ALERT_PleaseEnterAValidEmailAddress'),
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userticketPhone: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userticketSubject: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userticketMessage: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};
	
	var Obj = new Object();
	Obj.saveUserticket = saveUserticket;
	return Obj;
}

function Productcomment()
{
	var getProductcommentsByProductId = function ()
	{
		var $target = $('[cas-js=getProductcommentsByProductId]');
		if ($target.length) {
			var url = $target.attr("cas:url");
			var productId = $target.attr("cas:var");
			var tpl = $target.html();
			$target.html('');
			
			var formData = [];
			formData.push({ name: "action", value: "jsonProductcommentsByProductId" });
			formData.push({ name: "productId", value: productId });
			
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'get',
				data: formData,
				success: function(response) {
					$target.html('');
					var items = [];
					$.each(response.aaData, function(key, val) {
						items.push($.sprintf(tpl, val.productcommentContent, val.productcommentDatetime, val.userFirstname));
					});
					$target.html(items.join(''));
				}
			});
		}
	};
	
	var Obj = new Object();
	Obj.getProductcommentsByProductId = getProductcommentsByProductId;
	return Obj;
}

function Productorder()
{
	var saveStatus = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'saveStatus' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						console.log(response);
						if (response.success == true) {
							CommonItems.casDialog({
								content: jQuery.i18n.prop('ALERT_Completed'),
								onClosed: function () {
									window.location.reload();
								}
							});
						}
						else {
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				productorderstatusId: {
					required: true
				}
			},
			messages: {
				productorderstatusId: {
					required: jQuery.i18n.prop('ALERT_PleaseChooseAnOption')
				}
			}
		});
		return false;
	};
	
	var sendStatusMessage = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'sendStatusMessage' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						if (response.success == true) {
							CommonItems.casDialog(jQuery.i18n.prop('ALERT_Completed'));
						}
						else {
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				to: {
					email: true,
					required: true
				},
				subject: {
					required: true
				},
				message: {
					required: true
				}
			},
			messages: {
				to: {
					email: jQuery.i18n.prop('ALERT_PleaseEnterAValidEmailAddress'),
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				subject: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				message: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};

	var Obj = new Object();
	Obj.saveStatus = saveStatus;
	Obj.sendStatusMessage = sendStatusMessage;
	return Obj;
}

function Productattributemovement()
{
	var saveProductattributemovement = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'saveProductattributemovement' },
					dataType: 'json',
					clearForm: false,
					resetForm: true,
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						//console.log(response);
						if (response.success == true) {
							getProductattributemovementByProductattributeId();
							CommonItems.casDialog(jQuery.i18n.prop('ALERT_Completed'));
						}
						else {
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				supplierId: {
					required: true
				},
				productattributemovementDate: {
					date: true,
					required: true
				},
				productattributemovementQuantity: {
					number: true,
					required: true
				},
				productattributemovementPriceOC: {
					number: true,
					required: true
				}
			},
			messages: {
				supplierId: {
					required: jQuery.i18n.prop('ALERT_PleaseChooseAnOption')
				},
				productattributemovementDate: {
					date: jQuery.i18n.prop('ALERT_PleaseCheckOutDateFormat'),
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				productattributemovementQuantity: {
					number: jQuery.i18n.prop('ALERT_PleaseEnterAValidNumber'),
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				productattributemovementPriceOC: {
					number: jQuery.i18n.prop('ALERT_PleaseEnterAValidNumber'),
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};
	
	var deleteProductattributemovement = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'deleteProductattributemovement' },
					dataType: 'json',
					clearForm: false,
					resetForm: true,
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						//console.log(response);
						if (response.success == true) {
							getProductattributemovementByProductattributeId();
							CommonItems.casDialog(jQuery.i18n.prop('ALERT_Completed'));
						}
						else {
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				productattributemovementId: {
					required: true
				}
			},
			messages: {
				productattributemovementId: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};

	var getProductattributemovementByProductattributeId = function ()
	{
		var $target = $('[cas-js=getProductattributemovementByProductattributeId]');
		if ($target.length) {
			var productattributeId = $target.attr("cas:var");
			var url = $target.attr("cas:url");
			
			var formData = [];
			formData.push({ name: "action", value: "jsonProductattributemovementByProductattributeId" });
			formData.push({ name: "productattributeId", value: productattributeId });
			
			$.ajax( {
				type: "get", 
				url: url, 
				data: formData, 
				dataType: 'json',
				beforeSend: function() {
					$target.html('<img src="assets/css/images/loading.gif"/>');
				},
				success: function (response) {
					$target.html('');
					var items = [];
					items.push('<thead>');
					items.push('<tr>');
					items.push('<td>Supplier</td>');
					items.push('<td>Date</td>');
					items.push('<td>Quantity</td>');
					items.push('<td>Cost</td>');
					items.push('<td></td>');
					items.push('</tr>');
					items.push('</thead>');
					items.push('<tbody>');
					if (response.iTotalRecords > 0) {
						var productattributemovementQuantityTotal = 0;
						$.each(response.aaData, function(key, val) {
							items.push('<tr>');
							items.push('<td>'+val.companyTitle+'</td>');
							items.push('<td>'+val.productattributemovementDate+'</td>');
							items.push('<td>'+val.productattributemovementQuantity+'</td>');
							items.push('<td>'+val.productattributemovementPriceOC+'</td>');
							items.push('<td>');
							items.push('<form method="post" action="'+url+'">');
							items.push('<input type="hidden" name="productattributemovementId" value="'+val.productattributemovementId+'" readonly="readonly" required="required" />');
							items.push('<button type="submit" onclick="Productattributemovement.deleteProductattributemovement(this.form);">'+jQuery.i18n.prop('BUTTON_Delete')+'</button>');
							items.push('</form>');
							items.push('</td>');
							items.push('</tr>');
							productattributemovementQuantityTotal += parseInt(val.productattributemovementQuantity);
						});
					}
					else {
						items.push('<tr><td colspan="5">'+jQuery.i18n.prop('ALERT_NoRecords')+'</td></tr>');
					}
					items.push('</tbody>');
					$('<table/>', {
						'html': items.join('')
					}).juitable().appendTo($target);
				}
			});
		}
	};

	var Obj = new Object();
	Obj.saveProductattributemovement = saveProductattributemovement;
	Obj.deleteProductattributemovement = deleteProductattributemovement;
	Obj.getProductattributemovementByProductattributeId = getProductattributemovementByProductattributeId;
	return Obj;
}

function Iso639()
{
	var $target = $('button[cas-js=getBreadcrumbsIso639]');
	var uri = $target.attr("cas:uri");
	var var1 = $target.attr("cas:var");
	
	var tree4breadcrumbsIso639 = function(json) {
		var op = '<ul>';
		$.each(json.aaData, function(key, val) {
			op += '<li><a href="' + CommonItems.getLocation() + 'index.php?action=changeLanguage&language=' + val.iso639Id + '&uri='+uri+'">' + val.iso639Title + '</a></li>';
		});
		op += '</ul>';
		return op;
	};
	
	this.getBreadcrumbsIso639 = function() {
		if ($target.length) {
			$.ajax( {
				type: "get", 
				url: CommonItems.getLocation() + 'index.php', 
				data: [{ name: "action", value: "breadcrumbsIso639" }], 
				dataType: 'json',
				success: function (response) {
					if (response.iTotalRecords > 1) {
						$target
						.button({
							label: response.options[var1],
							text: true,
							icons: {
								primary: "ui-icon-flag",
								secondary: "ui-icon-triangle-1-s"
							}
						})
						.menu({
							crumbDefaultText: jQuery.i18n.prop('ALERT_PleaseMakeAChoice'),
							backLinkText: jQuery.i18n.prop('BUTTON_Back'),
							topLinkText: jQuery.i18n.prop('LABEL_All'),
							content: tree4breadcrumbsIso639(response),
							flyOut: true,
							backLink: false
						});
					}
					else {
						$target.hide();
					}
				}
			});
		}
	};
}

function Payment()
{
	var checkBincode = function (pan, bankCode)
	{
		$(pan).cleanWhitespace();
		
		if ($(pan).val().length >= 6)
		{
			var bin = $(pan).val().substring(0,6);
			$.ajax({
				url: CommonItems.getLocation() + 'productorder.php',
				type: 'get',
				data: ({ action: 'jsonBincodes', bankCode: bankCode }),
				dataType: 'json',
				beforeSend: function() {
				},
				complete: function() {
				},
				statusCode: {
					404: function() {
						CommonItems.casDialog(jQuery.i18n.prop('ALERT_PageNotFound'));
					}
				},
				success: function(response) {
					if (jQuery.inArray(bin, response) == -1) {
						CommonItems.casDialog("Kredi kartı tipi ve numarası uyuşmuyor Lütfen kontrol edip yeniden deneyin.");
					}
				}
			});
		}
	};
	
	var confirmOrder = function (form)
	{
		$form = $(form);
		$form.ajaxForm({
			data: { action: 'provision' },
			dataType: 'json',
			beforeSubmit: function(a,f,o) {
				//console.log(a);
				CommonItems.casLoaderShow();
			},
			success: function(response) {
				//console.log(response);
				if (response.success == true) {
					CommonItems.casDialog({
						content: jQuery.i18n.prop('ALERT_Completed'),
						onClosed: function () {
							window.location.replace( CommonItems.getLocation() + 'productorder.php?action=showProductorder&productorderId=' + response.productorderId );
						}
					});
				}
				else {
					CommonItems.casDialog(response.msg);
				}
			}
		});
		return false;
	};
	
	var Obj = new Object();
	Obj.checkBincode = checkBincode;
	Obj.confirmOrder = confirmOrder;
	return Obj;
}

function Postaladdress()
{
	var deletePostaladdress = function (form)
	{
		$form = $(form);
		
		var postaladdressType = $form.find("[name=postaladdressType]").val();
		
		$form.ajaxSubmit({
			data: { action: 'deletePostaladdress' },
			dataType: 'json',
			beforeSubmit: function(a,f,o) {
				//console.log(a);
			},
			success: function(response) {
				//console.log(response);
				if (response.success == true) {
					$("#dialog-form").dialog("close");
					if (postaladdressType == "deliveryaddress") {
						getDeliveryaddresses();
					}
					else if (postaladdressType == "invoiceaddress") {
						getInvoiceaddresses();
					}
					CommonItems.casDialog(jQuery.i18n.prop('ALERT_Completed'));
				}
				else {
					CommonItems.casDialog(response.msg);
				}
			}
		});
		return false;
	};
	
	var savePostaladdress = function (form)
	{
		$form = $(form);
		
		var postaladdressType = $form.find("[name=postaladdressType]").val();
		
		$form.ajaxSubmit({
			data: { action: 'savePostaladdress' },
			dataType: 'json',
			beforeSubmit: function(a,f,o) {
				//console.log(a);
			},
			success: function(response) {
				//console.log(response);
				if (response.success == true) {
					$("#dialog-form").dialog("close");
					if (postaladdressType == "deliveryaddress") {
						getDeliveryaddresses();
					}
					else if (postaladdressType == "invoiceaddress") {
						getInvoiceaddresses();
					}
					CommonItems.casDialog(jQuery.i18n.prop('ALERT_Completed'));
				}
				else {
					CommonItems.casDialog(response.msg);
				}
			}
		});

		/*
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'savePostaladdress' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						//console.log(response);
						if (response.success == true) {
							$("#dialog-form").dialog("close");
							if (postaladdressType == "deliveryaddress") {
								getDeliveryaddresses();
							}
							else if (postaladdressType == "invoiceaddress") {
								getInvoiceaddresses();
							}
							CommonItems.casDialog(jQuery.i18n.prop('ALERT_Completed'));
						}
						else {
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				postaladdressContent: {
					required: true
				},
				postaladdressCity: {
					required: true
				},
				postaladdressCounty: {
					required: true
				},
				postaladdressPostalcode: {
					required: true
				},
				postaladdressCountry: {
					required: true
				}
			},
			messages: {
				postaladdressContent: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				postaladdressCity: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				postaladdressCounty: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				postaladdressPostalcode: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				postaladdressCountry: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		*/
		return false;
	};
	
	var editPostaladdress = function (url, postaladdressType, postaladdressId)
	{
		$form = $("#formPostaladdress");
		
		$form.find('input[name=postaladdressId]').val(postaladdressId);
		$form.find('input[name=postaladdressType]').val(postaladdressType);
		console.log("postaladdressId:" + postaladdressId);
		$.ajax({
			type		: "get",
			cache		: false,
			url			: url,
			data		: "action=jsonPostaladdress&postaladdressId=" + postaladdressId,
			dataType	: 'json',
			beforeSend	: function() {
				CommonItems.casLoaderShow();
			},
			success		: function(response) {
				console.log("response:" + response.postaladdressContent);
				$form.find('input[name=postaladdressContent]').val(response.postaladdressContent);
				$form.find('input[name=postaladdressCity]').val(response.postaladdressCity);
				$form.find('input[name=postaladdressCounty]').val(response.postaladdressCounty);
				$form.find('input[name=postaladdressPostalcode]').val(response.postaladdressPostalcode);
				$form.find('input[name=postaladdressCountry]').val(response.postaladdressCountry);
			},
			complete	: function () {
				CommonItems.casLoaderHide();
				var opts;
				if (postaladdressId > 0) {
					opts = {
							modal: true,
							buttons: {
								Delete: function() {
									deletePostaladdress($form.get(0));
									$(this).dialog("close");
									return false;
								},
								Ok: function() {
									savePostaladdress($form.get(0));
									$(this).dialog("close");
									return false;
								},
								Cancel: function() {
									$(this).dialog("close");
									return false;
								}
							}
						};
				}
				else {
					opts = {
							modal: true,
							buttons: {
								Ok: function() {
									savePostaladdress($form.get(0));
									$(this).dialog("close");
									return false;
								},
								Cancel: function() {
									$(this).dialog("close");
									return false;
								}
							}
						};
				}
				// TODO: jQuery dialog butonları çalışmıyor
				$("#dialog-form").dialog(opts);
				//$("#dialog-form").dialog();
			}
		});
		
		return false;
		
	};
	
	var getDeliveryaddresses = function ()
	{
		var $target = $('[cas-js=getDeliveryaddresses]');
		if ($target.length) {
			var url = CommonItems.getLocation() + 'address.php';
			var var1 = $target.attr("cas:var1");
		
			$.ajax({
				type: "get",
				url: url,
				data: 'action=jsonDeliveryaddresses',
				dataType: 'json',
				beforeSend: function() {
					$target.html('<img src="assets/css/images/loading.gif"/>');
				},
				complete: function() {
					$("button").button();
					//scrollTo(0, $target.offset().top);
				},
				statusCode: {
					404: function() {
						CommonItems.casDialog(jQuery.i18n.prop('ALERT_PageNotFound'));
					}
				},
				success: function(response) {
					$target.html('');
					$target.append('<h2 name="nameDeliveryaddresses">Teslimat Adresi</h2>');
					var items = [];
					items.push('<thead>');
					items.push('<tr>');
					if (var1 == "eligable") items.push('<td style="width: 50px;">&nbsp;</td>');
					items.push('<td>Adres</td>');
					items.push('<td style="width: 100px;"><button type="submit" onclick="Postaladdress.editPostaladdress(\''+url+'\', \'deliveryaddress\', 0); return false;">Yeni Giriş</button></td>');
					items.push('</tr>');
					items.push('</thead>');
					if (response.iTotalRecords == 0) {
						$target.append('<span class="ui-icon ui-icon-alert fl mr5"></span>');
						$target.append('<b>Kayıtlı bir adresiniz yok. Lütfen yeni bir tane oluşturun</b>');
						$target.append('<button type="submit" onclick="Postaladdress.editPostaladdress(\''+url+'\', \'deliveryaddress\', 0); return false;">Yeni Giriş</button>');
					}
					else {
						items.push('<tbody>');
						$.each(response.aaData, function(key, val) {
							items.push('<tr>');
							if (var1 == "eligable") items.push('<td><input type="radio" name="deliveryaddressId" value="' + val.postaladdressId + '" onclick="Postaladdress.getInvoiceaddresses();" /></td>');
							items.push('<td>'+val.postaladdressContent + ', ' + val.postaladdressCity + ', ' + val.postaladdressCounty + ', ' + val.postaladdressPostalcode + ', ' + val.postaladdressCountry+'</td>');
							items.push('<td><button type="submit" onclick="Postaladdress.editPostaladdress(\''+url+'\', \'deliveryaddress\', ' + val.postaladdressId + '); return false;">Düzenle</button></td>');
							items.push('</tr>');
						});
						items.push('</tbody>');
						$('<table/>', {
							'html': items.join('')
						}).juitable().appendTo($target);
						if (var1 == "eligable") $target.append('<div cas-js="getInvoiceaddresses" cas:var1="eligable"></div>');
					}
				}
			});
		}
	};

	var getInvoiceaddresses = function ()
	{
		var $target = $('[cas-js=getInvoiceaddresses]');
		if ($target.length) {
			var url = CommonItems.getLocation() + 'address.php';
			var var1 = $target.attr("cas:var1");
		
			$.ajax({
				type: "get",
				url: url,
				data: 'action=jsonInvoiceaddresses',
				dataType: 'json',
				beforeSend: function() {
					$target.html('<img src="assets/css/images/loading.gif"/>');
				},
				complete: function() {
					$("button").button();
					//scrollTo(0, $target.offset().top);
				},
				statusCode: {
					404: function() {
						CommonItems.casDialog(jQuery.i18n.prop('ALERT_PageNotFound'));
					}
				},
				success: function(response) {
					$target.html('');
					$target.append('<h2 name="nameInvoiceaddresses">Fatura Adresi</h2>');
					var items = [];
					items.push('<thead>');
					items.push('<tr>');
					if (var1 == "eligable") items.push('<td style="width: 50px;">&nbsp;</td>');
					items.push('<td>Adres</td>');
					items.push('<td style="width: 100px;"><button type="submit" onclick="Postaladdress.editPostaladdress(\''+url+'\', \'invoiceaddress\', 0); return false;">Yeni Giriş</button></td>');
					items.push('</tr>');
					items.push('</thead>');
					if (response.iTotalRecords == 0) {
						$target.append('<span class="ui-icon ui-icon-alert fl mr5"></span>');
						$target.append('<b>Kayıtlı bir adresiniz yok. Lütfen yeni bir tane oluşturun</b>');
						$target.append('<button type="submit" onclick="Postaladdress.editPostaladdress(\''+url+'\', \'invoiceaddress\', 0); return false;">Yeni Giriş</button>');
					}
					else {
						items.push('<tbody>');
						$.each(response.aaData, function(key, val) {
							items.push('<tr>');
							if (var1 == "eligable") items.push('<td><input type="radio" name="invoiceaddressId" value="' + val.postaladdressId + '" onclick="Transportation.getContinueForCheckout();" /></td>');
							items.push('<td>'+val.postaladdressContent + ', ' + val.postaladdressCity + ', ' + val.postaladdressCounty + ', ' + val.postaladdressPostalcode + ', ' + val.postaladdressCountry+'</td>');
							items.push('<td><button type="submit" onclick="Postaladdress.editPostaladdress(\''+url+'\', \'invoiceaddress\', ' + val.postaladdressId + '); return false;">Düzenle</button></td>');
							items.push('</tr>');
						});
						items.push('</tbody>');
						$('<table/>', {
							'html': items.join('')
						}).juitable().appendTo($target);
						if (var1 == "eligable") $target.append('<div id="divContinueForCheckout"></div>');
					}
				}
			});
		}
	};

	var Obj = new Object();
	Obj.deletePostaladdress = deletePostaladdress;
	Obj.savePostaladdress = savePostaladdress;
	Obj.editPostaladdress = editPostaladdress;
	Obj.getDeliveryaddresses = getDeliveryaddresses;
	Obj.getInvoiceaddresses = getInvoiceaddresses;
	return Obj;
}

function Transportation()
{
	var Obj = new Object();
	
	var getTransportation = function (paymentgroupId, total)
	{
		$('#divTotalCostInfo').hide();
		var $target = $('#divAlertTransportation');
		$.ajax({
			type: "get",
			url: CommonItems.getLocation() + 'sales.php',
			data: 'action=jsonPaymentgroup&paymentgroupId=' + paymentgroupId,
			dataType: 'json',
			beforeSend: function() {
				$target.html('<img src="assets/css/images/loading.gif"/>');
			},
			complete: function(){
				scrollTo(0, $target.offset().top);
			},
			statusCode: {
				404: function() {
					CommonItems.casDialog(jQuery.i18n.prop('ALERT_PageNotFound'));
				}
			},
			success: function(response) {
				if (response.iTotalRecords == 0) {
					$target.html('<span class="ui-icon ui-icon-alert fl mr5"></span>');
					$target.append('<b>Hata oluştu!</b>');
				}
				else {
					$target.html('');
					$target.append('<h2 name="nameTransportation">Taşıma</h2>');
					var items = [];
					if (response.transportation.iTotalRecords > 0) {
						items.push('<thead>');
						items.push('<tr>');
						items.push('<td width="50px"></td>');
						items.push('<td width="50px"></td>');
						items.push('<td>Taşıma Firması</td>');
						items.push('<td width="100px">Taşıma Ücreti</td>');
						items.push('</tr>');
						items.push('</thead>');
						items.push('<tbody>');
						$.each(response.transportation.aaData, function(key, val) {
							items.push('<tr>');
							items.push('<td><input type="radio" name="transportationId" value="' + val.transportationId + '" onclick="Transportation.getContinueForDeliveryaddresses(' + val.transportationPrice + ', ' + total + ');" /></td>');
							items.push('<td><img src="img/transportation/' + val.pictureFile + '" width="50" /></td>');
							items.push('<td>' + val.transportationTitle + '</td>');
							items.push('<td>' + val.transportationPrice + '</td>');
							items.push('</tr>');
						});
						items.push('</tbody>');
						items.push('<tfoot id="divGrandtotalWithTransportation"></tfoot>');
						
						$('<table/>', {
							'html': items.join('')
						}).juitable().appendTo($target);
					}
					else {
						items.push('Taşıma firması tanımlı değil');
						$target.append(items.join(''));
					}
					$target.append('<div cas-js="getDeliveryaddresses" cas:var1="eligable"></div>');
				}
			}
		});
		$('#divTotalCostInfo').find('.totalCostInfo').find('label').html(total);
	};
	
	var getContinueForDeliveryaddresses = function (transportationimpactPrice, total)
	{
		
		total = (total+transportationimpactPrice).toFixed(2);
		
		var $target = $('#divGrandtotalWithTransportation');
		
		var items = [];
		items.push('<tr><td></td><td></td><td>Genel Toplam</td><td>'+total+'</td></tr>');
		$target.html(items.join(''));
		
		if ( User.checkAuthenticated() ) {
			Postaladdress.getDeliveryaddresses();
		}
		else {
			CommonItems.casDialog("Giriş yapmalısınız");
			//window.location.replace( CommonItems.getLocation() + 'index.php?action=login&uri=' + window.location.href );
			// TODO: login formunu popup şeklinde göster
		}
		
		return false;
	};
	
	var getContinueForCheckout = function ()
	{
		var $target = $('#divContinueForCheckout');
		$target.html('');
		$('<button/>', {
			'id': 'buttonContinueForCheckout',
			'class': 'fr',
			html: 'Sonraki Adım &raquo;'
		})
		.button()
		.bind("click", function() {
			var formData = $("[cas-js=getShoppingbasket2]").serializeArray();
			formData.push({ name: "action", value: "setParameters" });
			//alert("POSTing this:\n" + jQuery.param(formData));
			window.location.replace( CommonItems.getLocation() + 'productorder.php?' + jQuery.param(formData) );
			return false;
		})
		.appendTo($target);
	};
	
	Obj.getTransportation = getTransportation;
	Obj.getContinueForDeliveryaddresses = getContinueForDeliveryaddresses;
	Obj.getContinueForCheckout = getContinueForCheckout;
	return Obj;
}

function Page()
{
	var getPage = function ()
	{
		var $target = $('div[cas-js=getPage]');
		if ($target.length) {
			var url = CommonItems.getLocation() + 'page.php';
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'get',
				data: ({ action: 'jsonPage' }),
				success: function(response) {
					$target.html('');
					var items = [];
					$.each(response.aaData, function(key, val) {
						items.push('<a href="'+url+'?pageId=' + val.pageId + '">'+val.pageTitle+'</a>');
					});
					$target.html(items.join(''));
				}
			});
		}
	};

	var getPageProducts = function ()
	{
		var $target = $('div[cas-js=getPageProducts]');
		if ($target.length) {
			var url = CommonItems.getLocation() + 'page.php';
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'get',
				data: ({ action: 'jsonPage', pageId: 6 }),
				success: function(response) {
					$target.html('');
					var items = [];
					$.each(response.aaData, function(key, val) {
						items.push('<a href="'+url+'?pageId=' + val.pageId + '">'+val.pageTitle+'</a>');
					});
					$target.html(items.join(''));
				}
			});
		}
	};

	var Obj = new Object();
	Obj.getPage = getPage;
	Obj.getPageProducts = getPageProducts;
	return Obj;
}

function Voucher()
{
	var getVoucherByVoucherCode = function (voucherCode)
	{
		var op = '';
		$.ajax({
			url: CommonItems.getLocation() + 'sales.php',
			dataType: 'json',
			async: false,
			type: 'get',
			data: ({ action: 'jsonVoucherByVoucherCode', voucherCode: voucherCode }),
			success: function(response) {
				//console.log(response);
				op = response;
			}
		});
		return op;
	};
	
	var setVoucherDiscount = function (voucherCode, target, productattributebasketTotal)
	{
		var voucher = getVoucherByVoucherCode(voucherCode);
		if (voucher == null) {
			$(target).html(productattributebasketTotal);
		}
		else {
			var priceAfterVoucherDiscount = (productattributebasketTotal - productattributebasketTotal * voucher.voucherDiscountRate - voucher.voucherDiscountPrice).toFixed(2);
			$(target).html(priceAfterVoucherDiscount);
			//Productattribute.getPaymentgroups(priceAfterVoucherDiscount);
		}
	};

	var Obj = new Object();
	Obj.setVoucherDiscount = setVoucherDiscount;
	return Obj;
}

function Productattribute()
{
	var saveProductattribute = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'saveProductattribute' },
					dataType: 'json',
					clearForm: false,
					resetForm: true,
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						//console.log(response);
						if (response.success == true) {
							Productattribute.getProductattributeByProductId();
							CommonItems.casDialog({
								content: jQuery.i18n.prop('ALERT_Completed'),
								onClosed: function () {
									//window.location.reload();
								}
							});
						}
						else {
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				productattributeCode: {
					required: true
				}
			},
			messages: {
				productattributeCode: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};
	
	var deleteProductattribute = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'deleteProductattribute' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						//console.log(response);
						if (response.success == true) {
							Productattribute.getProductattributeByProductId();
							CommonItems.casDialog(jQuery.i18n.prop('ALERT_Completed'));
						}
						else {
							CommonItems.casDialog(response.msg);
						}
					}
				});
			}
		});
		return false;
	};
	
	var getProductattributeByProductId = function ()
	{
		var $target = $('[cas-js=getProductattributeByProductId]');
		if ($target.length) {
			var url = $target.attr("cas:url");
			var productId = $target.attr("cas:var");
			var tpl = $target.html();
			$target.html('');
			
			var formData = [];
			formData.push({ name: "action", value: "jsonProductattributeByProductId" });
			formData.push({ name: "productId", value: productId });
			
			$.ajax( {
				type: "get", 
				url: url, 
				data: formData, 
				dataType: 'json',
				beforeSend: function() {
					$target.html('<img src="assets/css/images/loading.gif"/>');
				},
				complete: function () {
				},
				success: function (response) {
					/*
					$target.html('');
					var items = [];
					$.each(response.aaData, function(key, val) {
						items.push($.sprintf(tpl, val.salescampaignId, val.pictureFile));
					});
					$target.html(items.join(''));
					*/
					$target.html('');
					var items = [];
					if (response.iTotalRecords > 0) {
						$.each(response.aaData, function(key, val) {
							items.push('<tr>');
							items.push('<td>'+val.productattributeCode+'</td>');
							items.push('<td>');
							$.each(val.attribute, function(key2, val2) {
								items.push('[', val2.attributegroupTitle, ': ', val2.attributeTitle, ']');
							});
							items.push('</td>');
							items.push('<td>');
							items.push('<form method="post" action="'+url+'">');
							items.push('<input type="hidden" size="1" name="productattributeId" value="'+val.productattributeId+'" readonly="readonly" required="required" />');
							items.push('<input type="text" size="2" name="productattributemovementQuantity" value="'+val.productattributeQuantity+'" required="required" />');
							//items.push('<select name="arithmeticOperator"><option value="plus">+</option><option value="minus">-</option></select>');
							//items.push('<input type="text" size="2" name="productattributemovementQuantity" />');
							items.push('<button type="submit" onclick="Productattribute.saveProductattribute(this.form);">Kaydet</button>');
							items.push('<button type="submit" onclick="Productattribute.deleteProductattribute(this.form);">Sil</button>');
							items.push('</form>');
							items.push('</td>');
							items.push('</tr>');
						});
					}
					else {
						items.push('<tr><td>'+jQuery.i18n.prop('ALERT_NoRecords')+'</td></tr>');
					}
					$('<table/>', {
						'class': '',
						'html': items.join('')
					}).juitable().appendTo($target);
				}
			});
		}
	};
	
	var whichShoppingbasket = function ()
	{
		var strt = '[cas-form=shoppingbasket]';
		$.each($(strt), function(index, element) {
			var strFunc = $(element).attr("cas-js");
			//var funcCall = strFunc + "('" + strFunc + "');";
			var funcCall = strFunc + "();";
			eval(funcCall);
			//var tmpFunc = new Function(codeToRun);
			//tmpFunc();
		});
	};
	
	var getShoppingbasket = function ()
	{
		var $target = $("[cas-js=getShoppingbasket]");
		if ($target.length > 0) {
			var url = $target.attr("action");
			$.ajax({
				url: url,
				type: 'get',
				data: ({ action: 'jsonProductattributebasket' }),
				dataType: 'json',
				beforeSend: function() {
					$target.html('<img src="assets/css/images/loading.gif" />');
				},
				statusCode: {
					404: function() {
						CommonItems.casDialog(jQuery.i18n.prop('ALERT_PageNotFound'));
					}
				},
				complete: function() {
					$(".buttonset").buttonset();
					window.setInterval(Productattribute.getShoppingbasket, 60 * 60 * 1000);//one hour
					Productattribute.getShoppingbasketMini();
				},
				success: function(response) {
					$target.html('');
					if (response.iTotalRecords>0) {
						var items = [];
						$.each(response.aaData, function(key1, val1) {
							items.push('<li>');
							items.push('<label class="name"><span style="color:#f00;">' + val1.productattributebasketQuantity + '&nbsp;x&nbsp;</span><a href="'+CommonItems.getLocation()+'product.php?action=show&productId=' + val1.productattribute.productId + '">' + val1.productattribute.productTitle + '</a>');
							items.push('<div style="font-size:smaller;">' + val1.productattribute.productattributeCode + '</div>');
							//$.each(val1.productattribute.attribute, function(key2, val2) {
								//items.push('<div style="font-size:smaller;">' + val2.attributegroupTitle + ': ' + val2.attributeTitle + '</div>');
							//});
							items.push('</label>');
							
							items.push('<button class="remove ui-state-default ui-corner-all" onclick="Productattribute.removeProductattributebasket(this.form, ' + val1.productattribute.productattributeId + '); return false;" title="bu ürünü alışveriş sepetimden çıkar"><span class="ui-icon ui-icon-trash"></span></button>');
							items.push('<label class="cost">' + val1.productattributebasketSubtotalCur + '</label>');
							items.push('</li>');
						});
						items.push('<li>');
						items.push('<p id="basketCost" class="totalCost">Toplam: <b><small>' + response.productattributebasketTotalCur + '</small></b></p>');
						//items.push('<button class="moveToBasket" onclick="window.location.href=\''+url+'\'">Sepete Git</button>');
						items.push('<a class="moveToBasket" href="'+url+'">Sepete Git</a>');
						items.push('</li>');
						
						$('<ul/>', {
							'id': 'miniBasketList',
							'class': '',
							'html': items.join('')
						}).appendTo($target);
						
						$("#miniBasketList .moveToBasket").button();
					}
					else {
						$target.html('Sepetinizde ürün bulunmuyor');
					}
				}
			});
		}
	};

	var getShoppingbasket2 = function ()
	{
		var $target = $("[cas-js=getShoppingbasket2]");
		if ($target.length > 0) {
			var url = $target.attr("action");
			$.ajax({
				url: url,
				type: 'get',
				data: ({ action: 'jsonProductattributebasket' }),
				dataType: 'json',
				beforeSend: function() {
					$target.html('<img src="assets/css/images/loading.gif"/>');
				},
				statusCode: {
					404: function() {
						CommonItems.casDialog(jQuery.i18n.prop('ALERT_PageNotFound'));
					}
				},
				complete: function() {
					$(".buttonset").buttonset();
					//scrollTo(0, $target.offset().top);
					window.setInterval(Productattribute.getShoppingbasket2, 60 * 60 * 1000);//one hour
					Productattribute.getShoppingbasketMini();
					
					$('.spinnerhide')
					.spinner({
						//showOn: 'both',
						//max: 100,
						min: 0
					})
					.change(function() {
						var productattributeId = $(this).attr("productattributeId");
						var productattributebasketQuantity = $(this).val();
						updateProductattributebasket2(productattributeId, productattributebasketQuantity);
						return false;
					});
					
				},
				success: function(response) {
					$target.html('');
					if (response.iTotalRecords > 0) {
						var items = [];
						items.push('<thead>');
						items.push('<tr>');
						items.push('<td colspan="6">');
						items.push('<span class="buttonset fr mb10 mt5">');
						items.push('<a class="btnContinueShopping" href="'+CommonItems.getLocation()+'">Alışverişe Devam</a>');
						items.push('<button type="submit" onclick="Productattribute.emptyProductattributebasket(this.form); return false;">Sepeti Temizle</button>');
						items.push('</span>');
						items.push('</td>');
						items.push('</tr>');
						items.push('<tr>');
						items.push('<td style="width:95px;">Ürün</td>');
						items.push('<td style="width:103px;">Ürün Adı</td>');
						items.push('<td style="width:218px;">Adet</td>');
						items.push('<td style="width:85px;">Birim Tutarı</td>');
						items.push('<td style="width:98px;">Toplam Tutar</td>');
						items.push('<td style="width:51px;">Sil</td>');
						items.push('</tr>');
						items.push('</thead>');
						items.push('<tbody>');
						$.each(response.aaData, function(key1, val1) {
							items.push('<tr>');
							items.push('<td  style="width:95px;">');
							items.push('<a href="'+CommonItems.getLocation()+'product.php?action=show&productId='+val1.productattribute.productId+'">');
							items.push('<img src="img/product/'+val1.productattribute.pictureFile+'" width="50" />');
							items.push('</a>');
							items.push('</td>');
							items.push('<td style="width:103px;">');
							items.push('<span class="name">'+val1.productattribute.productTitle+'</span>');
							items.push('<div>'+val1.productattribute.productattributeCode+'</div>');
							items.push('<span class="note">');
							if (val1.productattribute.attribute != null) {
								$.each(val1.productattribute.attribute, function(key2, val2) {
									items.push('<div>' + val2.attributegroupTitle + ': ' + val2.attributeTitle + '</div>');
								});
							}
							items.push('</span>');
							items.push('</td>');
							items.push('<td style="width:218px;">');
							items.push('<input type="text" class="spinnerhide" name="productattributebasket['+val1.productattribute.productattributeId+']" productattributeId="'+val1.productattribute.productattributeId+'" value="'+val1.productattributebasketQuantity+'" readonly="readonly" size="1" />');
							items.push('</td>');
							items.push('<td style="width:85px;">');
							items.push('<span class="price">' + val1.productattribute.productattributepriceMDVCur + '</span>');
							items.push('</td>');
							items.push('<td style="width:98px;">');
							items.push('<span class="price">' + val1.productattributebasketSubtotalCur + '</span>');
							items.push('</td>');
							items.push('<td style="width:49px;">');
							items.push('<button class="ui-state-default ui-corner-all" onclick="Productattribute.removeProductattributebasket(this.form, ' + val1.productattribute.productattributeId + '); return false;" title="bu ürünü alışveriş sepetimden çıkar"><span class="ui-icon ui-icon-trash"></span></button>');
							items.push('</td>');
							items.push('</tr>');
						});
						
						items.push('</tbody>');
						items.push('<tfoot>');
						
						items.push('<tr>');
						items.push('<td style="width:95px;"></td>');
						items.push('<td style="width:103px;"><span>Sepet Toplamı</span></td>');
						items.push('<td style="width:218px;">'+response.productattributebasketQuantityTotal+'</td>');
						items.push('<td style="width:85px; "></td>');
						items.push('<td style="width:48px; ">');
						items.push('</td>');
						items.push('<td style="width:91px; ">');
						items.push('<div class="totalCostInfo">');
						items.push('<label>'+response.productattributebasketTotal+'</label>');
						items.push('</div>');
						items.push('</td>');
						items.push('</tr>');
						
						items.push('<tr>');
						items.push('<td style="width:95px;"></td>');
						items.push('<td style="width:103px;"><span>Hediye Çeki</span></td>');
						items.push('<td style="width:218px;">');
						items.push('<input type="text" name="voucherCode" onkeyup="Voucher.setVoucherDiscount(this.value, \'#productattributebasketTotalCur_afterVoucherCode\', '+response.productattributebasketTotal+');" />');
						items.push('</td>');
						items.push('<td style="width:85px; "></td>');
						items.push('<td style="width:48px; "></td>');
						items.push('<td style="width:91px; ">');
						items.push('<div class="totalCostInfo">');
						items.push('<label id="productattributebasketTotalCur_afterVoucherCode">'+response.productattributebasketTotal+'</label>');
						items.push('</div>');
						items.push('</td>');
						items.push('</tr>');
						
						items.push('<tr>');
						items.push('<td colspan="6">');
						items.push('<span class="buttonset fr">');
						//items.push('<a href="javascript:void(0);" onclick="Productattribute.getPaymentgroups('+response.productattributebasketTotal+');">Sonraki Adım &raquo;</a>');
						items.push('<a href="javascript:void(0);" onclick="Productattribute.getPaymentgroups($(\'#productattributebasketTotalCur_afterVoucherCode\').html());">Sonraki Adım &raquo;</a>');
						items.push('</span>');
						items.push('</td>');
						items.push('</tr>');
						
						items.push('</tfoot>');
						$('<table/>', {
							'id' : 'productBigBasketOuter',
							'html': items.join(''),
							"css":{"border-collapse":"collapse"}
						}).juitable().appendTo($target);
						$target.append('<div id="divAlertPaymentgroup"></div>');
					}
					else {
						$target.html('Sepetiniz boş. <a href="'+CommonItems.getLocation()+'">Alışverişe devam edin.</a>');
					}
				}
			});
		}
	};
	
	var getShoppingbasketMini = function ()
	{
		var $target = $("[cas-js=getShoppingbasketMini]");
		if ($target.length > 0) {
			var url = $target.attr("action");
			$.ajax({
				url: url,
				type: 'get',
				data: ({ action: 'jsonProductattributebasket' }),
				dataType: 'json',
				beforeSend: function() {
					$target.html('<img src="assets/css/images/loading.gif" />');
				},
				complete: function() {
				},
				statusCode: {
					404: function() {
						CommonItems.casDialog(jQuery.i18n.prop('ALERT_PageNotFound'));
					}
				},
				success: function(response) {
					$target.html('');
					if (response.iTotalRecords > 0) {
						$('<a/>', {
							'href': url,
							'html': 'Sepetinizde ('+response.iTotalRecords+') adet ürün bulunuyor'
						})
						.css({
							'color': '#000000',
							'font-size': '0.8em',
							'text-decoration': 'none'
						})
						.appendTo($target);
					}
					else {
						$('<span/>', {
							'html': 'Sepetinizde ürün bulunmuyor'
						})
						.css({
							'color': '#000000',
							'font-size': '0.8em',
							'text-decoration': 'none'
						})
						.appendTo($target);
					}
				}
			});
		}
	};
	
	var emptyProductattributebasket = function (form)
	{
		$form = $(form);
		$form.ajaxSubmit({
			data: { action: 'emptyProductattributebasket' },
			dataType: 'json',
			beforeSubmit: function(a,f,o) {
				//console.log(a);
			},
			success: function(response, textStatus, xhr) {
				if (response.success == true) {
					getShoppingbasket();
					getShoppingbasket2();
					CommonItems.casDialog("Sepetiniz temizlendi");
				}
				else {
					CommonItems.casDialog("İşleminiz başarısız oldu");
				}
			}
		});
		
		return false;
	};
	
	var getPaymentgroups = function (price)
	{
		price = Number(price);
		$('#divTotalCostInfo').hide();
		var $target = $('#divAlertPaymentgroup');
		$.ajax({
			type: "get",
			url: CommonItems.getLocation() + 'sales.php',
			data: 'action=jsonPaymentgroups',
			dataType: 'json',
			beforeSend: function() {
				$target.html('<img src="assets/css/images/loading.gif"/>');
			},
			complete: function(){
				scrollTo(0, $target.offset().top);
			},
			statusCode: {
				404: function() {
					CommonItems.casDialog(jQuery.i18n.prop('ALERT_PageNotFound'));
				}
			},
			success: function(response) {
				if (response.iTotalRecords == 0) {
					$target.html('<span class="ui-icon ui-icon-alert fl mr5"></span>');
					$target.append('<b>Hata oluştu!</b>');
				}
				else {
					$target.html('');
					$target.append('<h2 name="namePaymentgroup">Ödeme Şekli</h2>');
					var items = [];
					$.each(response.aaData, function(key1, val1) {
						//if (val1.pictureFile != null) {
							//items.push('<div class="' + val1.paymentgroupClass + '">&nbsp;</div>');
						//}
						items.push('<h3><a href="#">'+val1.paymentgroupTitle+'</a></h3>');
						items.push('<div style="overflow:hidden !important;">');
						items.push('<table style="width:100% !important;">');
						items.push('<thead>');
						items.push('<tr>');
						items.push('<td width="35px"></td><td width="70px">Taksit</td><td width="120px">İndirim</td><td width="120px">Ek Maliyet</td><td width="110px">Taksit Tutarı</td><td width="120px">Toplam Tutar</td>');
						items.push('</tr>');
						items.push('</thead>');
						items.push('<tbody>');
						
						$.each(val1.payment.aaData, function(key2, val2) {
							
							var msgPaymentimpactWeight = "";
							var msgPaymentimpactDiscount = "";
							var period = Number(val2.paymentPeriod);
							var paymentimpactWeightRate = Number(val2.paymentimpactWeightRate);
							var paymentimpactWeightPrice = Number(val2.paymentimpactWeightPrice);
							var paymentimpactDiscountRate = Number(val2.paymentimpactDiscountRate);
							var paymentimpactDiscountPrice = Number(val2.paymentimpactDiscountPrice);
							var total = (price+price*paymentimpactWeightRate+paymentimpactWeightPrice-price*paymentimpactDiscountRate-paymentimpactDiscountPrice).toFixed(2);
							var payment = (total/period).toFixed(2);
							
							items.push('<tr>');
							items.push('<td width="35px"><input type="radio" name="paymentId" value="' + val2.paymentId + '" onclick="Transportation.getTransportation(' + val2.paymentgroupId + ', ' + total + ');" /></td>');
							items.push('<td width="70px">');
							items.push(val2.paymentTitle);
							items.push('</td>');
							
							
							// İNDİRİM		
							items.push('<td width="120px">');
							if (paymentimpactDiscountRate > 0) {
								msgPaymentimpactDiscount = Math.abs(paymentimpactDiscountRate*100).toFixed(2) + '% ';
							}
							
							if(paymentimpactDiscountRate > 0 && paymentimpactDiscountPrice > 0) {
								msgPaymentimpactDiscount += " + ";
							}
							
							if (paymentimpactDiscountPrice > 0) {
								msgPaymentimpactDiscount += Math.abs(paymentimpactDiscountPrice*1).toFixed(2) + ' TL ';
							}
							
							items.push(msgPaymentimpactDiscount);
							items.push('</td>');
							//////////////////////////////////////////////////////////////////////////////////
							
							
							// EK MALİYET
							items.push('<td width="120px">');
							if(paymentimpactWeightRate > 0) {
								msgPaymentimpactWeight = Math.abs(paymentimpactWeightRate*100).toFixed(2) + '% ';
							}
							
							if((paymentimpactWeightRate > 0) && (paymentimpactWeightPrice > 0)) {
								msgPaymentimpactWeight += " + ";
							}
							
							if (paymentimpactWeightPrice > 0) {								
								msgPaymentimpactWeight += Math.abs(paymentimpactWeightPrice*1).toFixed(2) + ' TL';
							}
							
							items.push(msgPaymentimpactWeight);
							items.push('</td>');
							//////////////////////////////////////////////////////////////////////////////////////////		
							
							
							items.push('<td width="110px">' + payment + '</td>');
							items.push('<td width="120px">' + total + '</td>');
							items.push('</tr>');
						});
						items.push('</tbody>');
						items.push('</table>');
						items.push('</div>');
					});
					$('<div/>', {
						'id': '',
						'class': 'accordion',
						'html': items.join('')
					}).appendTo($target).accordion();
					$target.append('<div id="divAlertTransportation"></div>');
				}
			}
		});
	};

	var removeProductattributebasket = function (form, productattributeId)
	{
		var $form = $(form);
		
		//scrollTo(0, $form.offset().top);
			
		var formData = [];
		formData.push({ name: "action", value: "removeProductattributebasket" });
		formData.push({ name: "productattributeId", value: productattributeId });
			
		$form.ajaxSubmit({
			data: formData,
			dataType: 'json',
			beforeSubmit: function(a,f,o) {
				//console.log(a);
			},
			success: function(response) {
				if (response.success == true) {
					getShoppingbasket();
					getShoppingbasket2();
					CommonItems.casDialog("Sepetinizden çıkarıldı");
				}
				else {
					CommonItems.casDialog("İşleminiz başarısız oldu");
				}
			}
		});
	};
	
	var updateProductattributebasket2 = function (productattributeId, productattributebasketQuantity)
	{
		var formData = [];
		formData.push({ name: "action", value: "updateProductattributebasket" });
		formData.push({ name: "productattributeId", value: productattributeId });
		formData.push({ name: "productattributebasketQuantity", value: productattributebasketQuantity });
		$.post(CommonItems.getLocation() + 'sales.php', formData, function(response) {
			if (response.success == true) {
				getShoppingbasket();
				getShoppingbasket2();
				CommonItems.casDialog(response.msg);
			}
			else {
				getShoppingbasket();
				getShoppingbasket2();
				CommonItems.casDialog(response.msg);
			}
		}, "json");
		return false;
	};
	
	var updateProductattributebasket = function (form)
	{
		$form = $(form);
		//console.log($form);
		
		var productattributeId = $form.find("[name=productattributeId]").val();
		var productattributebasketQuantity = $form.find("[name=productattributebasketQuantity]").val();
		
		$form.validate({
			submitHandler: function(f) {
				var formData = [];
				formData.push({ name: "action", value: "updateProductattributebasket" });
				formData.push({ name: "productattributebasket["+productattributeId+"]", value: productattributebasketQuantity });
				$form.ajaxSubmit({
					data: formData,
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
						CommonItems.casLoaderShow();
					},
					success: function(response) {
						//console.log(response);
						if (response.success == true) {
							getShoppingbasket();
							CommonItems.casDialog(response.msg);
						}
						else {
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				productattributebasketQuantity: {
					min: 1,
					required: true
				}
			},
			messages: {
				productattributebasketQuantity: {
					min: "Miktar alanına en az {0} girmelisiniz",
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};
	
	var checkProductattribute = function ()
	{
		var $target = $('[cas-js=formBasket]');
		if ($target.length) {
			var formData = $target.serializeArray();
			formData.push({ name: "action", value: "jsonProduct" });
			$.ajax({
				url: CommonItems.getLocation() + 'product.php',
				type: 'post',
				data: formData,
				dataType: 'json',
				beforeSend: function() {
					$('#productDetailInfoOuterPrice').html('<img src="assets/css/images/loading.gif"/>');
				},
				success: function(response) {
					if (response == null || response.productattributeQuantity <= 0) {
						$('#productattributeId').val('');
						$('#productDetailInfoOuterQuantity').html('Stokta yok');
						$('.productattributePrice, .ulFormBasket .productattributeQuantity, .ulFormBasket button, #paymentPeriodTable, .buttonWishlist').hide();
						return false;
					}
					else {
						$('#productattributeId').val(response.productattributeId);
						$('#productDetailInfoOuterQuantity').html('Stokta Var');//response.productattributeQuantity
						$('.productattributePrice, .ulFormBasket .productattributeQuantity, .ulFormBasket button, #paymentPeriodTable, .buttonWishlist').show();
						
						if (
								(response.productimpactDiscountRate != null && response.productimpactDiscountRate > 0) ||
								(response.productimpactDiscountPrice != null && response.productimpactDiscountPrice > 0)
								) {
							$('#productDetailInfoOuterPrice').html('<span style="text-decoration:line-through;">' + response.productattributepriceMVCur + '</span>&nbsp;&nbsp;&nbsp;' + response.productattributepriceMDVCur);
						}
						else {
							$('#productDetailInfoOuterPrice').html(response.productattributepriceMDVCur);
						}
						
						
						$("li.buttonWishlist a").unbind("click");
						if (response.isInWishlist) {
							$("li.buttonWishlist a").html("Alışveriş listemden çıkar");
							$("li.buttonWishlist a").bind("click", function() {
								removeWishlist(this, response.productId);
								return false;
							});
						}
						else {
							$("li.buttonWishlist a").html("Alışveriş listeme ekle");
							$("li.buttonWishlist a").bind("click", function() {
								saveWishlist(this, response.productId);
								return false;
							});
						}
						
						checkProductcompare(response.productId);
						
						updatePayments(response.productattributepriceMDV);
						
					}
				}
			});
		}
	};
	
	var checkProductcompare = function (productId)
	{
		var target = ".buttonCompare";
		var compareMax = 2;
		var cookienameProductcompare = "productcompare";
		var compare = $.cookie(cookienameProductcompare);
		var items = compare ? compare.split(',') : new Array();
		if ($.inArray(productId, items) == -1)
		{
			$("<a/>", {
				'href': '#',
				'html': 'Karşılaştırma listeme ekle'
			})
				.bind("click", function() {
					if (items.length < compareMax) {
						saveProductcompare(cookienameProductcompare, target, items, productId);
						return false;
					}
					else {
						CommonItems.casDialog("Sadece " + compareMax + " adet ürün karşılaştırabilirsiniz");
						return false;
					}
				})
				.appendTo(target);
		}
		else {
			$("<a/>", {
				'href': '#',
				'html': 'Karşılaştırma listemden çıkar'
			})
				.bind("click", function() {
					removeProductcompare(cookienameProductcompare, target, items, productId);
					return false;
				})
				.appendTo(target);
		}
	};
	
	var saveProductcompare = function (cookienameProductcompare, target, items, productId)
	{
		items.push(productId);
		$.cookie(cookienameProductcompare, items.join(','));
		
		var link = $("<a/>", {
				'href': '#',
				'html': 'Karşılaştırma listemden çıkar'
			})
			.unbind("click")
			.bind("click", function() {
				removeProductcompare(cookienameProductcompare, target, items, productId);
				return false;
			});
		$(target).html(link);
		CommonItems.casDialog("Ürün karşılaştırma listenize eklendi");
	};
	
	var removeProductcompare = function (cookienameProductcompare, target, items, productId)
	{
		var idx = items.indexOf(productId);
		if(idx!=-1) items.splice(idx, 1);
		if (items.length > 0) {
			$.cookie(cookienameProductcompare, items.join(','));
		}
		else {
			$.cookie(cookienameProductcompare, null, {expires: -1});
		}
		
		var link = $("<a/>", {
				'href': '#',
				'html': 'Karşılaştırma listeme ekle'
			})
			.unbind("click")
			.bind("click", function() {
				saveProductcompare(cookienameProductcompare, target, items, productId);
				return false;
			});
		$(target).html(link);
		CommonItems.casDialog("Ürün karşılaştırma listenizden çıkarıldı");
	};
	
	var sendEmailToUsersinWishlist = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'sendEmailToUsersinWishlist' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
						CommonItems.casLoaderShow();
					},
					success: function(response) {
						//console.log(response);
						if (response.success == true) {
							CommonItems.casDialog({
								content: jQuery.i18n.prop('ALERT_Completed')
							});
						}
						else {
							CommonItems.casDialog({
								content: response.msg//jQuery.i18n.prop('ALERT_ErrorOccured')
							});
						}
					}
				});
			},
			rules: {
				messageSubject: {
					required: true
				},
				messageBody: {
					required: true
				}
			},
			messages: {
				messageSubject: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				messageBody: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};
	
	var saveWishlist = function (e, productId) {
		if ( User.checkAuthenticated() ) {
			$.post(CommonItems.getLocation() + 'product.php', "action=saveWishlist&productId="+productId, function(response) {
				if (response.success == true) {
					$(e).html("Alışveriş listemden çıkar");
					CommonItems.casDialog(jQuery.i18n.prop('ALERT_Completed'));
				}
				else {
					CommonItems.casDialog(jQuery.i18n.prop('ALERT_ErrorOccured'));
				}
			}, "json");
		}
		else {
			CommonItems.casDialog("Giriş yapmalısınız");
		}
	};
	
	var removeWishlist = function (e, productId) {
		if ( User.checkAuthenticated() ) {
			$.post(CommonItems.getLocation() + 'product.php', "action=removeWishlist&productId="+productId, function(response) {
				if (response.success == true) {
					$(e).html("Alışveriş listeme ekle");
					CommonItems.casDialog(jQuery.i18n.prop('ALERT_Completed'));
				}
				else {
					CommonItems.casDialog(jQuery.i18n.prop('ALERT_ErrorOccured'));
				}
			}, "json");
		}
		else {
			CommonItems.casDialog("Giriş yapmalısınız");
		}
	};
	
	var updatePayments = function (price) {
		if (price != null) {
			var $target = $('#paymentPeriodTable');
			if ($target.length) {
				var formData = [];
				formData.push({ name: "action", value: "jsonPayment" });
				$.ajax({
					url: CommonItems.getLocation() + 'product.php',
					type: 'post',
					data: formData,
					dataType: 'json',
					beforeSend: function() {
						$target.html('<img src="assets/css/images/loading.gif"/>');
					},
					success: function(response) {
						$target.html('');
						var items = [];
						items.push('<thead>');
						items.push('<tr class="bgc-000000 c-ffffff">');
						items.push('<th>Ödeme</th>');
						items.push('<th>Taksit</th>');
						items.push('<th>Tutar</th>');
						items.push('<th>Toplam</th>');
						items.push('</tr></thead><tbody>');
						$.each(response.aaData, function(index1, value1) { 
							var clazz = (index1%2==0)?"bgc-c6aec7":"bgc-ebdde2";
							$.each(value1.payment.aaData, function(index2, value2) {
								var period = Number(value2.paymentPeriod);
								var paymentimpactWeightRate = Number(value2.paymentimpactWeightRate);
								var paymentimpactWeightPrice = Number(value2.paymentimpactWeightPrice);
								var total = (price*(1+paymentimpactWeightRate)+paymentimpactWeightPrice).toFixed(2);
								var payment = (total/period).toFixed(2);
								items.push('<tr class="'+clazz+'">');
								items.push('<td class="'+value1.paymentgroupClass+'">');
								(value1.paymentgroupClass == null)?items.push(value1.paymentgroupTitle):items.push('');
								items.push('</td>');
								items.push('<td>' + value2.paymentTitle + '</td>');
								items.push('<td>' + payment + '</td>');
								items.push('<td>' + total + '</td>');
								items.push('</tr>');
							});
						});
						items.push('</tbody>');
						$('<table/>', {
							'class': 'w100p',
							'html': items.join('')
						}).juitable().appendTo($target);
					}
				});
			}
		}
		return false;
	};

	var searchProductattribute = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				window.location.replace( CommonItems.getLocation() + 'search.php?action=search&sSearch=' + $form.find("[name=sSearch]").val() );
			},
			rules: {
				sSearch: {
					required: true
				}
			},
			messages: {
				sSearch: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};
	
	var getSearchResults = function ()
	{
		var $target = $('[cas-js=getSearchResults]');
		if ($target.length) {
			var url = $target.attr("cas:url");
			var sSearch = $target.attr("cas:var");
			var limit = $target.attr("cas:limit");
			
			// TODO: aktif hale geldiğinde b2b de ürün listelemiyor
			// aktifken b2c de tüm ürünleri listeliyor
			//if (sSearch == "" || sSearch == null) {
				//$target.html('');
				//return false;
			//}
			
			var tpl = $target.html();
			$target.html('');
			
			$.ajax({
				url: url,
				type: 'get',
				data: ({ action: 'jsonProductattributes', iDisplayStart: 0, iDisplayLength: limit, sSearch: sSearch}),
				dataType: 'json',
				beforeSend: function() {
					$target.html('<img src="assets/css/images/loading.gif"/>');
				},
				statusCode: {
					404: function() {
						CommonItems.casDialog(jQuery.i18n.prop('ALERT_PageNotFound'));
					}
				},
				success: function(response) {
					$target.html('');
					var items = [];
					if (response.iTotalRecords > 0) {
						$.each(response.aaData, function(key, val) {
							var discountPercent = (val.productimpactDiscountRate == null) ? "dn" : "";
							var discountCount = (val.productimpactDiscountPrice == null) ? "dn" : "";
							var discountText = ((val.productimpactDiscountRate == null) && (val.productimpactDiscountPrice == null)) ? "dn" : "";
							var oldCost = ((val.productimpactDiscountRate == null) && (val.productimpactDiscountPrice == null)) ? "dn" : "";
							items.push($.sprintf(tpl, discountPercent, val.productimpactDiscountRate*100, discountCount, val.productimpactDiscountPrice, discountText, val.productId, val.pictureFile, val.productTitle, oldCost, val.productattributepriceMVCur, val.productattributepriceMDVCur, val.productattributeId));
						});
					}
					else {
						items.push(jQuery.i18n.prop('ALERT_NoRecords'));
					}
					$target.html(items.join(''));
				},
				complete: function(){
					//window.setInterval('getSearchResults('+iDisplayStart+', '+iDisplayLength+', '+sSearch+')', 5 * 1000); // five seconds
					if($target.has("[cas-break]"))
					{
						var limitCount = $target.attr("cas-break");
	
						$target.find("li").each(function (index, element) {
								var floatSide = $(this).css("float");
								index++;
								if((index % limitCount) === 0)
								{
									$(this).addClass("last");
								}
								else if((index != 1) &&  ((index % limitCount) == 1))
								{
									$(this).css({"clear":floatSide});
								}
						});
					}
				}
			});
		}
	};
	
	var getSearchResultsSalescampaign = function ()
	{
		var $target = $('[cas-js=getSearchResultsSalescampaign]');
		if ($target.length) {
			$.each($target, function(index, element) {
				var url = $(element).attr("cas:url");
				var tpl = $(element).html();
				$(element).html('');
				$.ajax({
					url: url,
					type: 'get',
					data: ({ action: 'jsonSalescampaigns' }),
					dataType: 'json',
					beforeSend: function() {
						$(element).html('<img src="assets/css/images/loading.gif"/>');
					},
					success: function(response) {
						$(element).html('');
						var items = [];
						$.each(response.aaData, function(key, val) {
							items.push($.sprintf(tpl, val.salescampaignTitle, val.salescampaignEnd, val.salescampaignId, val.salescampaignId, val.pictureFile));
						});
						$(element).html(items.join(''));
					}
				});
			});
		}
	};
	
	var getProductsInWishlist = function ()
	{
		var $target = $('[cas-js=getProductsInWishlist]');
		if ($target.length) {
			$.each($target, function(index, element) {
				var url = $(this).attr("cas:url");
				var tpl = $(element).html();
				$(element).html('');
				
				$.ajax({
					url: url,
					type: 'get',
					data: ({ action: 'jsonProductsInWishlist' }),
					dataType: 'json',
					success: function(response) {
						$(element).html('');
						var items = [];
						$.each(response.aaData, function(key, val) {
							var discountPercent = (val.productimpactDiscountRate == null) ? "dn" : "";
							var discountCount = (val.productimpactDiscountPrice == null) ? "dn" : "";
							var discountText = ((val.productimpactDiscountRate == null) && (val.productimpactDiscountPrice == null)) ? "dn" : "";
							var oldCost = ((val.productimpactDiscountRate == null) && (val.productimpactDiscountPrice == null)) ? "dn" : "";
							items.push($.sprintf(tpl, discountPercent, val.productimpactDiscountRate*100, discountCount, val.productimpactDiscountPrice, discountText, val.productId, val.pictureFile, val.productTitle, oldCost, val.productattributepriceMVCur, val.productattributepriceMDVCur, val.productattributeId));
						});
						$(element).html(items.join(''));
					},
					complete: function(){
						if($(element).has("[cas-break]"))
						{
							var limitCount = $(element).attr("cas-break");
							
							$(element).find("li").each(function (index, element) {
									var floatSide = $(this).css("float");
									index++;
									if((index % limitCount) === 0)
									{
										$(this).addClass("last");
									}
									else if((index != 1) &&  ((index % limitCount) == 1))
									{
										$(this).css({"clear":floatSide});
									}
							});
						}
					}
				});
			});
		}
	};
	
	var getProductsByProductgroupId = function ()
	{
		var $target = $('[cas-js=getProductsByProductgroupId]');
		if ($target.length) {
			$.each($target, function(index, element) {
				var limit = $(this).attr("cas:limit");
				var url = $(this).attr("cas:url");
				var productgroupId = $(this).attr("cas:var");
				var tpl = $(element).html();
				$(element).html('');
				
				$.ajax({
					url: url,
					type: 'get',
					data: ({ action: 'jsonProductattributes', iDisplayStart: 0, iDisplayLength: limit, sType: 'productgroup', productgroupId: productgroupId }),
					dataType: 'json',
					success: function(response) {
						$(element).html('');
						var items = [];
						$.each(response.aaData, function(key, val) {
							var discountPercent = (val.productimpactDiscountRate == null) ? "dn" : "";
							var discountCount = (val.productimpactDiscountPrice == null) ? "dn" : "";
							var discountText = ((val.productimpactDiscountRate == null) && (val.productimpactDiscountPrice == null)) ? "dn" : "";
							var oldCost = ((val.productimpactDiscountRate == null) && (val.productimpactDiscountPrice == null)) ? "dn" : "";
							items.push($.sprintf(tpl, discountPercent, val.productimpactDiscountRate*100, discountCount, val.productimpactDiscountPrice, discountText, val.productId, val.pictureFile, val.productTitle, oldCost, val.productattributepriceMVCur, val.productattributepriceMDVCur, val.productattributeId));
						});
						$(element).html(items.join(''));
					},
					complete: function(){
						if($(element).has("[cas-break]"))
						{
							var limitCount = $(element).attr("cas-break");
							
							$(element).find("li").each(function (index, element) {
									var floatSide = $(this).css("float");
									index++;
									if((index % limitCount) === 0)
									{
										$(this).addClass("last");
									}
									else if((index != 1) &&  ((index % limitCount) == 1))
									{
										$(this).css({"clear":floatSide});
									}
							});
						}
					}
				});
			});
		}
	};
	
	var getProductsSimilar = function ()
	{
		var $target = $('[cas-js=getProductsSimilar]');
		if ($target.length) {
			$.each($target, function(index, element) {
				var limit = $(this).attr("cas:limit");
				var url = $(this).attr("cas:url");
				var categoryId = $(this).attr("cas:var");
				var tpl = $(element).html();
				$(element).html('');
				
				$.ajax({
					url: url,
					type: 'get',
					data: ({ action: 'jsonProductattributes', iDisplayStart: 0, iDisplayLength: limit, sType: 'similar', categoryId: categoryId }),
					dataType: 'json',
					success: function(response) {
						$(element).html('');
						var items = [];
						$.each(response.aaData, function(key, val) {
							var discountPercent = (val.productimpactDiscountRate == null) ? "dn" : "";
							var discountCount = (val.productimpactDiscountPrice == null) ? "dn" : "";
							var discountText = ((val.productimpactDiscountRate == null) && (val.productimpactDiscountPrice == null)) ? "dn" : "";
							var oldCost = ((val.productimpactDiscountRate == null) && (val.productimpactDiscountPrice == null)) ? "dn" : "";
							items.push($.sprintf(tpl, discountPercent, val.productimpactDiscountRate*100, discountCount, val.productimpactDiscountPrice, discountText, val.productId, val.pictureFile, val.productTitle, oldCost, val.productattributepriceMVCur, val.productattributepriceMDVCur, val.productattributeId));
						});
						$(element).html(items.join(''));
					},
					complete: function(){
						if($(element).has("[cas-break]"))
						{
							var limitCount = $(element).attr("cas-break");
							
							$(element).find("li").each(function (index, element) {
									var floatSide = $(this).css("float");
									index++;
									if((index % limitCount) === 0)
									{
										$(this).addClass("last");
									}
									else if((index != 1) &&  ((index % limitCount) == 1))
									{
										$(this).css({"clear":floatSide});
									}
							});
						}
					}
				});
			});
		}
	};
	
	var getProductsByCategoryId = function ()
	{
		var $target = $('[cas-js=getProductsByCategoryId]');
		if ($target.length) {
			var url = $target.attr("cas:url");
			var limit = $target.attr("cas:limit");
			var categoryId = $target.attr("cas:var");
			var tpl = $target.html();
			$target.html('');
			$.ajax({
				url: url,
				type: 'get',
				data: ({ action: 'jsonProductattributes', iDisplayStart: 0, iDisplayLength: limit, sType: 'category', categoryId: categoryId}),
				dataType: 'json',
				beforeSend: function() {
					$target.html('<img src="assets/css/images/loading.gif"/>');
				},
				statusCode: {
					404: function() {
						CommonItems.casDialog(jQuery.i18n.prop('ALERT_PageNotFound'));
					}
				},
				success: function(response) {
					$target.html('');
					var items = [];
					$.each(response.aaData, function(key, val) {
						var discountPercent = (val.productimpactDiscountRate == null) ? "dn" : "";
						var discountCount = (val.productimpactDiscountPrice == null) ? "dn" : "";
						var discountText = ((val.productimpactDiscountRate == null) && (val.productimpactDiscountPrice == null)) ? "dn" : "";
						var oldCost = ((val.productimpactDiscountRate == null) && (val.productimpactDiscountPrice == null)) ? "dn" : "";
						items.push($.sprintf(tpl, discountPercent, val.productimpactDiscountRate*100, discountCount, val.productimpactDiscountPrice, discountText, val.productId, val.pictureFile, val.productTitle, oldCost, val.productattributepriceMVCur, val.productattributepriceMDVCur, val.productattributeId));
					});
					$target.html(items.join(''));
				},
				complete: function(){
					if($target.has("[cas-break]"))
					{
						var limitCount = $target.attr("cas-break");
	
						$target.find("li").each(function (index, element) {
								var floatSide = $(this).css("float");
								index++;
								if((index % limitCount) === 0)
								{
									$(this).addClass("last");
								}
								else if((index != 1) &&  ((index % limitCount) == 1))
								{
									$(this).css({"clear":floatSide});
								}
						});
					}
				}
			});
		}
	};

	var getProductsByBrandId = function ()
	{
		var $target = $('[cas-js=getProductsByBrandId]');
		if ($target.length) {
			
			var url = $target.attr("cas:url");
			var limit = $target.attr("cas:limit");
			var brandId = $target.attr("cas:var");
			var tpl = $target.html();
			$target.html('');
			
			$.ajax({
				url: url,
				type: 'get',
				data: ({ action: 'jsonProductattributes', iDisplayStart: 0, iDisplayLength: limit, sType: 'brand', brandId: brandId}),
				dataType: 'json',
				beforeSend: function() {
					$target.html('<img src="assets/css/images/loading.gif"/>');
				},
				statusCode: {
					404: function() {
						CommonItems.casDialog(jQuery.i18n.prop('ALERT_PageNotFound'));
					}
				},
				success: function(response) {
					$target.html('');
					var items = [];
					$.each(response.aaData, function(key, val) {
						var discountPercent = (val.productimpactDiscountRate == null) ? "dn" : "";
						var discountCount = (val.productimpactDiscountPrice == null) ? "dn" : "";
						var discountText = ((val.productimpactDiscountRate == null) && (val.productimpactDiscountPrice == null)) ? "dn" : "";
						var oldCost = ((val.productimpactDiscountRate == null) && (val.productimpactDiscountPrice == null)) ? "dn" : "";
						items.push($.sprintf(tpl, discountPercent, val.productimpactDiscountRate*100, discountCount, val.productimpactDiscountPrice, discountText, val.productId, val.pictureFile, val.productTitle, oldCost, val.productattributepriceMVCur, val.productattributepriceMDVCur, val.productattributeId));
					});
					$target.html(items.join(''));
				},
				complete: function(){
					if($target.has("[cas-break]"))
					{
						var limitCount = $target.attr("cas-break");
	
						$target.find("li").each(function (index, element) {
								var floatSide = $(this).css("float");
								index++;
								if((index % limitCount) === 0)
								{
									$(this).addClass("last");
								}
								else if((index != 1) &&  ((index % limitCount) == 1))
								{
									$(this).css({"clear":floatSide});
								}
						});
					}
				}
			});
		}
	};

	var getProductgroups = function ()
	{
		var $target = $('[cas-js=getProductgroups]');
		if ($target.length) {
			$.each($target, function(index, element) {
				var url = $(this).attr("cas:url");
				var productgroupId = $(this).attr("cas:var");
				var tpl = $(element).html();
				//console.log($(tpl).attr("href")); //converting a javascript string to a html object
				$(element).html('');
				
				$.ajax({
					url: url,
					type: 'get',
					data: ({ action: 'jsonProductgroups' }),
					dataType: 'json',
					success: function(response) {
						$(element).html('');
						var items = [];
						$.each(response.aaData, function(key, val) {
							/*
							if (productgroupId == val.productgroupId) {
								//$(tpl).addClass("selected");
								//console.log($(tpl).hasClass("selected"));
								items.push($.sprintf(tpl, val.productgroupId, "selected", val.productgroupTitle));
							}
							else {
								items.push($.sprintf(tpl, val.productgroupId, "" , val.productgroupTitle));
							}
							*/
							items.push($.sprintf(tpl, val.productgroupId, val.productgroupTitle));
						});
						$(element).html(items.join(''));
					}
				});
			});
		}
	};

	var Obj = new Object();
	
	Obj.checkProductcompare = checkProductcompare;
	Obj.saveProductcompare = saveProductcompare;
	Obj.removeProductcompare = removeProductcompare;
	
	Obj.sendEmailToUsersinWishlist = sendEmailToUsersinWishlist;
	Obj.saveWishlist = saveWishlist;
	Obj.removeWishlist = removeWishlist;
	
	Obj.saveProductattribute = saveProductattribute;
	Obj.deleteProductattribute = deleteProductattribute;
	
	Obj.whichShoppingbasket = whichShoppingbasket;
	Obj.getShoppingbasket = getShoppingbasket;
	Obj.getShoppingbasket2 = getShoppingbasket2;
	Obj.getShoppingbasketMini = getShoppingbasketMini;
	Obj.emptyProductattributebasket = emptyProductattributebasket;
	
	Obj.checkProductattribute = checkProductattribute;
	Obj.searchProductattribute = searchProductattribute;
	Obj.getSearchResults = getSearchResults;
	Obj.getSearchResultsSalescampaign = getSearchResultsSalescampaign;
	
	Obj.getProductsInWishlist = getProductsInWishlist;
	Obj.getProductsByProductgroupId = getProductsByProductgroupId;
	Obj.getProductsSimilar = getProductsSimilar;
	Obj.getProductsByCategoryId = getProductsByCategoryId;
	Obj.getProductsByBrandId = getProductsByBrandId;
	Obj.getProductgroups = getProductgroups;
	
	Obj.getProductattributeByProductId = getProductattributeByProductId;
	
	Obj.getPaymentgroups = getPaymentgroups;
	
	Obj.removeProductattributebasket = removeProductattributebasket;
	Obj.updateProductattributebasket = updateProductattributebasket;
	Obj.updateProductattributebasket2 = updateProductattributebasket2;
	
	return Obj;
}

function User()
{
	var checkAuthenticated = function ()
	{
		var op = false;
		$.ajax({
			url: CommonItems.getLocation() + 'index.php',
			dataType: 'json',
			async: false,
			data: "action=checkAuthenticated",
			success: function(response) {
				op = response.authenticated;
			}
		});
		return op;
	};
	
	var getLoginoutFormAndMenu = function ()
	{
		var $target = $('[cas-form=getLoginoutFormAndMenu]');
		if ($target.length) {
			$.each($target, function(index, element) {
				if ( User.checkAuthenticated() ) {
					$.getJSON(CommonItems.getLocation() + 'index.php', {
						'action': 'breadcrumbsMenu'
					}, function(response) {
						$(element).html(tree4breadcrumbsMenu(response));
					});
				}
			});
		}
	};
	
	function generateAdminMenu(data)
	{
		var treeMenu = "<ul class='topMenu' >";
		
		for(var i=0, j=data.length; i<j; i++)
		{
			treeMenu += "<li class='topMenuItem' >";
			treeMenu += "<a href='" + (data[i].href == undefined ? "javascript:void(0);" : data[i].href) + "' title='" + data[i].title + "'>" + data[i].text + "</a>";
			if((data[i].children != undefined) && (data[i].children.length > 0))
			{
				treeMenu += generateAdminSubMenus(data[i].children);
			}
			treeMenu += "</li>";
		}
		
		treeMenu += "</ul>";
		return treeMenu
		
	}
	
	function generateAdminSubMenus(data)
	{
		var treeMenu = "<ul class='subMenu' >";
		
		for(var i=0, j=data.length; i<j; i++)
		{
			treeMenu += "<li class='subMenuItem' >";
			treeMenu += "<a href='" + (data[i].href == undefined ? "javascript:void(0);" : data[i].href) + "' title='" + data[i].title + "'>" + data[i].text + "</a>";
			if((data[i].children != undefined) && (data[i].children.length > 0))
			{
				treeMenu += generateAdminSubMenus(data[i].children);
			}
			treeMenu += "</li>";
		}
		
		
		treeMenu += "</ul>";
		return treeMenu;
	}
	
	
	var getLoginoutButton = function ()
	{
		var $target = $('[cas-js=getLoginoutButton]');
		if ($target.length) {
			if(User.checkAuthenticated()) 
			{
				$.getJSON(CommonItems.getLocation() + 'index.php', {
					'action'	: 	'breadcrumbsMenu'
				}, function(response) {
					//$('#treeMenu').html(tree4breadcrumbsMenu(response));
					$target
						.button({
							label: jQuery.i18n.prop('LABEL_Menu'),
							text: true,
							icons: {
								primary: "ui-icon-unlocked",
								secondary: "ui-icon-triangle-1-s"
							}
						});
						/*.menu({
							crumbDefaultText: jQuery.i18n.prop('ALERT_PleaseMakeAChoice'),
							backLinkText: jQuery.i18n.prop('BUTTON_Back'),
							topLinkText: jQuery.i18n.prop('LABEL_All'),
							content: generateAdminMenu(response), //tree4breadcrumbsMenu(response),
							flyOut: false,
							positionOpts: {
								posX: 'left', 
								posY: 'bottom',
								offsetX: 0,
								offsetY: 0,
								directionH: 'left',
								directionV: 'down', 
								detectH: true, // do horizontal collision detection  
								detectV: true, // do vertical collision detection
								linkToFront: false
							},
							backLink: false
						});*/
					$("#mainMenu").html(generateAdminMenu(response));					
					$(".topMenuItem").each(function(){
						var width = $(this).find("a").outerWidth(true);
						$(this).width(width);
					}).click(function(){
						var subMenu = $(this).find(".subMenu");
						var status = subMenu.css("display") === "block" ? "visible" : "hidden";
						
						if(status === "visible")
						{
							subMenu.css("display","none");
						}
						else
						{
							subMenu.css("display","block");
						}
					});

					$(".topMenuItem .subMenu").click(function(){
						$(this).css("display","block");
					});
					
					$(document).click(function(e){
						$(".subMenu").css("display","none");
						//alert($(e.target).parents(".topMenuItem").length);
						$(e.target).parents(".topMenuItem").find(".subMenu").css("display","block");
					});
				});
			}
			else {
				var type = $target.attr("cas:type");
				if(type === undefined) {
					$target.remove();
				}
				else if(type == "page") {
					$target
					.button({
						label: 'Giriş yap',
						text: true
					})
					.bind("click", function() {
						window.location.replace(CommonItems.getLocation() + 'index.php?action=login');
						return false;
					});
				}
				else if(type == "popup") {
					$target
						.button({
							label: 'Giriş yap',
							text: true
						})
						.bind("click", function() {
							// TODO: login form popup olarak yapılacak
						})
						.css({
							cursor: 'pointer'
						});
					
					// TODO: login form submit ajaxSubmit ile yapılacak
					/*
					$("#formUserlogin").bind("submit", function() {
						var formData = $(this).serializeArray();
						formData.push({ name: "action", value: "loginUser" });
				
						if ($(this).find("#username").val().length < 1 || $(this).find("#passopen").val().length < 1) {
							$("#errorUserlogin").show();
							return false;
						}
				
						$.ajax({
							type	: "POST",
							cache	: false,
							url		: CommonItems.getLocation() + 'index.php',
							data	: formData,
							dataType: 'json',
							success: function(response) {
								console.log(response);
								if (response.authenticated == true) {
									window.location.replace(response.uri);
								}
								else {
									//CommonItems.casDialog(jQuery.i18n.prop('ALERT_AuthenticationFailed'));
								}
							}
						});
				
						return false;
					});
					*/
				}
			}
		}
	};
	
	var tree4breadcrumbsMenu = function (json)
	{
		var op = '<ul>';
		$.each(json, function(key, val) {
			if(val.children!=null) {
				op += '<li><a href="#">' + val.text + '</a>' + tree4breadcrumbsMenu(val.children) + '</li>';
			}
			else {
				op += '<li><a href="' + val.href + '">' + val.text + '</a></li>';
			}
		});
		op += '</ul>';
		return op;
	};

	var saveUser = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'saveUser' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
						CommonItems.casLoaderShow();
					},
					success: function(response) {
						if (response.success == true) {
							CommonItems.casDialog(response.msg);
						}
						else {
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				userFirstname: {
					required: true
				},
				userLastname: {
					required: true
				},
				userEmail: {
					email: true,
					required: true
				},
				userAgreement: {
					required: true
				}
			},
			messages: {
				userFirstname: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userLastname: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userEmail: {
					email: jQuery.i18n.prop('ALERT_PleaseEnterAValidEmailAddress'),
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userAgreement: {
					required: jQuery.i18n.prop('ALERT_PleaseAcceptUserAgreement')
				}
			}
		});
		return false;
	};
	
	var updateUser = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				/*
				$form.ajaxSubmit(function(response) {
					if(response == "succeed")
						alert("Send Succeed!"); 
					else
						alert("Error Happened");
				});
				*/
				$form.ajaxSubmit({
					data: { action: 'updateUser' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						if (response.success == true) {
							CommonItems.casDialog({
								content: jQuery.i18n.prop('ALERT_Completed'),
								onClosed: function () {
									window.location.reload();
								}
							});
						}
						else {
							// TODO: input title dan alıp alert verilebilir mi?
							//CommonItems.casDialog(response.msg + ' - ' + response.field + ' - ' + $("[name="+response.field+"]").attr("title"));
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				/*userTcknNew: {
					minlength: 11,
					required: true
				},*/
				userEmailNew: {
					email: true,
					required: true
				},
				userNameNew: {
					required: true
				},
				userGender: {
					required: true
				},
				userFirstname: {
					required: true
				},
				userLastname: {
					required: true
				},
				userBirthdate: {
					date: true,
					required: true
				},
				/*userPhone: {
					required: true
				}*/
			},
			messages: {
				/*userTcknNew: {
					minlength: "11 dijit uzunluğunda olmalı",
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},*/
				userEmailNew: {
					email: jQuery.i18n.prop('ALERT_PleaseEnterAValidEmailAddress'),
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userNameNew: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userGender: {
					required: jQuery.i18n.prop('ALERT_PleaseMakeAChoice')
				},
				userFirstname: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userLastname: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userBirthdate: {
					date: jQuery.i18n.prop('ALERT_PleaseCheckOutDateFormat'),
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				/*userPhone: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}*/
			}
		});
		return false;
	};
	
	var updatePersonalInfo = function (form)
	{
		var rules = {
				userFirstname: {
					required: true
				},
				userLastname: {
					required: true
				}};
		
		var messages = {
				userFirstname: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userLastname: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}};
		
		if(document.getElementsByName("userPosition").length > 0)
		{
			rules.userPosition = {
							required: true
						};
			
			messages.userPosition = {
				required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
			};
		}
		
		////////////////////////////////////////////////////////////
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'updatePersonalInfo' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						if (response.success == true) {
							CommonItems.casDialog({
								content: jQuery.i18n.prop('ALERT_Completed'),
								onClosed: function () {
									window.location.reload();
								}
							});
						}
						else {
							// TODO: input title dan alıp alert verilebilir mi?
							//CommonItems.casDialog(response.msg + ' - ' + response.field + ' - ' + $("[name="+response.field+"]").attr("title"));
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: rules,
			messages: messages
		});
		return false;
	};
	
	var updateAccountInfo = function (form)
	{
		email = document.getElementsByName("userEmailNew")[0].value;
		email_repeat = document.getElementsByName("userEmailNew_Repeat")[0].value;
		
		pass = document.getElementsByName("userPass")[0].value;
		pass_repeat = document.getElementsByName("userPass_Repeat")[0].value;
		
		if(email != email_repeat)
		{
			CommonItems.casDialog(jQuery.i18n.prop('ALERT_EmailsDontMatch'));
			return false;
		}
		
		if((pass.length > 0) && (pass.length < 6))
		{
			CommonItems.casDialog(jQuery.i18n.prop('ALERT_PasswordAtLeastSixCharacterLength'));
			return false;
		}
		
		if((pass.length >= 6) && (pass != pass_repeat))
		{
			CommonItems.casDialog(jQuery.i18n.prop('ALERT_PasswordsDontMatch'));
			return false;
		}
		
		
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'updateAccountInfo' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						if (response.success == true) {
							CommonItems.casDialog({
								content: jQuery.i18n.prop('ALERT_Completed'),
								onClosed: function () {
									window.location.reload();
								}
							});
						}
						else {
							// TODO: input title dan alıp alert verilebilir mi?
							//CommonItems.casDialog(response.msg + ' - ' + response.field + ' - ' + $("[name="+response.field+"]").attr("title"));
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				
				userEmailNew: {
					email: true,
					required: true
				}
			},
			messages: {
				userEmailNew: {
					email: jQuery.i18n.prop('ALERT_PleaseEnterAValidEmailAddress'),
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return true;
	};
	
	var loginUser = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'loginUser' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						if (response.success == true) {
							CommonItems.casDialog({
								content: response.msg,
								onClosed: function () {
									if (response.uri != null && response.uri != "") {
										window.location.replace(response.uri);
									}
									else {
										window.location.reload();
									}
								}
							});
						}
						else {
							CommonItems.casDialog({
								content: response.msg
							});
						}
					}
				});
			},
			rules: {
				username: {
					email: true,
					required: true
				},
				password: {
					required: true
				}
			},
			messages: {
				username: {
					email: jQuery.i18n.prop('ALERT_PleaseEnterAValidEmailAddress'),
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				password: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};
	
	var resetUserPass = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'resetUserPass' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
						CommonItems.casLoaderShow();
					},
					success: function(response) {
						if (response.success == true) {
							CommonItems.casDialog(response.msg);
						}
						else {
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				userEmail: {
					email: true,
					required: true
				}
			},
			messages: {
				userEmail: {
					email: jQuery.i18n.prop('ALERT_PleaseEnterAValidEmailAddress'),
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};

	var sendRecommendation = function (form)
	{
		if ( User.checkAuthenticated() ) {
			$form = $(form);
			$form.validate({
				submitHandler: function(f) {
					$form.ajaxSubmit({
						data: { action: 'sendRecommendation' },
						dataType: 'json',
						beforeSubmit: function(a,f,o) {
							//console.log(a);
							CommonItems.casLoaderShow();
						},
						success: function(response) {
							//console.log(response);
							if (response.success == true) {
								CommonItems.casDialog(response.msg);
							}
							else {
								CommonItems.casDialog(response.msg);
							}
						}
					});
				},
				rules: {
					userEmail: {
						email: true,
						required: true
					}
				},
				messages: {
					userEmail: {
						email: jQuery.i18n.prop('ALERT_PleaseEnterAValidEmailAddress'),
						required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
					}
				}
			});
		}
		else {
			CommonItems.casDialog("Giriş yapmalısınız");
		}
		return false;
	};
	
	this.deleteUser = function(userId){
		if(User.checkAuthenticated)
		{
			$.ajax({
				type:"post",
				async: false,
				data:"action=deleteUser&userId=" + userId,
				dataType:"json",
				success:function(response){
					if(response.error === false)
					{
						window.location.href = CommonItems.getLocation() + "modules/user/user.php";
					}
					else
					{
						alert(response.msg);
					}
				},
				error:function(){
					alert("Hata Oluştu!");
				}
			
			});
		}
		else
		{
			alert("Not authenticated!");
		}
			
		return false;
	};

	var Obj = new Object();
	Obj.checkAuthenticated = checkAuthenticated;
	Obj.getLoginoutFormAndMenu = getLoginoutFormAndMenu;
	Obj.getLoginoutButton = getLoginoutButton;
	Obj.saveUser = saveUser;
	Obj.updateUser = updateUser;
	Obj.loginUser = loginUser;
	Obj.resetUserPass = resetUserPass;
	Obj.sendRecommendation = sendRecommendation;
	Obj.deleteUser = this.deleteUser;
	Obj.updatePersonalInfo = updatePersonalInfo;
	Obj.updateAccountInfo = updateAccountInfo;
	return Obj;
}

function Banner()
{
	var getBanners = function ()
	{
		return;
		
		var $target = $('[cas-js=getBanners]');
		if ($target.length) {
			
			var url = CommonItems.getLocation() + 'index.php';
			
			var theme = $target.attr("cas:theme");
			
			$.ajax({
				url: url,
				type: 'get',
				data: { action: 'jsonBanners' },
				dataType: 'json',
				beforeSend: function() {
					var jsHost = (("https:" == document.location.protocol) ? "https://" : "http://");
					jQuery.getCss(jsHost + document.location.hostname + "/assets/plugins/nivo-slider/nivo-slider.css");
					jQuery.getScript(jsHost + document.location.hostname + "/assets/plugins/nivo-slider/jquery.nivo.slider.pack.js", function() {
						try {
							if (theme == "theme-default") {
								jQuery.getCss(jsHost + document.location.hostname + "/assets/plugins/nivo-slider/themes/default/default.css");
							}
							else if (theme == "theme-pascal") {
								jQuery.getCss(jsHost + document.location.hostname + "/assets/plugins/nivo-slider/themes/pascal/pascal.css");
							}
							else if (theme == "theme-orman") {
								jQuery.getCss(jsHost + document.location.hostname + "/assets/plugins/nivo-slider/themes/orman/orman.css");
							}
						} catch (err) {
						}
					});
				},
				success: function(response) {
					$target.html('');
					var items = [];
					$.each(response.aaData, function(key, val) {
						if (val.bannerHref == null) {
							items.push('<img src="img/banner/'+val.pictureFile+'" title="'+val.bannerTitle+'" />');
						}
						else {
							items.push('<a href="'+val.bannerHref+'"><img src="img/banner/'+val.pictureFile+'" title="'+val.bannerTitle+'" /></a>');
						}
					});
					$target
						.append(items.join(''))
						.nivoSlider({
							animSpeed: 800,
							pauseTime: 5000
						});
				}
			});
		}
	};

	var Obj = new Object();
	Obj.getBanners = getBanners;
	return Obj;
}

function Brand()
{
	var getBrandsFromProductHavingPicture = function ()
	{
		var $target = $('ul[cas-js=getBrandsFromProductHavingPicture]');
		if ($target.length) {
			var url = $target.attr("cas:url");
			var tpl = $target.html();
			$target.html('');
			
			$.getJSON(url, function(response) {
				var items = [];
				$.each(response.aaData, function(key, val) {
					items.push($.sprintf(tpl, val.brandId, val.brandTitle));
				});
				$target.html(items.join(''));
			});
		}
	};

	var Obj = new Object();
	Obj.getBrandsFromProductHavingPicture = getBrandsFromProductHavingPicture;
	return Obj;
}

function Category()
{
	var getCategoriesFromProductHavingPicture = function ()
	{
		var $target = $('ul[cas-js=getCategoriesFromProductHavingPicture]');
		if ($target.length) {
			var url = $target.attr("cas:url");
			var tpl = $target.html();
			$target.html('');
			
			$.getJSON(url, function(response) {
				var items = [];
				$.each(response.aaData, function(key, val) {
					items.push($.sprintf(tpl, val.categoryId, val.categoryTitle));
				});
				$target.html(items.join(''));
			});
		}
	};

	var Obj = new Object();
	Obj.getCategoriesFromProductHavingPicture = getCategoriesFromProductHavingPicture;
	return Obj;
}

function Attributegroup()
{
	var getAttributegroupsWithAttributes = function ()
	{
		var $target = $('ul[cas-js=getAttributegroupsWithAttributes]');
		if ($target.length) {
			var url = $target.attr("cas:url");
			$target.html('');
			
			$.getJSON(url, function(response) {
				var items = [];
				$.each(response.aaData, function(key1, attributegroup) {
					items.push('<li>');
					items.push('<strong>'+attributegroup.attributegroupTitle+'</strong>');
					items.push('<ul>');
					$.each(attributegroup.attribute.aaData, function(key2, attribute) {
						items.push('<li>');
						items.push('<a href="'+CommonItems.getLocation()+'search.php?attribute='+attribute.attributeId+'">'+attribute.attributeTitle+'</a>');
						items.push('</li>');
					});
					items.push('</ul>');
					items.push('</li>');
				});
				$target.html(items.join(''));
			});
		}
	};

	var Obj = new Object();
	Obj.getAttributegroupsWithAttributes = getAttributegroupsWithAttributes;
	return Obj;
}

function Survey()
{
	var Obj = new Object();
	
	var saveSurvey = function ()
	{
		$.editable.addInputType('jeditable', {
			element : $.editable.types.text.element,
			buttons : function(settings, original) {
				var default_buttons = $.editable.types['defaults'].buttons;
				default_buttons.apply(this, [settings, original]);

				var aid = $(original).attr("id").split("_");
				var table = aid[0];
				var id = aid[1];
				
				if (id > 0) {
					var third = $('<input type="button">');
					third.val(settings.third);
					$(this).append(third);
					$(third).click(function() {
						var formData = [];
						formData.push({ name: "action", value: "deleteSurvey" });
						formData.push({ name: "id", value: id });
						formData.push({ name: "table", value: table });
						$.ajax({
							url: url,
							type: 'post',
							data: formData,
							dataType: 'json',
							success: function(response) {
								getSurvey();
							}
						});
					});
				}
			}
		});
		
		$('.jeditable').editable(function(value, settings) {
			//console.log(this);
			//console.log(value);
			//console.log(settings);
			//return(value);
			
			var aid = $(this).attr("id").split("_");
			var table = aid[0];
			var id = aid[1];
			
			var formData = [];
			formData.push({ name: "action", value: "saveSurvey" });
			formData.push({ name: "id", value: id });
			formData.push({ name: "value", value: value });
			formData.push({ name: "table", value: table });
			
			if (id > 0) {
				//update
			}
			else {
				//insert
				if (table == "surveyq") {
					formData.push({ name: "surveyId", value: $(this).attr("id_survey") });
				}
				else if (table == "surveya") {
					formData.push({ name: "surveyqId", value: $(this).attr("id_surveyq") });
				}
				
			}
			
			/*
			console.log("table: " + table);
			console.log("id: " + id);
			console.log("id_surveyq: " + $(this).attr("id_surveyq"));
			console.log("id_survey: " + $(this).attr("id_survey"));
			*/
			
			$.ajax({
				url: url,
				type: 'post',
				data: formData,
				dataType: 'json',
				complete: function() {
					Obj.getSurvey();
				},
				success: function(response) {
					console.log(response);
				}
			});

		}, {
			id: 'id',
			name: 'value',
			type: "jeditable",
			indicator: jQuery.i18n.prop('LABEL_Saving'),
			submit: jQuery.i18n.prop('BUTTON_Ok'),
			cancel: jQuery.i18n.prop('BUTTON_Cancel'),
			third: jQuery.i18n.prop('BUTTON_Delete'),
			tooltip: jQuery.i18n.prop('LABEL_ClickToEdit'),
			width: 200,
			callback : function(value, settings) {
				//console.log(this);
				//console.log(value);
				//console.log(settings);
			}
		});
	};

	var deleteSurvey = function (surveyId)
	{
		
	};
	
	var getSurvey = function ()
	{
		var $target = $('ul[cas-js=getSurvey]');
		if ($target.length) {
			
			var url = $target.attr("cas:url");
			var surveyId = $target.attr("cas:var");
			
			var formData = [];
			formData.push({ name: "action", value: "jsonSurvey" });
			formData.push({ name: "surveyId", value: surveyId });
			
			$.ajax({
				url: url,
				type: 'get',
				data: formData,
				dataType: 'json',
				beforeSend: function() {
				},
				complete: function() {
					//Obj.saveSurvey();
				},
				statusCode: {
					404: function() {
						CommonItems.casDialog(jQuery.i18n.prop('ALERT_PageNotFound'));
					}
				},
				success: function(response) {
					$target.html('');
					var items = [];
					$.each(response.surveyq, function(keyq, surveyq) {
						items.push('<li>');
						items.push('<div>'+surveyq.surveyqTitle+'</div>');
						items.push('<ul>');
						$.each(surveyq.surveya, function(keya, surveya) {
							items.push('<li>');
							// FIXME: ilk radio input için  required="required" kullanabiliriz. tümünde kullanınca hepsi için seçilmesi geretiği uyarısını veriyor
							items.push('<input type="radio" name="surveyq['+surveyq.surveyqId+']" value="'+surveya.surveyaId+'" />'+surveyq.surveyqId+'-'+surveya.surveyaId+'-');
							items.push('<span id="surveya_'+surveya.surveyaId+'">'+surveya.surveyaTitle+'</span>');
							items.push('</li>');
						});
						items.push('</ul>');
						items.push('</li>');
					});
					items.push('<li>');
					items.push('<button type="submit" onclick="Survey.voteSurvey(this.form); return false;">Vote</button>');
					items.push('</li>');
					$target.append(items.join(''));
				}
			});
		}
	};
	
	var voteSurvey = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'saveUserticket' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						if (response.success == true) {
							CommonItems.casDialog({
								content: jQuery.i18n.prop('ALERT_Completed'),
								onClosed: function () {
									//window.location.reload();
								}
							});
						}
						else {
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				productId: {
					required: true
				},
				productPrice: {
					required: true
				}
			},
			messages: {
				productId: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				productPrice: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};

	var editSurvey = function ()
	{
		var $target = $('ul[cas-js=editSurvey]');
		if ($target.length) {
			
			var url = $target.attr("cas:url");
			var surveyId = $target.attr("cas:var");
			
			var formData = [];
			formData.push({ name: "action", value: "jsonSurvey" });
			formData.push({ name: "surveyId", value: surveyId });
			
			$.ajax({
				url: url,
				type: 'get',
				data: formData,
				dataType: 'json',
				beforeSend: function() {
				},
				complete: function() {
					Obj.saveSurvey();
				},
				statusCode: {
					404: function() {
						CommonItems.casDialog(jQuery.i18n.prop('ALERT_PageNotFound'));
					}
				},
				success: function(response) {
					$target.html('');
					var items = [];
					$.each(response.surveyq, function(keyq, surveyq) {
						items.push('<li>');
						items.push('<div class="jeditable" id="surveyq_'+surveyq.surveyqId+'">'+surveyq.surveyqTitle+'</div>');
						items.push('<ul>');
						$.each(surveyq.surveya, function(keya, surveya) {
							items.push('<li>');
							items.push('<div class="jeditable" id="surveya_'+surveya.surveyaId+'">'+surveya.surveyaTitle+'</div>');
							items.push('</li>');
						});
						items.push('<li>');
						items.push('<div class="jeditable" id_surveyq="'+surveyq.surveyqId+'" id="surveya_0"></div>');
						items.push('</li>');
						items.push('</ul>');
						items.push('</li>');
					});
					items.push('<li>');
					items.push('<div class="jeditable" id_survey="'+response.surveyId+'" id="surveyq_0"></div>');
					items.push('</li>');
					$target.append(items.join(''));
				}
			});
		}
	};
	
	Obj.saveSurvey = saveSurvey;
	Obj.deleteSurvey = deleteSurvey;
	Obj.getSurvey = getSurvey;
	Obj.editSurvey = editSurvey;
	Obj.voteSurvey = voteSurvey;
	return Obj;
}

function Productimpact()
{
	var saveProductimpact = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'saveProductimpact' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						//console.log(response);
						if (response.success == true) {
							getProductimpactByProductId();
							CommonItems.casDialog(jQuery.i18n.prop('ALERT_Completed'));
						}
						else {
							CommonItems.casDialog(jQuery.i18n.prop('ALERT_ErrorOccured'));
						}
					}
				});
			},
			rules: {
				productId: {
					required: true
				},
				productPrice: {
					number: true,
					required: true
				}
			},
			messages: {
				productId: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				productPrice: {
					number: jQuery.i18n.prop('ALERT_PleaseEnterAValidNumber'),
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};
	
	var editProductimpact = function (productimpactId)
	{
		console.log(this);
		// TODO: Product impact düzenlenebilir mi olsun yoksa mysql insert ignore mu olsun
	};
	
	var deleteProductimpact = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'deleteProductimpact' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						//console.log(response);
						if (response.success == true) {
							getProductimpactByProductId();
							CommonItems.casDialog(jQuery.i18n.prop('ALERT_Completed'));
						}
						else {
							CommonItems.casDialog(jQuery.i18n.prop('ALERT_ErrorOccured'));
						}
					}
				});
			},
			rules: {
				productimpactId: {
					required: true
				}
			},
			messages: {
				productimpactId: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};
	
	var getProductimpactByProductId = function ()
	{
		var $target = $('[cas-js=getProductimpactByProductId]');
		if ($target.length) {
			
			var url = $target.attr("cas:url");
			var productId = $target.attr("cas:var");
			
			var formData = [];
			formData.push({ name: "action", value: "jsonProductimpactByProductId" });
			formData.push({ name: "productId", value: productId });
			
			$.ajax( {
				type: "get", 
				url: url, 
				data: formData, 
				dataType: 'json',
				beforeSend: function() {
					$target.html('<img src="assets/css/images/loading.gif"/>');
				},
				complete: function () {
				},
				success: function (response) {
					$target.html('');
					var items = [];
					if (response.iTotalRecords > 0) {
						items.push('<thead>');
						items.push('<tr>');
						items.push('<td>Role</td>');
						items.push('<td>'+jQuery.i18n.prop('LABEL_ListPrice')+'</td>');
						//items.push('<td>Weight Rate</td>');
						//items.push('<td>Weight Price</td>');
						//items.push('<td>Price before tax</td>');
						//items.push('<td>Price after tax</td>');
						items.push('<td>'+jQuery.i18n.prop('LABEL_DiscountRate')+'</td>');
						items.push('<td>'+jQuery.i18n.prop('LABEL_DiscountAmount')+'</td>');
						items.push('<td>'+jQuery.i18n.prop('LABEL_Price')+'</td>');
						items.push('<td width="100"></td>');
						items.push('</tr>');
						items.push('</thead>');
						items.push('<tbody>');
						$.each(response.aaData, function(key, val) {
							var productPrice = Number(val.productPrice);
							var productimpactWeightRate = Number(val.productimpactWeightRate);
							var productimpactWeightPrice = Number(val.productimpactWeightPrice);
							var productPriceBeforeTax = productPrice + productPrice * productimpactWeightRate + productimpactWeightPrice;
							var productimpactDiscountRate = Number(val.productimpactDiscountRate);
							var productimpactDiscountPrice = Number(val.productimpactDiscountPrice);
							var taxonomyRate = Number(val.taxonomyRate);
							
							var omitTaxonomyRate = true;
							var productPriceAfterTax = 0;
							if (omitTaxonomyRate) {
								productPriceAfterTax = productPriceBeforeTax;
							}
							else {
								productPriceAfterTax = productPriceBeforeTax + productPriceBeforeTax * taxonomyRate;
							}
							
							var productPriceAfterDiscount = productPriceAfterTax - productPriceAfterTax * productimpactDiscountRate - productimpactDiscountPrice;
							items.push('<tr>');
							items.push('<td>'+val.roleTitle+'</td>');
							items.push('<td>'+productPrice+'</td>');
							//items.push('<td>'+productimpactWeightRate+'</td>');
							//items.push('<td>'+productimpactWeightPrice+'</td>');
							//items.push('<td>'+productPriceBeforeTax.toFixed(2)+'</td>');
							//items.push('<td>'+productPriceAfterTax.toFixed(2)+'</td>');
							items.push('<td>'+productimpactDiscountRate+'</td>');
							items.push('<td>'+productimpactDiscountPrice+'</td>');
							items.push('<td>'+productPriceAfterDiscount.toFixed(2)+'</td>');
							//items.push('<td><a href="javascript:Productimpact.deleteProductimpact('+val.productimpactId+');">sil</a></td>');
							items.push('<td>');
							items.push('<form method="post" action="'+url+'">');
							items.push('<input type="hidden" name="productimpactId" value="'+val.productimpactId+'" readonly="readonly" required="required" />');
							//items.push('<button type="submit" onclick="Productimpact.editProductimpact(this.form);">Düzenle</button>');
							items.push('<button type="submit" onclick="Productimpact.deleteProductimpact(this.form);">Sil</button>');
							items.push('</form>');
							items.push('</td>');
							items.push('</tr>');
						});
						items.push('</tbody>');
					}
					else {
						items.push('<tr><td>'+jQuery.i18n.prop('ALERT_NoRecords')+'</td></tr>');
					}
					$('<table/>', {
						'html': items.join('')
					}).juitable().appendTo($target);
				}
			});
		}
	};
	
	var Obj = new Object();
	Obj.editProductimpact = editProductimpact;
	Obj.saveProductimpact = saveProductimpact;
	Obj.deleteProductimpact = deleteProductimpact;
	Obj.getProductimpactByProductId = getProductimpactByProductId;
	return Obj;
}

function Attributeimpact()
{
	var saveAttributeimpact = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'saveAttributeimpact' },
					dataType: 'json',
					clearForm: false,
					resetForm: true,
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						//console.log(response);
						if (response.success == true) {
							getAttributeimpactByProductId();
							CommonItems.casDialog(jQuery.i18n.prop('ALERT_Completed'));
						}
						else {
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				productId: {
					required: true
				},
				attributeId: {
					required: true
				}
			},
			messages: {
				productId: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				attributeId: {
					required: jQuery.i18n.prop('ALERT_PleaseChooseAnOption')
				}
			}
		});
		return false;
	};
	
	var deleteAttributeimpact = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'deleteAttributeimpact' },
					dataType: 'json',
					clearForm: false,
					resetForm: true,
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						//console.log(response);
						if (response.success == true) {
							getAttributeimpactByProductId();
							CommonItems.casDialog(jQuery.i18n.prop('ALERT_Completed'));
						}
						else {
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				attributeimpactId: {
					required: true
				}
			},
			messages: {
				attributeimpactId: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};

	var getAttributeimpactByProductId = function ()
	{
		var $target = $('[cas-js=getAttributeimpactByProductId]');
		if ($target.length) {
			var productId = $target.attr("cas:var");
			var url = $target.attr("cas:url");
			
			var formData = [];
			formData.push({ name: "action", value: "jsonAttributeimpactByProductId" });
			formData.push({ name: "productId", value: productId });
			
			$.ajax( {
				type: "get", 
				url: url, 
				data: formData, 
				dataType: 'json',
				beforeSend: function() {
					$target.html('<img src="assets/css/images/loading.gif"/>');
				},
				success: function (response) {
					$target.html('');
					var items = [];
					if (response.iTotalRecords > 0) {
						$.each(response.aaData, function(key, val) {
							items.push('<li>');
							items.push('<span style="padding-right: 1em;">'+val.attributeId+'</span>');
							items.push('<span style="padding-right: 1em;">'+val.attributeimpactWeightRate+'</span>');
							items.push('<span style="padding-right: 1em;">'+val.attributeimpactWeightPrice+'</span>');
							items.push('<span style="padding-right: 1em;">'+val.attributeimpactDiscountRate+'</span>');
							items.push('<span style="padding-right: 1em;">'+val.attributeimpactDiscountPrice+'</span>');
							items.push('<form method="post" action="'+url+'">');
							items.push('<input type="hidden" name="attributeimpactId" value="'+val.attributeimpactId+'" readonly="readonly" required="required" />');
							items.push('<button type="submit" onclick="Attributeimpact.deleteAttributeimpact(this.form);">'+jQuery.i18n.prop('BUTTON_Delete')+'</button>');
							items.push('</form>');
							items.push('</li>');
						});
					}
					else {
						items.push('</li>'+jQuery.i18n.prop('ALERT_NoRecords')+'</li>');
					}
					$('<ul/>', {
						'id': '',
						'class': '',
						'html': items.join('')
					}).appendTo($target);
				}
			});
		}
	};

	var Obj = new Object();
	Obj.saveAttributeimpact = saveAttributeimpact;
	Obj.deleteAttributeimpact = deleteAttributeimpact;
	Obj.getAttributeimpactByProductId = getAttributeimpactByProductId;
	return Obj;
}

function CommonItems()
{
	// En tepede olmalı
	jQuery.i18n.properties({
		name		: 'Messages', 
		path		: 'configs/', 
		mode		: 'both',
		language	: 'tr',
		callback	: function() {
			// We specified mode: 'both' so translated values will be
			// available as JS vars/functions and as a map

			// Accessing a simple value through the map
			//jQuery.i18n.prop('msg_hello');
			// Accessing a value with placeholders through the map
			//jQuery.i18n.prop('msg_complex', 'John');

			// Accessing a simple value through a JS variable
			//alert(msg_hello +' '+ msg_world);
			// Accessing a value with placeholders through a JS function
			//alert(msg_complex('John'));
		}
	});
	
	$.validator.setDefaults({
		errorPlacement: function(error, element) {
			error.insertAfter(element.parent()).delay(3200).fadeOut(300).addClass("c-ff0000");
		},
		highlight: function(input) {
			$(input).addClass("ui-state-highlight");
		},
		unhighlight: function(input) {
			$(input).removeClass("ui-state-highlight");
		}
	});

	
	$("ul.ulform").ulform();
	
	$("input, textarea, select, table").addClass("ui-widget-content");//ui-corner-all
	$("table caption").addClass("ui-widget-header");//ui-corner-all

	$(".datepicker").datepicker({
		dateFormat: 'yy-mm-dd'
	});
	/*
	$(".datepicker").datepicker({
		yearRange: 'c-50:c',
		maxDate: new Date()
	});
	*/
	
	// START: ADMIN PAGE
	var datetimepicker = $('input.datetimepicker');
	if (datetimepicker.length) {
		$(datetimepicker).datetimepicker({
			dateFormat: 'yy-mm-dd',
			showSecond: true,
			timeFormat: 'hh:mm:ss'
		});
	}
	
	var timepicker = $('input.timepicker');
	if (timepicker.length) {
		$(timepicker).timepicker({
			showSecond: true,
			timeFormat: 'hh:mm:ss'
		});
	}
	
	var $wysiwyg = $('textarea.wysiwyg');
	var wysiwyg_editor = "ckeditor";//ckeditor, elrte
	var language = "tr";
	if ($wysiwyg.length) {
		if (wysiwyg_editor == "ckeditor") {
			$wysiwyg.ckeditor({
				//toolbar				: 'Basic',
				toolbarStartupExpanded	: false,
				uiColor					: 'transparent',
				language				: language,
				skin					: 'kama'
			});
		}
		else if (wysiwyg_editor == "elrte") {
			var jsHost = (("https:" == document.location.protocol) ? "https://" : "http://");
			jQuery.getCss(jsHost + document.location.hostname + "/assets/plugins/elrte/css/elrte.min.css");
			jQuery.getCss(jsHost + document.location.hostname + "/assets/plugins/elfinder/css/elfinder.css");
			if (language == "tr") {
				jQuery.getScript(jsHost + document.location.hostname + "/assets/plugins/elrte/js/i18n/elrte.tr.js");
				jQuery.getScript(jsHost + document.location.hostname + "/assets/plugins/elfinder/js/i18n/elfinder.tr.js");
			}
			jQuery.getScript(jsHost + document.location.hostname + "/assets/plugins/elfinder/js/elfinder.min.js");
			jQuery.getScript(jsHost + document.location.hostname + "/assets/plugins/elrte/js/elrte.min.js", function() {
				try {
					var opts = {
							cssClass : 'el-rte',
							lang     : language,
							height   : 450,
							toolbar  : 'complete',
							//cssfiles : ['css/elrte-inner.css'],
							fmOpen   : function(callback) {
								$('<div id="myelfinder"></div>').elfinder({
									url : jsHost + document.location.hostname + "/assets/plugins/elfinder/connectors/php/connector.php",
									lang : language	,
									dialog : { width : 900, modal : true, title : 'Files' }, // open in dialog
									closeOnEditorCallback : true, // close elFinder after file select
									editorCallback : callback // pass callback to editor
								});
							}
						};
					$wysiwyg.elrte(opts);
				} catch (err) {
					console.log(err);
				}
			});
		}
	}
	
	var editable = $('.editable');
	if (editable.length) {
		$(editable).editable('http://www.example.com/save.php');
	}
	// END: ADMIN PAGE

	$(".accordion").accordion();

	$(".buttonset").buttonset();
	
	$("button, a.button").button();
	
	$("div.tabs").tabs({
		cookie: {
			expires: 1
		}
	});
	
	var qtip = $("input[title], select[title], textarea[title]");
	if (qtip.length) {
		$(qtip).qtip({
			position: {
				at: "right center",
				my: "left center"
			}
		});
	}
	
	var jqzoom = $('a.jqzoom');
	if (jqzoom.length && global_settings.use_jqzoom) {
		$(jqzoom).jqzoom({
			preloadText: jQuery.i18n.prop('ALERT_Loading'),
			zoomType: "reverse",
			position: "right"
		}).find("img")/*.css({
			float: "left",
			marginRight: "20px",
			background: "#000"
		})*/;
	}
	else {
		$('a.jqzoom').click(function() { return false; });
	}
	
	$("input.phone").each(function() {
		$(this).mask("999-999-9999");
	});
	
	$("input.date").each(function() {
		//$(this).mask("99.99.9999");
		$(this).mask("99/99/9999");
		//$(this).mask("9999-99-99");
	});
	
	$("input.ccno").each(function() {
		$(this).mask("9999-9999-9999-9999");
	});

	$("input.cvc").each(function() {
		$(this).mask("999");
	});
	
	$("input.expDate").each(function() {
		$(this).mask("99-99");
	});
	
	$(".multiselect").each(function() {
		$(this).multiselect({
			/*
			click: function (event, ui) {
				if (ui.checked) {
					$('<li/>', {
						'id': 'p_multiselect_'+ui.value,
						'html': ui.text
					}).appendTo('#selectedProducts');
				}
				else {
					$('li#p_multiselect_'+ui.value).remove();
				}
			},
			checkAll: function (event, ui) {
				var array_of_checked_values = $(this).multiselect("getChecked").map(function () {
					return this.value;
				}).get();
				$.each(array_of_checked_values, function (key, val) {
					alert(key+':'+val);
				});
			},
			*/
			checkAllText: jQuery.i18n.prop('LABEL_All'),
			uncheckAllText: "Hiçbiri",
			noneSelectedText: "Seçiniz",
			selectedText: '# seçili',
			selectedList: 3 // 0-based index
		}).multiselectfilter({
			filter: function(event, matches) {
				var first_match = $( matches[0] );
			}
		});
	});

	$("a.fancybox").fancybox({
		transitionIn		: 'elastic',
		transitionOut		: 'elastic',
		speedIn				: 600, 
		speedOut			: 200,
		hideOnOverlayClick	: true,
		modals				: true,
		hideOnContentClick	: true,
		enableEscapeButton	: true,
		showCloseButton		: true
	});

	var casLoaderShow = function ()
	{
		if(($("#blackoutBg").length > 0) && ($("#loaderOuter").length > 0)) // eğer loader gösteriliyorsa
			return;
		
		var loaderImagePath = "assets/css/images/page_loader.gif";
		var loaderHtml = '<div id="blackoutBg"></div>';
		loaderHtml += '<div id="loaderOuter">';
		loaderHtml += '<img src="' + loaderImagePath + '" />';
		loaderHtml += '</div>';
		
		$("body").append(loaderHtml);
		
		var blackoutObject = $("#blackoutBg");
		var loaderOuter = $("#loaderOuter");
		var loaderImage = $("#loaderOuter img");	
		
		$(window).resize(function(){
			var wWidth = $(window).width();
			var wHeight = $(window).height();
			var loaderWidth = $("#loaderOuter").outerWidth();
			var loaderHeight = $("#loaderOuter").outerHeight();
			var loaderLeft = (wWidth - loaderWidth) / 2;
			var loaderTop = (wHeight - loaderHeight) / 2;
			
			loaderOuter.css({
				"display":"block",
				"left":loaderLeft,
				"top":loaderTop
			});
		});
		
		$(window).resize();
	};
	
	var casLoaderHide = function ()
	{
		$("#blackoutBg").remove();
		$("#loaderOuter").remove();
		$(window).unbind("resize");
	};
	
	var casDialog = function (options)
	{
		casLoaderHide();
		
		var defaultOptions = {
			title: jQuery.i18n.prop('LABEL_HeaderDialog'),
			content: '',
			onClosed: function() {}
		};
		
		if (typeof(options) === 'object') {
			options = $.extend(defaultOptions, options);
		}
		else if (typeof(options) === 'string') {
			options = $.extend(defaultOptions, { content: options });
		}
		
		var d = $("<div/>")
		.html(options.content)
		.dialog({
			title: options.title,
			resizable: false,
			height: 140,
			modal: true,
			buttons: {
				Ok: function() {
					$(this).dialog("close");
				}
			},
			close: options.onClosed
		});
		
		setTimeout(function() { $(d).dialog("close"); }, 3000);
		
		// TODO: Remove title bar
		//$(".ui-dialog-titlebar").hide();
	};
	
	var fancyboxPopup = function (t)
	{
		$("<div/>")
			.load($(t).attr("href"))
			.dialog({
				title: $(t).attr("title"),
				resizable: false,
				//height: $(t).attr("height"),
				width: '75%',
				position: 'top',
				modal: true,
				buttons: {
					Ok: function() {
						$(this).dialog("close");
					}
				}
			});
		return false;
	};
	
	var fancyboxThumbnail = function ()
	{
		var $target = $('a.fancyboxThumbnail');
		if ($target.length) {
			$.each($target, function(){
				var index = $(this).index();
				if(index % 4 == 0)
					$(this).css("margin-right","0");
				$(this).find("img").css({
					"width": 50
				});
			}).fancybox({
				onComplete: function() {
					$("#fancybox-img").finezoom({
						zoomIn: "assets/plugins/finezoom/zoom_in.png",
						zoomOut: "assets/plugins/finezoom/zoom_out.png",
						reset: "assets/plugins/finezoom/zoom_reset.png",
						toolbar: true,
						toolbarPos: [ "left", "top" ]
					});
				}
			});
		}
	};

	var getLocation = function ()
	{
		return (window.location.pathname.split("/",3).concat("").join("/"));
		/*
		var location = window.location;
		var path = location.pathname;
		if (document.all) {
			path = path.replace(/\\/g,"/");
		}
		path = path.substr(0, path.lastIndexOf("/")+1);
		return location.protocol + '//' + location.hostname + path;
		*/
	};
	
	var Obj = new Object();
	Obj.fancyboxPopup = fancyboxPopup;
	Obj.fancyboxThumbnail = fancyboxThumbnail;
	Obj.casDialog = casDialog;
	Obj.casLoaderShow = casLoaderShow;
	Obj.casLoaderHide = casLoaderHide;
	Obj.getLocation = getLocation;
	return Obj;
}


function Company()
{
	this.saveCompany = function(form){
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'saveCompany' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
						CommonItems.casLoaderShow();
					},
					success: function(response) {
						if (response.success == true) {
							CommonItems.casDialog(response.msg);
						}
						else {
							CommonItems.casDialog(response.msg);
						}
					},
					error:function(){
						CommonItems.casDialog("Beklenmedik Hata! Daha sonra tekrar deneyin!");
					}
				});
			},
			rules: {
				companyTitle: {
					required: true
				},
				companyTax: {
					required: true
				},
				companyPhone: {
					required: true
				},
				companyFax: {
					required: true
				},
				companyAddress: {
					required: true
				}
			},
			messages: {
				companyTitle: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				companyTax: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				companyPhone: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				companyFax: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				companyAddress: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		
	}
}