<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html><head>
<title>FancySelector Demo</title>

<!-- jQuery -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>

<!-- optional -->
<script src="js/jquery.mousewheel.js" type="text/javascript"></script>
<script src="js/jquery.easing.1.2.js" type="text/javascript"></script>

<!-- Fancy Selector -->
<link rel="stylesheet" href="css/fancyselector-fancy.css" type="text/css" >
<script src="js/jquery.fancyselector.js" type="text/javascript"></script>

<!-- demo -->
<link rel="stylesheet" href="css/demo.css" type="text/css" >
<style type="text/css">
/* "#wrapper" is set up to fill the entire browser window */
#wrapper {
	display: block;
	position: absolute;
	height: auto;
	bottom: 0;
	top: 0;
	left: 0;
	right: 0;
	margin: 10px;
}
</style>
<script type="text/javascript">
$(document).ready(function(){

	// Report Events to info window
	// ****************************
	var d = $('#display'),
	// make it hideable with animation
	display = function(t){
		$('#links').animate({ left: (t) ? 0 : -180 }, 500);
	};
	// hide/show display window
	$('#links').click(function(){
		if ($(this).position().left === 0) { return; }
		display(true);
	}).find('.hide').click(function(){
		display(false);
		return false;
	});

	// Bind to FancySelector events (include ".fancyselector" namespace)
	// ****************************
	$('#main').bind('initialized.fancyselector changed.fancyselector submitted.fancyselector', function(e, fsel){
		var txt = fsel.getSelections('text').join(', '); // change 'text' to 'index' to display the zero-based index
		// update display
		d.append('<li><span>' + e.type +  '</span>: ' + txt + '</li>');
		// remove old event info
		if (d.find('li').length > 3) { d.find('li:first').remove(); }
	});

	// initialize the plugin
	// ****************************
	$('#main').fancySelector({
		start : 'One Love' // Starting option to highlight & center vertically - can be a jQuery object of the option, zero-based index, text or value
	});

});
</script>

</head>
<body>

<div id="links">
	<a href="#" class="hide">x</a>
	<h2>FancySelector</h2>
	<a href="http://github.com/Mottie/FancySelector/downloads">Download</a><br>
	<a href="https://github.com/Mottie/FancySelector/wiki">Documentation</a><br>
	<a href="index2.html">Demo #2</a>
	<hr>
	Events:
	<ul id="display"></ul>

</div>

<div id="wrapper">
<select id="main" multiple>
	<option>One Life</option>
	<option>One Emotion</option>
	<option>One Feeling</option>
	<option>One Regret</option>
	<option>One Desire</option>
	<option>One Love</option>
	<option>One Heart</option>
	<option>One Moment</option>
	<option>One Past</option>
	<option>One Future</option>
	<option>One Time</option>
	<option>One Day</option>
	<option>One Hour</option>
	<option>One Minute</option>
	<option>One Second</option>
	<option>One Sound</option>
	<option>One Note</option>
	<option>One Song</option>
	<option>One Symphony</option>
	<option>One Sight</option>
	<option>One Shape</option>
	<option>One Smile</option>
	<option>One Smell</option>
	<option>One Touch</option>
	<option>One Taste</option>
	<option>One Chance</option>
	<option>One Problem</option>
	<option>One Answer</option>
	<option>One Death</option>
	<option>One World</option>
</select>
</div>

</body></html>