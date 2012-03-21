// INIT ----------------------------------------------------------
$(function(){
	Brand = new Brand();
	Brand.getBrandsFromProductHavingPicture();
});
//----------------------------------------------------------------

function Brand()
{
	var getBrandsFromProductHavingPicture = function ()
	{
		var $target = $('ul[cas-js=getBrandsFromProductHavingPicture]');
		if ($target.length) {
			var url = $target.attr("cas:url");
			var tpl = $target.html();
			$target.html('');
			
			$.getJSON(url, function(response) {
				var items = [];
				$.each(response.aaData, function(key, val) {
					items.push($.sprintf(tpl, val.brandId, val.brandTitle));
				});
				$target.html(items.join(''));
			});
		}
	};

	var Obj = new Object();
	Obj.getBrandsFromProductHavingPicture = getBrandsFromProductHavingPicture;
	return Obj;
}