<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<base href="{$project.url}" />
<title>FancySelector Demo</title>

<!-- jQuery -->
<script type="text/javascript" src="assets/jquery/js/jquery-1.7.1.min.js"></script>

<!-- optional -->
<script src="assets/plugins/fancyselector/js/jquery.mousewheel.js" type="text/javascript"></script>
<script src="assets/plugins/fancyselector/js/jquery.easing.1.2.js" type="text/javascript"></script>

<!-- Fancy Selector -->
<link rel="stylesheet" href="assets/plugins/fancyselector/css/fancyselector-fancy.css" type="text/css" >
<script src="assets/plugins/fancyselector/js/jquery.fancyselector.js" type="text/javascript"></script>

<!-- demo -->
<link rel="stylesheet" href="assets/plugins/fancyselector/css/demo.css" type="text/css" >
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
		max: 1,
		start: 'One Love' // Starting option to highlight & center vertically - can be a jQuery object of the option, zero-based index, text or value
	});

});
</script>

</head>
<body>

{include file="$tpl_header.tpl"}
{include file="$tpl_leftbar.tpl"}
{include file="$tpl_content.tpl" msg=$msg data=$data}
{include file="$tpl_rightbar.tpl"}
{include file="$tpl_footer.tpl" foo='bar'}

</body>
</html>