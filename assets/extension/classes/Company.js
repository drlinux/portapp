// INIT ----------------------------------------------------------
$(function(){
	Company = new Company();
});
//----------------------------------------------------------------

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
				companyAddress: {
					required: true
				},
				userPosition: {
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
				companyAddress: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userPosition: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		
	}
}
