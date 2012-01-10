<div id="tabs">
	<ul>
		<li><a href="#tabs-1">My Info</a></li>
		<li><a href="#tabs-2">My Ads</a></li>
		<li><a href="#tabs-3">My Messages</a></li>
	</ul>
	<div id="tabs-1">
		<form id="formMyinfo" method="post" enctype="multipart/form-data">
		<ul>
			<li>
				<label>Firstname</label>
				<input type="text" name="userFirstname" />
			</li>
			<li>
				<label>E-mail address</label>
				<input type="text" name="userEmail" />
			</li>
			<li>
				<label>New Password</label>
				<input type="text" name="userPass" />
			</li>
			<li style="display: none;">
				<label>Latitude</label>
				<input type="text" name="latitude" readonly="readonly" />
			</li>
			<li style="display: none;">
				<label>Longitude</label>
				<input type="text" name="longitude" readonly="readonly" />
			</li>
			<li>
				<div id="map_canvas" style="width: 400px; height: 300px;"></div>
			</li>
			<li>
				<button type="submit" onclick="Advertisement.saveMyinfo(); return false;">Save</button>
			</li>
			<li>
			</li>
		</ul>
		</form>
	</div>
	<div id="tabs-2">
		<ul cas-js="getMyads"></ul>
	</div>
	<div id="tabs-3">
		<ul cas-js="getMymessages"></ul>
	</div>
</div>

<script type="text/javascript">
jQuery.getScript("modules/advertisement/module.js", function(data, textStatus) {
	Advertisement = new Advertisement();
	Advertisement.getMyinfo();
	Advertisement.getMyads();
	Advertisement.getMymessages();
});


$(function() {
	
	$("#tabs").tabs().removeClass("ui-widget-content ui-corner-all");
	$("#tabs ul").removeClass("ui-widget-header");
	$("#tabs ul li")
		.removeClass()
		.mouseover(function() {
			$(this).removeClass();
		})
		.mousemove(function() {
			$(this).removeClass();
		});
	/*
	$("#tabs ul li:first a").css({
		//'font-weight': 'bold',
		//'text-decoration': 'overline'
	});
	$("#tabs ul li a").click(function() {
		$(this).closest("ul li a").each(function() {
			$(this).css({
				//'font-weight': 'normal',
				'text-decoration': 'none'
			});
		});
		$(this).css({
			//'font-weight': 'bold',
			'text-decoration': 'overline'
		});
	});
	*/
	
});
</script>
