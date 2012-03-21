// INIT ----------------------------------------------------------
$(function(){
	Userticket = new Userticket();
});
//----------------------------------------------------------------

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