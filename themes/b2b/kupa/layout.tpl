<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<base href="{$project.url}" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="icon" type="image/png" href="img/favicon.png" />
		
		<title>{$_COMPANY_NAME}</title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		
		<meta name="google-site-verification" content="" />
		<meta name="y_key" content="" />
		
		<!-- jQuery-->
		<script type="text/javascript" src="assets/jquery/js/jquery-1.7.1.min.js"></script>
		<!-- jQuery UI -->
		<script type="text/javascript" src="assets/jquery/js/jquery-ui-1.8.16.custom.min.js"></script>
		<link type="text/css" href="assets/jquery/css/black-tie/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>
		
		
		<!-- jQuery plugins -->
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
		<script type="text/javascript" src="assets/plugins/qtip/jquery.qtip.min.js"></script>
		<link rel="stylesheet" type="text/css" href="assets/plugins/qtip/jquery.qtip.min.css" />
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
		<!-- jcarousel -->
		<link rel="stylesheet" href="assets/plugins/jcarousel/skins/black/skin.css" />
		<script type="text/javascript" src="assets/plugins/jcarousel/lib/jquery.jcarousel.min.js"></script>
		<!-- sprintf -->
		<script type='text/javascript' src='assets/plugins/sprintf/jquery.sprintf.js'></script>
		<!-- i18n -->
		<script type='text/javascript' src='assets/plugins/i18n/jquery.i18n.properties-min-1.0.9.js'></script>
		<!-- ui.spinner -->
		<link rel="stylesheet" href="assets/plugins/ui.spinner/ui.spinner.css" />
		<script type="text/javascript" src="assets/plugins/ui.spinner/ui.spinner.min.js"></script>
		
		
		<!-- 3rd party scripts -->
		<script type="text/javascript" src="assets/extension/analytics.js"></script>
		<script type="text/javascript" src="assets/extension/jtable.js"></script>
		<script type="text/javascript" src="assets/extension/common.js"></script>
		<script type="text/javascript" src="assets/extension/GMAPHelper.js"></script>
		<!-- cufon -->
		<script type="text/javascript" src="assets/cufon/cufon-yui.js"></script>
		<script type="text/javascript" src="assets/cufon/Trebuchet_MS_400-Trebuchet.font.js"></script>
		
		<!-- STYLES -->
		<link rel="stylesheet" href="{$smarty.const._THEMES_DIR_}b2b/{$_THEME_B2B_NAME}/css/style.css" />
		<!--[if IE 7]>
	        <link rel="stylesheet" type="text/css" href="{$smarty.const._THEMES_DIR_}b2b/{$_THEME_B2B_NAME}/css/ie7.css" />
		<![endif]-->
		<!--[if IE 8]>
	        <link rel="stylesheet" type="text/css" href="{$smarty.const._THEMES_DIR_}b2b/{$_THEME_B2B_NAME}/css/ie8.css" />
		<![endif]-->
		
		<script type="text/javascript" src="{$smarty.const._THEMES_DIR_}b2b/{$_THEME_B2B_NAME}/js/master.js" ></script>
	</head>
	<body>
		
		<div id="repeatBg">
			<div id="headerFullWidthOuter">
				{include file="$tpl_header.tpl"}
			</div>
			<div id="contentsFullWidthOuter">
				<div id="wholeContentsOuter">
					{include file="$tpl_leftbar.tpl" display=$smarty.session.userId}
					<div id="contentsOuter">
					{include file="$tpl_content.tpl" msg=$msg data=$data}
					</div>
					{include file="$tpl_rightbar.tpl" display=$smarty.session.userId}
				</div>
			</div>
		</div>
		<div id="footerFullWidthOuter">
			{include file="$tpl_footer.tpl" foo="bar"}
		</div>
		
	</body>
</html>