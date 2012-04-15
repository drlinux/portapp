<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<base href="{$project.url}" />
<link rel="icon" type="image/png" href="img/favicon.png" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title>portapp | by cas.ict</title>
<meta name="description" content="" />
<meta name="keywords" content="" />

<!-- jQuery -->
<script type="text/javascript" src="assets/jquery/js/jquery-1.7.1.min.js"></script>
<!-- jQuery UI -->
<script type="text/javascript" src="assets/jquery/js/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="assets/jquery/css/black-tie/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>	

<!-- jQuery Plugins -->
<!-- cookie -->
<script type="text/javascript" src="assets/plugins/cookie/jquery.cookie.js"></script>
<!-- fancybox -->
<link rel="stylesheet" href="assets/plugins/fancybox/jquery.fancybox-1.3.4.css" />
<script type="text/javascript" src="assets/plugins/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<!-- maskedinput -->
<script type="text/javascript" src="assets/plugins/maskedinput/jquery.maskedinput-1.3.js"></script>
<!-- fg.menu -->
<link type="text/css" media="screen" rel="stylesheet" href="assets/plugins/fg/fg.menu.css" />
<script type="text/javascript" src="assets/plugins/fg/fg.menu.js"></script>
<!-- qtip -->
<link rel="stylesheet" type="text/css" href="assets/plugins/qtip/jquery.qtip.min.css" />
<script type="text/javascript" src="assets/plugins/qtip/jquery.qtip.min.js"></script>
<!-- finezoom -->
<script type="text/javascript" src="assets/plugins/finezoom/finezoom.js"></script>
<script type="text/javascript" src="assets/plugins/finezoom/jquery.mousewheel.js"></script>
<!-- jqzoom -->
<link rel="stylesheet" href="assets/plugins/jqzoom/jquery.jqzoom.css" />
<script type="text/javascript" src="assets/plugins/jqzoom/jquery.jqzoom-core.js"></script>
<!-- form -->
<script type="text/javascript" src="assets/plugins/form/jquery.form.js"></script>
<!-- validate -->
<script type="text/javascript" src="assets/plugins/validate/jquery.validate.min.js"></script>
<!-- i18n -->
<script type='text/javascript' src='assets/plugins/i18n/jquery.i18n.properties-min-1.0.9.js'></script>
<!-- ui.spinner -->
<link rel="stylesheet" href="assets/plugins/ui.spinner/ui.spinner.css" />
<script type="text/javascript" src="assets/plugins/ui.spinner/ui.spinner.min.js"></script>
<!-- jcrop -->
<script src="assets/plugins/jcrop/js/jquery.Jcrop.js" type="text/javascript"></script>
<link rel="stylesheet" href="assets/plugins/jcrop/css/jquery.Jcrop.css" type="text/css" />

<!-- jeditable -->
<script type="text/javascript" src="assets/plugins/jeditable/jquery.jeditable.mini.js"></script>
<!-- timepicker -->
<script type="text/javascript" src="assets/plugins/timepicker/jquery-ui-timepicker-addon.js"></script>
<!-- ckeditor -->
<script type="text/javascript" src="assets/plugins/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="assets/plugins/ckeditor/adapters/jquery.js"></script>
<!-- dynatree -->
<link rel="stylesheet" href="assets/plugins/dynatree/skin/ui.dynatree.css" />
<script type="text/javascript" src="assets/plugins/dynatree/jquery.dynatree.min.js"></script>
<!-- multiselect -->
<link rel="stylesheet" href="assets/plugins/multiselect/jquery.multiselect.css" />
<script type="text/javascript" src="assets/plugins/multiselect/jquery.multiselect.min.js"></script>
<link rel="stylesheet" href="assets/plugins/multiselect/jquery.multiselect.filter.css" />
<script type="text/javascript" src="assets/plugins/multiselect/jquery.multiselect.filter.js"></script>


<!-- 3rd party scripts -->
		<script type="text/javascript" src="assets/extension/analytics.js"></script>
		<script type="text/javascript" src="assets/extension/jtable.js"></script>
		<script type="text/javascript" src="assets/extension/common.js"></script>
		<!--<script type="text/javascript" src="assets/extension/classes/GMAPHelper.js"></script>-->


<!-- STYLES -->
<link rel="stylesheet" href="{$smarty.const._THEMES_DIR_}admin/{$_THEME_ADMIN_NAME}/css/style.css" />


</head>
<body>

<div id="wrapper">
	<div id="header">
		<span style="font-size: 2em; font-weight: normal;"><a href="modules/admin/" style="text-decoration: none; color: inherit; ">portapp</a></span><sub></sub>
		<span class="buttonset fr">
			<button cas-js="getBreadcrumbsIso639" cas:uri="{$project.encodedUri}" cas:var="{$project.language}"></button>
			<button cas-js="getLoginoutButton"></button>
		</span>
	</div>
	<div id="content">
		{include file="$tpl_content.tpl" msg=$msg data=$data}
	</div>
	<div id="footer">
		&copy; <a href="http://www.casict.com" target="_blank">cas.ict</a>. {#LABEL_AllRightsReserved#}.
	</div>
</div>

<script type="text/javascript">
$(function() {
	
	$("#wrapper").css({
		'margin': '0 auto',
		'padding': '0px',
		'width': '1000px'
	});
	
	$("#header").css({
		'margin-bottom': '5px',
		'border-bottom': '1px solid #e4e4de'
	});
	
	$("#content").css({
		'overflow-y': 'auto',
		'overflow-x': 'hidden',
		'min-height': '700px',
		'width': '100%'
	});
	
	$("#footer").css({
		'margin-top': '5px',
		'border-top': '1px solid #e4e4de',
		'text-align': 'right'
	});
	
	$("table.display").css({
		'width': '1000px' //must be the same width with wrapper
	});
	
});
</script>

</body>
</html>