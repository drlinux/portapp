// INIT ----------------------------------------------------------
$(function(){
	Productattributemovement = new Productattributemovement();
	Productattributemovement.getProductattributemovementByProductattributeId();
});
//----------------------------------------------------------------

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