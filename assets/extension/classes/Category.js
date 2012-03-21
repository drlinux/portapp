// INIT ----------------------------------------------------------
$(function(){
	Category = new Category();
	Category.getCategoriesFromProductHavingPicture();
});
//----------------------------------------------------------------


function Category()
{
	var getCategoriesFromProductHavingPicture = function ()
	{
		var $target = $('ul[cas-js=getCategoriesFromProductHavingPicture]');
		if ($target.length) {
			var url = $target.attr("cas:url");
			var tpl = $target.html();
			$target.html('');
			
			$.getJSON(url, function(response) {
				var items = [];
				$.each(response.aaData, function(key, val) {
					items.push($.sprintf(tpl, val.categoryId, val.categoryTitle));
				});
				$target.html(items.join(''));
			});
		}
	};

	var Obj = new Object();
	Obj.getCategoriesFromProductHavingPicture = getCategoriesFromProductHavingPicture;
	return Obj;
}