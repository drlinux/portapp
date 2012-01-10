Log in
<form autocomplete="off" id="formLogin">
<ul class="ulform">
	<li>
		<label>E-mail address</label>
		<input type="text" id="username" name="username" title="" />
	</li>
	<li>
		<label>{#LABEL_Password#}</label>
		<input type="password" id="password" name="password" required="required" />
	</li>
	<li class="dn">
		<label>uri</label>
		<input type="text" name="uri" value="{$smarty.server.REQUEST_URI}" readonly="readonly" />
	</li>
	<li>
		<button type="submit" onclick="Advertisement.callLogin(); return false;">Log in</button>
	</li>
	<li>
		<label><a href="javascript:void(0);" onclick="Advertisement.callContent('form-resetmypassword');">Reset my password</a></label>
	</li>
</ul>
</form>

<script type="text/javascript">
$(function() {
	$("ul.ulform").ulform();
});
</script>
