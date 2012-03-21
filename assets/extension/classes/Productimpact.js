// INIT ----------------------------------------------------------
$(function(){
	Productimpact = new Productimpact();
	Productimpact.getProductimpactByProductId();
});
//----------------------------------------------------------------

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