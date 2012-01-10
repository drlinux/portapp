<script type="text/javascript"
	src="http://maps.google.com/maps/api/js?sensor=false"></script>

	<article>
	
		<div class="areaHeader">
			<span class="museo500">Anket</span>
		</div>
		
		<form method="post" action="{$SCRIPT_NAME}">
			<input type="hidden" name="surveyId" value="{$data.surveyId}" readonly="readonly" />
			<ul cas-js="getSurvey" cas:var="{$data.surveyId}" cas:url="modules/survey/index.php"></ul>
		</form>

		<p>
			Finding your location: <span id="status">checking...</span>
		</p>
		
	</article>

	<script>
		function success(position) {
			var s = document.querySelector('#status');

			if (s.className == 'success') {
				// not sure why we're hitting this twice in FF, I think it's to do with a cached result coming back    
				return;
			}

			s.innerHTML = "found you!";
			s.className = 'success';

			var mapcanvas = document.createElement('div');
			mapcanvas.id = 'mapcanvas';
			mapcanvas.style.height = '400px';
			mapcanvas.style.width = '560px';

			document.querySelector('article').appendChild(mapcanvas);

			var latlng = new google.maps.LatLng(position.coords.latitude,
					position.coords.longitude);
			var myOptions = {
				zoom : 15,
				center : latlng,
				mapTypeControl : false,
				navigationControlOptions : {
					style : google.maps.NavigationControlStyle.SMALL
				},
				mapTypeId : google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(document
					.getElementById("mapcanvas"), myOptions);

			var marker = new google.maps.Marker({
				position : latlng,
				map : map,
				title : "You are here!"
			});
		}

		function error(msg) {
			var s = document.querySelector('#status');
			s.innerHTML = typeof msg == 'string' ? msg : "failed";
			s.className = 'fail';

			// console.log(arguments);
		}

		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(success, error);
		} else {
			error('not supported');
		}
	</script>

