// INIT ----------------------------------------------------------
$(function(){
	Productorder = new Productorder();
});
//----------------------------------------------------------------

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