function GMAPHelper()
{
	var loadMap = function ()
	{
		// google maps code - use jQuery getScript() to load google maps after DOM load is complete
		var $target = $('div[cas-js=getMap]');
		if ($target.length) {
			var gmJsHost = (("https:" == document.location.protocol) ? "https://" : "http://");
			jQuery.getScript(gmJsHost + "maps.googleapis.com/maps/api/js?sensor=false&language=tr&callback=GMAPHelper.initialize", function() {
				try {
					//var pageTracker = _gat._getTracker(code);
					//pageTracker._trackPageview();
				} catch (err) {
				}
			});
		}
	};

	var initialize = function ()
	{
		var $target = $('div[cas-js=getMap]');
		if ($target.length) {
			$.each($target, function(index, element) {
				var lat = $(element).attr("cas:lat");
				var lng = $(element).attr("cas:lng");
				var html = $(element).html();
				var w = $(element).attr("cas:width");
				var h = $(element).attr("cas:height");
				var draggable = $(element).attr("cas:draggable") === 'true' ? true : false;
				
				if (lat != null && lat != "" && lng != null && lng != "") {
					handle_geolocation_query(element, html, lat, lng, draggable);
				}
				else {
					// Try W3C Geolocation (Preferred)
					if(navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(function (geoposition) {
							handle_geolocation_query(element, html, geoposition.coords.latitude, geoposition.coords.longitude, draggable);
						}, handle_error);
					}
				}
				
				$(element).css({
					border: '1px solid #e4e4de',
					height: h,
					width: w
				});
				
			});
		}
	};
	
	var handle_geolocation_query = function (element, html, lat, lng, draggable)
	{
		var position = new google.maps.LatLng(lat, lng);
		
		var myOptions = {
				center: position,
				zoom: 16,
				mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		//var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		var map = new google.maps.Map($(element).get(0), myOptions);
		
		var marker = new google.maps.Marker({
			position: position, 
			map: map,
			draggable: draggable,
			title:"Hello World!"
		});
		
		var infowindow = new google.maps.InfoWindow({
			content: html,
			position: position
		});
		infowindow.open(map);
		
		google.maps.event.addListener(marker, 'click', function(event) {
			map.setZoom(16);
		});
		
		google.maps.event.addListener(marker, 'dragend', function(event) {
			var point = marker.getPosition();
			map.panTo(point);
			$('[cas-map=latitude]').val(event.latLng.Qa);
			$('[cas-map=longitude]').val(event.latLng.Ra);
		});
		
		google.maps.event.addListener(map, 'zoom_changed', function() {
			var zoomLevel = map.getZoom();
			map.setCenter(position);
			//infowindow.setContent('Zoom: ' + zoomLevel);
			infowindow.setContent(html);
		});
		
		/*
		var image_url = "https://maps.google.com/maps/api/staticmap?sensor=false&center=" + geoposition.coords.latitude + "," +
			geoposition.coords.longitude + "&zoom=15&size=400x300&markers=color:blue|label:S|" +
			geoposition.coords.latitude + ',' + geoposition.coords.longitude;
		jQuery("#map").remove();
		jQuery("#liMap").append(jQuery(document.createElement("img")).attr("src", image_url).attr('id','map'));
		//$("#liMap").html(jQuery(document.createElement("img")).attr("src", image_url));
		return
		*/ 
	};

	var handle_error = function (error)
	{
		switch(error.code) {
			case error.PERMISSION_DENIED: alert("user did not share geolocation data");
			break;

			case error.POSITION_UNAVAILABLE: alert("could not detect current position");
			break;

			case error.TIMEOUT: alert("retrieving position timed out");
			break;

			default: alert("unknown error");
			break;
	    }
	};
	
	var Obj = new Object();
	Obj.loadMap = loadMap;
	Obj.initialize = initialize;
	Obj.handle_geolocation_query = handle_geolocation_query;
	Obj.handle_error = handle_error;
	return Obj;
}