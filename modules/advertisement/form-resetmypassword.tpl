Reset my password
<form autocomplete="off" id="formResetmypassword">
<ul class="ulform">
	<li>
		<label>Your e-mail address</label>
		<input type="text" name="userEmail" />
	</li>
	<li>
		<button type="submit" onclick="Advertisement.callResetmypassword(); return false;">Reset My Password</button>
	</li>
</ul>
</form>

<script type="text/javascript">
$(function() {
	$("ul.ulform").ulform();
});
</script>
