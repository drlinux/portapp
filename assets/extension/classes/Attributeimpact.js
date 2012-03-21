// INIT ----------------------------------------------------------
$(function(){
	Attributeimpact = new Attributeimpact();
	Attributeimpact.getAttributeimpactByProductId();
});
//----------------------------------------------------------------

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