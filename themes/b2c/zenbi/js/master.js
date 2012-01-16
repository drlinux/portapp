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
	
	$(document).bind("onMenuLoaded",function(){
		Cufon.replace("#menuOuter a",{hover:true});
	});
}