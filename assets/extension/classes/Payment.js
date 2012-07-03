// INIT ----------------------------------------------------------
$(function(){
	Payment = new Payment();
});
//----------------------------------------------------------------

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
							window.location.replace( CommonItems.getLocation() + 'showproductorder.php?productorderId=' + response.productorderId );
						}
					});
				}
				else {
					CommonItems.casDialog(response.msg);
				}
			},
			error:function(a, b, c){
				alert(JSON.stringify(a));
				alert(b);
				alert(c);
			}
		});
		return false;
	};
	
	var Obj = new Object();
	Obj.checkBincode = checkBincode;
	Obj.confirmOrder = confirmOrder;
	return Obj;
}