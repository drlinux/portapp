Search ad
<form>
<ul class="ulform">
	<li>
		<label>search ad</label>
		<input type="text" name="q" style="font-size: 2em;" autofocus="autofocus" />
	</li>
	<li>
		<button type="submit" onclick="Advertisement.callSearch(this); return false;">Search Ad</button>
	</li>
</ul>
</form>
<div id="divSearchResults"></div>

<script type="text/javascript">
$(function() {
	$("ul.ulform").ulform();
});
</script>
