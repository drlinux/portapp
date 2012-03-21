// INIT ----------------------------------------------------------
$(function(){
	Page = new Page();
	Page.getPage();
	Page.getPageProducts();
});
//----------------------------------------------------------------

function Page()
{
	var getPage = function ()
	{
		var $target = $('div[cas-js=getPage]');
		if ($target.length) {
			var url = CommonItems.getLocation() + 'page.php';
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'get',
				data: ({ action: 'jsonPage' }),
				success: function(response) {
					$target.html('');
					var items = [];
					$.each(response.aaData, function(key, val) {
						items.push('<a href="'+url+'?pageId=' + val.pageId + '">'+val.pageTitle+'</a>');
					});
					$target.html(items.join(''));
				}
			});
		}
	};

	var getPageProducts = function ()
	{
		var $target = $('div[cas-js=getPageProducts]');
		if ($target.length) {
			var url = CommonItems.getLocation() + 'page.php';
			$.ajax({
				url: url,
				dataType: 'json',
				type: 'get',
				data: ({ action: 'jsonPage', pageId: 6 }),
				success: function(response) {
					$target.html('');
					var items = [];
					$.each(response.aaData, function(key, val) {
						items.push('<a href="'+url+'?pageId=' + val.pageId + '">'+val.pageTitle+'</a>');
					});
					$target.html(items.join(''));
				}
			});
		}
	};

	var Obj = new Object();
	Obj.getPage = getPage;
	Obj.getPageProducts = getPageProducts;
	return Obj;
}