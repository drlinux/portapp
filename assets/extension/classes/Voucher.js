// INIT ----------------------------------------------------------
$(function(){
	Voucher = new Voucher();
});
//----------------------------------------------------------------

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