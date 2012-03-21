// INIT ----------------------------------------------------------
$(function(){
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
});
//----------------------------------------------------------------

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