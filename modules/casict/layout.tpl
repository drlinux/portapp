<!DOCTYPE html>
<html lang="en">
<head>
<meta charset=utf-8>
<meta name="viewport" content="width=620">
<base href="{$PROJECT_URL}" />

<link rel="icon" type="image/png" href="img/favicon.png" />

<title>www.casict.com - C.A.S. Information and Communication Technologies</title>
<meta name="description" content="C.A.S. Information and Communication Technologies" />
<meta name="keywords" content="Information and Communication Technologies, Web 2.0, Technology Consulting, internet tv, online survey, e-commerce, ecommerce, CMS, Portapp" />

<meta name="google-site-verification" content="KWRgtCT90jcUM96U2j3BgM484fQ5rDGIcQdu5RpLCxU" />
<meta name="y_key" content="0e1425c594d57238" />

<!-- jQuery -->
<script type="text/javascript" src="assets/jquery/js/jquery-1.7.1.min.js"></script>
<!-- jQuery UI -->
<script type="text/javascript" src="assets/jquery/js/jquery-ui-1.8.16.custom.min.js"></script>
<link type="text/css" href="assets/jquery/css/black-tie/jquery-ui-1.8.16.custom.css" rel="stylesheet"/>	

<!-- jquery plugins -->
<!-- cookie -->
<script type="text/javascript" src="assets/plugins/cookie/jquery.cookie.js"></script>
<!-- fancybox -->
<link rel="stylesheet" href="assets/plugins/fancybox/jquery.fancybox-1.3.4.css" />
<script type="text/javascript" src="assets/plugins/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<!-- form -->
<script type="text/javascript" src="assets/plugins/form/jquery.form.js"></script>
<!-- validate -->
<script type="text/javascript" src="assets/plugins/validate/jquery.validate.min.js"></script>
<!-- i18n -->
<script type='text/javascript' src='assets/plugins/i18n/jquery.i18n.properties-min-1.0.9.js'></script>


<!-- 3rd party scripts -->
		<script type="text/javascript" src="assets/extension/analytics.js"></script>
		<script type="text/javascript" src="assets/extension/jtable.js"></script>
		<script type="text/javascript" src="assets/extension/common.js"></script>
		<script type="text/javascript" src="assets/extension/GMAPHelper.js"></script>


<style type="text/css">
body { margin: 0px; }
header, footer { clear: both; background-color: #e4e4de; }
header ul { float:right; margin: 0px; list-style-type: none; text-align: right; }
header ul li { display: inline; padding-right: 5px; }
header ul li a:hover { font-weight: bold; }
</style>

</head>
<body>

<section id="wrapper">
{include file="$tpl_header.tpl"}
{include file="$tpl_leftbar.tpl"}
{include file="$tpl_content.tpl" msg=$msg data=$data}
{include file="$tpl_rightbar.tpl"}
{include file="$tpl_footer.tpl" foo='bar'}
</section>

</body>
</html>