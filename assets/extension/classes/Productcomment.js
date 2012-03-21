// INIT ----------------------------------------------------------
$(function(){
	Productcomment = new Productcomment();
	Productcomment.getProductcommentsByProductId();
});
//----------------------------------------------------------------

function Productcomment()
{
	var getProductcommentsByProductId = function ()
	{
		var $target = $('[cas-js=getProductcommentsByProductId]');
		if ($target.length) {
			var url = $target.attr("cas:url");
			var productId = $target.attr("cas:var");
			var tpl = $target.html();
			$target.html('');
			
			var formData = [];
			formData.push({ name: "action", value: "jsonProductcommentsByProductId" });
			formData.push({ name: "productId", value: productId });
			
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'get',
				data: formData,
				success: function(response) {
					$target.html('');
					var items = [];
					$.each(response.aaData, function(key, val) {
						items.push($.sprintf(tpl, val.productcommentContent, val.productcommentDatetime, val.userFirstname));
					});
					$target.html(items.join(''));
				}
			});
		}
	};
	
	var Obj = new Object();
	Obj.getProductcommentsByProductId = getProductcommentsByProductId;
	return Obj;
}