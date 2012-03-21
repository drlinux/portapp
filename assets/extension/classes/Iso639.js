// INIT ----------------------------------------------------------
$(function(){
	Iso639 = new Iso639();
	Iso639.getBreadcrumbsIso639();
});
//----------------------------------------------------------------

function Iso639()
{
	var $target = $('button[cas-js=getBreadcrumbsIso639]');
	var uri = $target.attr("cas:uri");
	var var1 = $target.attr("cas:var");
	
	var tree4breadcrumbsIso639 = function(json) {
		var op = '<ul>';
		$.each(json.aaData, function(key, val) {
			op += '<li><a href="' + CommonItems.getLocation() + 'index.php?action=changeLanguage&language=' + val.iso639Id + '&uri='+uri+'">' + val.iso639Title + '</a></li>';
		});
		op += '</ul>';
		return op;
	};
	
	this.getBreadcrumbsIso639 = function() {
		if ($target.length) {
			$.ajax( {
				type: "get", 
				url: CommonItems.getLocation() + 'index.php', 
				data: [{ name: "action", value: "breadcrumbsIso639" }], 
				dataType: 'json',
				success: function (response) {
					if (response.iTotalRecords > 1) {
						$target
						.button({
							label: response.options[var1],
							text: true,
							icons: {
								primary: "ui-icon-flag",
								secondary: "ui-icon-triangle-1-s"
							}
						})
						.menu({
							crumbDefaultText: jQuery.i18n.prop('ALERT_PleaseMakeAChoice'),
							backLinkText: jQuery.i18n.prop('BUTTON_Back'),
							topLinkText: jQuery.i18n.prop('LABEL_All'),
							content: tree4breadcrumbsIso639(response),
							flyOut: true,
							backLink: false
						});
					}
					else {
						$target.hide();
					}
				}
			});
		}
	};
}