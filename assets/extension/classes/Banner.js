// INIT ----------------------------------------------------------
$(function(){
	Banner = new Banner();
	Banner.getBanners();
});
//----------------------------------------------------------------

function Banner()
{
	var getBanners = function ()
	{
		return;
		
		var $target = $('[cas-js=getBanners]');
		if ($target.length) {
			
			var url = CommonItems.getLocation() + 'index.php';
			
			var theme = $target.attr("cas:theme");
			
			$.ajax({
				url: url,
				type: 'get',
				data: { action: 'jsonBanners' },
				dataType: 'json',
				beforeSend: function() {
					var jsHost = (("https:" == document.location.protocol) ? "https://" : "http://");
					jQuery.getCss(jsHost + document.location.hostname + "/assets/plugins/nivo-slider/nivo-slider.css");
					jQuery.getScript(jsHost + document.location.hostname + "/assets/plugins/nivo-slider/jquery.nivo.slider.pack.js", function() {
						try {
							if (theme == "theme-default") {
								jQuery.getCss(jsHost + document.location.hostname + "/assets/plugins/nivo-slider/themes/default/default.css");
							}
							else if (theme == "theme-pascal") {
								jQuery.getCss(jsHost + document.location.hostname + "/assets/plugins/nivo-slider/themes/pascal/pascal.css");
							}
							else if (theme == "theme-orman") {
								jQuery.getCss(jsHost + document.location.hostname + "/assets/plugins/nivo-slider/themes/orman/orman.css");
							}
						} catch (err) {
						}
					});
				},
				success: function(response) {
					$target.html('');
					var items = [];
					$.each(response.aaData, function(key, val) {
						if (val.bannerHref == null) {
							items.push('<img src="img/banner/'+val.pictureFile+'" title="'+val.bannerTitle+'" />');
						}
						else {
							items.push('<a href="'+val.bannerHref+'"><img src="img/banner/'+val.pictureFile+'" title="'+val.bannerTitle+'" /></a>');
						}
					});
					$target
						.append(items.join(''))
						.nivoSlider({
							animSpeed: 800,
							pauseTime: 5000
						});
				}
			});
		}
	};

	var Obj = new Object();
	Obj.getBanners = getBanners;
	return Obj;
}
