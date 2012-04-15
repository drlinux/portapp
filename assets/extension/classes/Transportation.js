// INIT ----------------------------------------------------------
$(function(){
	Transportation = new Transportation();
});
//----------------------------------------------------------------

function Transportation()
{
	var Obj = new Object();
	
	var getTransportation = function (paymentgroupId, total)
	{
		$('#divTotalCostInfo').hide();
		var $target = $('#divAlertTransportation');
		$.ajax({
			type: "get",
			url: CommonItems.getLocation() + 'sales.php',
			data: 'action=jsonPaymentgroup&paymentgroupId=' + paymentgroupId,
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
					$target.append('<h2 name="nameTransportation">Taşıma</h2>');
					var items = [];
					if (response.transportation.iTotalRecords > 0) {
						items.push('<thead>');
						items.push('<tr>');
						items.push('<td width="50px"></td>');
						items.push('<td width="50px"></td>');
						items.push('<td>Taşıma Firması</td>');
						items.push('<td width="100px">Taşıma Ücreti</td>');
						items.push('</tr>');
						items.push('</thead>');
						items.push('<tbody>');
						$.each(response.transportation.aaData, function(key, val) {
							items.push('<tr>');
							items.push('<td><input type="radio" name="transportationId" value="' + val.transportationId + '" onclick="Transportation.getContinueForDeliveryaddresses(' + val.transportationPrice + ', ' + total + ');" /></td>');
							items.push('<td><img src="img/transportation/' + val.pictureFile + '" width="50" /></td>');
							items.push('<td>' + val.transportationTitle + '</td>');
							items.push('<td>' + val.transportationPrice + '</td>');
							items.push('</tr>');
						});
						items.push('</tbody>');
						items.push('<tfoot id="divGrandtotalWithTransportation"></tfoot>');
						
						$('<table/>', {
							'html': items.join('')
						}).juitable().appendTo($target);
					}
					else {
						items.push('Taşıma firması tanımlı değil');
						$target.append(items.join(''));
					}
					$target.append('<div cas-js="getDeliveryaddresses" cas:var1="eligable"></div>');
				}
			}
		});
		$('#divTotalCostInfo').find('.totalCostInfo').find('label').html(total);
	};
	
	var getContinueForDeliveryaddresses = function (transportationimpactPrice, total)
	{
		
		total = (total+transportationimpactPrice).toFixed(2);
		
		var $target = $('#divGrandtotalWithTransportation');
		
		var items = [];
		items.push('<tr><td></td><td></td><td>Genel Toplam</td><td>'+total+'</td></tr>');
		$target.html(items.join(''));
		
		if ( User.checkAuthenticated() ) {
			Postaladdress.getDeliveryaddresses();
		}
		else {
			CommonItems.casDialog("Giriş yapmalısınız");
			//window.location.replace( CommonItems.getLocation() + 'index.php?action=login&uri=' + window.location.href );
			// TODO: login formunu popup şeklinde göster
		}
		
		return false;
	};
	
	var getContinueForCheckout = function ()
	{
		var $target = $('#divContinueForCheckout');
		$target.html('');
		$('<button/>', {
			'id': 'buttonContinueForCheckout',
			'class': 'fr',
			html: 'Sonraki Adım &raquo;'
		})
		.button()
		.bind("click", function() {
			var formData = $("[cas-js=getShoppingbasket2]").serializeArray();
			formData.push({ name: "action", value: "setParameters" });
			//alert("POSTing this:\n" + jQuery.param(formData));
			
			//alert(CommonItems.getLocation() + 'productorder.php?' + jQuery.param(formData));
			
			window.location.replace( CommonItems.getLocation() + 'productorder.php?' + jQuery.param(formData) );
			return false;
		})
		.appendTo($target);
	};
	
	Obj.getTransportation = getTransportation;
	Obj.getContinueForDeliveryaddresses = getContinueForDeliveryaddresses;
	Obj.getContinueForCheckout = getContinueForCheckout;
	return Obj;
}