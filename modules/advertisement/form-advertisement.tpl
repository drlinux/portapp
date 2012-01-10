Advertise
<form id="formAdvertise" method="post" enctype="multipart/form-data">
<ul class="ulform">
	<li>
		<label>Details for your ad</label>
		<textarea name="advertisementContent" cols="70" rows="7"></textarea>
	</li>
	<li>
		<label>Choose a category</label>
		<cas js="getAdvertisementgroups"></cas>
	</li>
	<li>
		<input type="checkbox" onclick="$('#liPicture').slideToggle();" />Has a picture?
	</li>
	<li class="dn" id="liPicture">
		<label>Upload a picture for your ad</label>
		<label><i>&lt; 2MB - 4:3 - jpg/png</i></label>
		<input type="hidden" name="MAX_FILE_SIZE" value="2048000" readonly="readonly" />
		<input type="file" name="pictureFile" />
	</li>
	<li>
		<button type="submit" onclick="Advertisement.saveAdvertisement(); return false;">Save Ad</button>
	</li>
</ul>
</form>

<script type="text/javascript">
jQuery.getScript("modules/advertisement/module.js", function(data, textStatus) {
	Advertisement = new Advertisement();
	Advertisement.getAdvertisementgroups();
});

$(function() {
	$("ul.ulform").ulform();
});
</script>
