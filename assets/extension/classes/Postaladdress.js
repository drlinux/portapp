// INIT ----------------------------------------------------------
$(function(){
	Postaladdress = new Postaladdress();
	Postaladdress.getDeliveryaddresses();
	Postaladdress.getInvoiceaddresses();
});
//----------------------------------------------------------------

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