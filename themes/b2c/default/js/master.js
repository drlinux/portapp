$(MasterStart);

function MasterStart()
{
	$(".jqzoom").jqzoom();
	$(".tabs").tabs();
	Cufon.replace("h1, h2, h3, h4, h5, h6",{hover:true});
	
	var searchInput = $("#searchFormOuter input[type=text]");
	var searchDefaultText = searchInput.val();
	
	searchInput.focus(function(){
		if($(this).val() == searchDefaultText)
			$(this).val("");
	});
	
	searchInput.blur(function(){
		if($(this).val() == "")
			$(this).val(searchDefaultText);
	});
}

function fixMenuCufon()
{
	Cufon.replace("#menuOuter a",{hover:true});
	var currentLink = window.location.href;
	
	
	
	if(currentLink.match(/productgroupId=[0-9]+/))
	{
		var match = currentLink.match(/productgroupId=[0-9]+/).toString();
		var matchedArray = match.split('=');
		var productgroupId = matchedArray[1];
		$("#menuOuter a[href*='productgroupId=" + productgroupId + "']").addClass("selected");
	}
	else if(currentLink.match(/b2c\/index.php/) || currentLink.match(/b2c\/index.php/))
	{
		
	}
}