<!-- flowplayer-->
<script type="text/javascript" src="assets/flowplayer/flowplayer-3.2.6.min.js"></script>


<!-- http://www.streamtransport.com/ -->

<article style="float: left;">
	<a href="javascript:void(0);" onclick="$('[name=fA]').slideToggle();">Encode/Decode Tool</a>
	<form name="fA" style="display: none;">
	<textarea id="f1" cols=25 rows=5 wrap="off"></textarea>
	<br />
	<input type="button" width="50%" value="Encode" onclick="document.fA.c1.value=escapeTxt(document.fA.f1.value)"> &nbsp; &nbsp;
	<input type="button" value="Decode" onclick="document.fA.f1.value=unescapeTxt(document.fA.c1.value)">
	<br />
	<textarea id="c1" cols=25 rows=5></textarea>
	</form>
	<div id="divChannels"></div>
</article>

<article style="float: right;">
	<div id="video" style="float: right;"><a href="#" id="player"></a></div>
</article>

<script type="text/javascript">
$(function() {
	
	$.ajax({
		url: '{$SCRIPT_NAME}',
		type: 'GET',
		data: ({ action: 'jsonLivetvs' }),
		dataType: 'json',
		success: function(response) {
			$("#divChannels").html('');
			var items = [];
			$.each(response.aaData, function(key, val) {
				items.push('<li><a href="#" playerWidth="' + val.livetvWidth + 'px" playerHeight="' + val.livetvHeight + 'px" clipUrl="' + val.livetvClipUrl + '" netConnectionUrl="' + val.livetvNetConnectionUrl + '" playerSrc="' + val.livetvPlayerSrc + '" playerKey="' + val.livetvPlayerKey + '" influxisUrl="' + val.livetvInfluxisUrl + '">' + val.livetvTitle + '</a></li>');
			});
			$('<ul/>', {
				'id': 'channels',
				'class': '',
				'css': { 'float': 'left', 'margin-right': '20px' },
				html: items.join('')
			}).appendTo("#divChannels");

			$("ul#channels li a").click(function() {
				
				var clipUrl = $(this).attr("clipUrl");
				var netConnectionUrl = $(this).attr("netConnectionUrl");
				var playerWidth = $(this).attr("playerWidth");
				var playerHeight = $(this).attr("playerHeight");
				
				var playerSrc = $(this).attr("playerSrc");
				var playerKey = $(this).attr("playerKey");
				var influxisUrl = $(this).attr("influxisUrl");
				
				$("#video a#player").remove();
				
				$('<a/>', {
					'id': 'player',
					'href': '#',
					'css': { 'display': 'block', 'width': playerWidth, 'height': playerHeight },
					'html': ''
				}).appendTo('#video');
				
				$f("player", {
					src: playerSrc,
					wmode: "opaque"//transparent,opaque
					}, {
					
					key: playerKey,
					
					// clip uses influxis provider
					clip: { 
						autoPlay: true,
						live: true,
						url: clipUrl,
						provider: 'influxis'
					},
					
					// enable pseudostreaming support 
					plugins: { 
						controls:  {
							all: false,
							play: false,
							time: false,
							scrubber: false,
							fullscreen: true,
							volume: true,
							mute: true
						},
						
						// here is our rtpm plugin configuration
						influxis: { 
							url: influxisUrl, 
							netConnectionUrl: netConnectionUrl
						} 
					}
					
				});
				
				//$(this).css({ 'font-weight': 'bold' });
				
				return false;
				
			}).each(function() {
				//$(this).css({ 'font-weight': 'normal' });
			});
			
			$("ul#channels li a:first").trigger("click");
		}
	});
	
	
});
</script>

<script language="javascript">
var encN=1;

function decodeTxt(s){
	var s1=unescape(s.substr(0,s.length-1));
	var t='';
	for(i=0; i<s1.length; i++) t+=String.fromCharCode(s1.charCodeAt(i)-s.substr(s.length-1,1));
	return unescape(t);
}

function encodeTxt(s){
	s=escape(s);
	var ta=new Array();
	for(i=0; i<s.length; i++) ta[i]=s.charCodeAt(i)+encN;
		return ""+escape(eval("String.fromCharCode("+ta+")"))+encN;
}

function escapeTxt(os){
	var ns='';
	var t;
	var chr='';
	var cc='';
	var tn='';
	for(i=0; i<256; i++){
		tn=i.toString(16);
		if(tn.length<2) tn="0"+tn;
		cc+=tn;
		chr+=unescape('%'+tn);
	}
	cc=cc.toUpperCase();
	os.replace(String.fromCharCode(13)+'',"%13");
	for(q=0; q<os.length; q++){
		t=os.substr(q,1);
		for(i=0;i<chr.length;i++){
			if(t==chr.substr(i,1)){
				t=t.replace(chr.substr(i,1),"%"+cc.substr(i*2,2));
				i=chr.length;
			}
		}
		ns+=t;
	}
	return ns;
}

function unescapeTxt(s){
	return unescape(s);
}

function wF(s){
	document.write(decodeTxt(s));
}
</script>