<!DOCTYPE html> 
<html> 
<head>
<base href="{$PROJECT_URL}" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>Multi-page template</title> 

<!-- jQuery -->
<script type="text/javascript" src="assets/jquery/js/jquery-1.7.1.min.js"></script>
<!-- jQuery Mobile -->
<script type="text/javascript" src="assets/jquery.mobile/jquery.mobile-1.0rc2.min.js"></script>
<link type="text/css" href="assets/jquery.mobile/jquery.mobile-1.0rc2.min.css" rel="stylesheet"/>	

</head> 
	
<body> 

{include file="$tpl_content.tpl" msg=$msg data=$data}

</body>
</html>
