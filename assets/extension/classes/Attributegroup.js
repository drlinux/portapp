// INIT ----------------------------------------------------------
$(function(){
	Attributegroup = new Attributegroup();
	Attributegroup.getAttributegroupsWithAttributes();
});
//----------------------------------------------------------------

function Attributegroup()
{
	var getAttributegroupsWithAttributes = function ()
	{
		var $target = $('ul[cas-js=getAttributegroupsWithAttributes]');
		if ($target.length) {
			var url = $target.attr("cas:url");
			$target.html('');
			
			$.getJSON(url, function(response) {
				var items = [];
				$.each(response.aaData, function(key1, attributegroup) {
					items.push('<li>');
					items.push('<strong>'+attributegroup.attributegroupTitle+'</strong>');
					items.push('<ul>');
					$.each(attributegroup.attribute.aaData, function(key2, attribute) {
						items.push('<li>');
						items.push('<a href="'+CommonItems.getLocation()+'search.php?attribute='+attribute.attributeId+'">'+attribute.attributeTitle+'</a>');
						items.push('</li>');
					});
					items.push('</ul>');
					items.push('</li>');
				});
				$target.html(items.join(''));
			});
		}
	};

	var Obj = new Object();
	Obj.getAttributegroupsWithAttributes = getAttributegroupsWithAttributes;
	return Obj;
}