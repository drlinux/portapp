<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<base href="{$PROJECT_URL}" />
<link rel="icon" type="image/png" href="img/favicon.png" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title>{$smarty.const.PROMOSHOP_TITLE}</title>
<meta name="description" content="" />
<meta name="keywords" content="" />

<!-- jQuery -->
<script type="text/javascript" src="assets/jquery/js/jquery-1.7.1.min.js"></script>
<!-- jQuery UI -->
<script type="text/javascript" src="assets/jquery/js/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="assets/jquery/css/smoothness/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>	

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
<script type='text/javascript' src='assets/plugins/jqzoom/jquery.jqzoom-core.js'></script>
<!-- sprintf -->
<script type='text/javascript' src='assets/plugins/sprintf/jquery.sprintf.js'></script>

<!-- 3rd party scripts -->
		<script type="text/javascript" src="assets/extension/analytics.js"></script>
		<script type="text/javascript" src="assets/extension/jtable.js"></script>
		<script type="text/javascript" src="assets/extension/common.js"></script>
		<script type="text/javascript" src="assets/extension/GMAPHelper.js"></script>


<!-- STYLES -->
<link href="modules/promoshop/css/style.css" rel="stylesheet" type="text/css" media="screen" />


</head>
<body>

<div id="container">
	<div id="navigation">
		<span class="buttonset fr">
			<button cas-js="getBreadcrumbsIso639" cas:url="modules/promoshop/index.php" cas:uri="{$PROJECT_ENCODEDURI}"></button>
			<button cas-js="getLoginoutButton" cas:url="modules/promoshop/index.php"></button>
		</span>
	</div>
	<div id="header">
		<h1>promoshop</h1>
		<h2>promoshopping</h2>
	</div>
	<div id="wrapper">
		<!--
		<div id="content">
			<h1>Welcome to Lemonaid</h1>
			<p>After a long hiatus from designing open source templates, I'm back! Lemonaid is a design that uses some brighter and more contemporary colours. The yellow tries to make the design look more &quot;alive&quot;. I like the way it's turned out, and enjoy the colour scheme. This design, like all of my designs, are pretty minimalistic and simple, and it's just the way I like it (Hehe). A little about me: I am a student living in Canada, and do web design as a hobby on my spare time. If you want me to design a site for you, feel free to drop me a line at <strong>web @ smallpark . org</strong>, or visit my site at <strong><a href="http://smallpark.org">smallpark.org</a></strong> (Under construction). Also, if you're looking for web hosting, you can give <a href="http://dreamhost.com">Dreamhost</a> a shot, if you use the promocode <strong>BIGDREAM</strong>, you can save 50 bucks on any plan. (And then I earn some affiliate bucks :). Now for some more Lorem Ipsum:</p>
			<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Pellentesque tortor risus, iaculis nec, ultricies in, tempus vitae, quam. Proin semper magna a dui. Maecenas ut sem a leo molestie pretium. Nulla velit. Proin faucibus libero vitae velit. Integer mi mauris, consectetuer at, facilisis tempus, feugiat ut, nunc. Ut ut eros. Nam suscipit. Aliquam tristique arcu. <a href="#">Mauris quam.</a> Mauris vel pede id massa hendrerit convallis. Sed a orci. Morbi consequat semper metus. In hac habitasse platea dictumst. </p>
			<h1>Lorem Ipsum Dolor Sit</h1>
			<p>Ut magna libero, posuere ac, pharetra et, nonummy in, augue. Nullam quis ipsum. In congue, tellus ac pulvinar tempor, est enim euismod neque, at rhoncus arcu arcu eu justo. Vestibulum nec nibh. In mollis, magna ut feugiat fringilla, nunc metus tempus purus, id adipiscing ante lacus nec orci. Pellentesque vel enim.</p>
		</div>
		<div id="sidebar">
			<h1>Another Sidebar</h1>
			<p>Vestibulum nec urna ac elit hendrerit congue. Mauris et odio non odio congue viverra. Pellentesque at mi in lacus faucibus fermentum. Integer quis odio in lorem ornare laoreet. Aenean condimentum. Maecenas vitae lacus a est ultrices nonummy. Etiam sed sapien a mi feugiat egestas. Nam sed arcu sed arcu pretium interdum. Ut quis tellus. <a href="#">Class aptent taciti sociosqu ad litora torquent per conubia </a>nostra, per inceptos hymenaeos. Etiam quis nibh. Quisque sed risus. Integer lobortis eros eu dui. Aliquam et ante. Sed nulla diam, sagittis at, nonummy sed, lobortis et, elit. Morbi rhoncus viverra tortor. Sed posuere turpis vel orci. Vivamus euismod leo vitae lectus cursus sagittis. </p>
			<div id="sidebarleft">
				<h1>Another Sidebar Left</h1>
				<p>Vestibulum nec urna ac elit hendrerit congue. Mauris et odio non odio congue viverra. Pellentesque at mi in lacus faucibus fermentum. Integer quis odio in lorem ornare laoreet. Aenean condimentum. Maecenas vitae lacus a est ultrices nonummy. Etiam sed sapien a mi feugiat egestas. Nam sed arcu sed arcu pretium interdum. Ut quis tellus. <a href="#">Class aptent taciti sociosqu ad litora torquent per conubia </a>nostra, per inceptos hymenaeos. Etiam quis nibh. Quisque sed risus. Integer lobortis eros eu dui. Aliquam et ante. Sed nulla diam, sagittis at, nonummy sed, lobortis et, elit. Morbi rhoncus viverra tortor. Sed posuere turpis vel orci. Vivamus euismod leo vitae lectus cursus sagittis. </p>
			</div>
			<div id="sidebarright">
				<h1>Another Sidebar Right</h1>
				<p>Vestibulum nec urna ac elit hendrerit congue. Mauris et odio non odio congue viverra. Pellentesque at mi in lacus faucibus fermentum. Integer quis odio in lorem ornare laoreet. Aenean condimentum. Maecenas vitae lacus a est ultrices nonummy. Etiam sed sapien a mi feugiat egestas. Nam sed arcu sed arcu pretium interdum. Ut quis tellus. <a href="#">Class aptent taciti sociosqu ad litora torquent per conubia </a>nostra, per inceptos hymenaeos. Etiam quis nibh. Quisque sed risus. Integer lobortis eros eu dui. Aliquam et ante. Sed nulla diam, sagittis at, nonummy sed, lobortis et, elit. Morbi rhoncus viverra tortor. Sed posuere turpis vel orci. Vivamus euismod leo vitae lectus cursus sagittis. </p>
			</div>
		</div>
		<div id="extra">
			<h1>Extra Stuff </h1>
			<p> Praesent erat tortor, eleifend ac, mattis vel, condimentum non, ipsum. Nam pretium ante a erat. Nam justo. In ultricies volutpat diam. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed libero arcu, egestas pharetra, sagittis vitae, fringilla vitae, odio. Sed volutpat libero. Vivamus malesuada pretium dolor. Donec quis eros vel pede pretium ornare. Vivamus ac eros. Phasellus sodales lectus ut dolor luctus sollicitudin. Fusce volutpat dui ac leo. Morbi urna pede, consectetuer ornare, cursus cursus, porta vitae, mi. </p>
		</div>
		-->
		{include file="$tpl_header.tpl"}
		{include file="$tpl_leftbar.tpl"}
		{include file="$tpl_content.tpl" msg=$msg data=$data}
		{include file="$tpl_rightbar.tpl"}
		{include file="$tpl_footer.tpl" foo='bar'}
	</div>
	<div id="footer">
		<span id="design-by"><a href="http://www.casict.com" target="_blank">.</a></span> 
		Copyright &copy; 2011 {$smarty.const.PROMOSHOP_TITLE}. {#LABEL_AllRightsReserved#}.
	</div>
</div>

</body>
</html>