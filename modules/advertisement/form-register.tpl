Register
<form autocomplete="off" id="formRegister">
<ul class="ulform">
	<li>
		<label>Your e-mail address</label>
		<input type="text" name="userEmail" />
	</li>
	<li>
		<label>Your name</label>
		<input type="text" name="userFirstname" />
	</li>
	<li class="dn2">
		<label>latitude</label>
		<input type="text" name="latitude" readonly="readonly" />
	</li>
	<li class="dn2">
		<label>longitude</label>
		<input type="text" name="longitude" readonly="readonly" />
	</li>
	<li>
		<button type="submit" onclick="Advertisement.callRegister(); return false;">Register</button>
	</li>
	<li id="liMap"></li>
</ul>
</form>

<script type="text/javascript">
$(function() {
	//initiate_geolocation();
	$("ul.ulform").ulform();
});
</script>
