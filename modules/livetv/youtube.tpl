<form method="get" action="{$SCRIPT_NAME}">
	<input type="text" name="q" />
	<button type="submit" onclick="searchVideoYoutube(this.form); return false;">{#BUTTON_Search#}</button>
</form>
<div id="fromYoutube" style="float: left;"></div>
<iframe id="iframePlayer" style="float: right;" width="560" height="315" frameborder="0" allowfullscreen></iframe>

<script>
function listEvents(root)
{
	var feed = root.feed;
	var entries = feed.entry || [];
	var html = ['<ul>'];
	
	for (var i = 0; i < entries.length; ++i) {
		var entry = entries[i];
		var title = entry.title.$t;
		
		var link= entry.link;
		var href= link[0].href;
		
		var videoId = $.getUrlVarFromLink(href, 'v');

		if (i == 0) $("#iframePlayer").attr("src", "https://www.youtube.com/embed/" + videoId);
		html.push('<li><a href="javascript:void(0);" onclick="play(\''+videoId+'\');">', title, '</a></li>');
	}
	
	html.push('</ul>');
	document.getElementById("fromYoutube").innerHTML = html.join("");
}

function play(videoId)
{
	$("#iframePlayer").attr("src", "https://www.youtube.com/embed/" + videoId);
}

$(function() {
	$("#fromYoutube a").click(function() {
		
	});
});
</script>

<script src="https://gdata.youtube.com/feeds/api/videos?q=be%C5%9Fikta%C5%9F&alt=json&callback=listEvents"></script>
