$(MasterStart);

function MasterStart()
{
	$("[cas-break]").each(function(){
		var limitCount = $(this).attr("cas-break");
		
		$(this).find("li").each(function (index, element) {
			var floatSide = $(this).css("float");
			index++;
			if((index % limitCount) === 0)
			{
				$(this).addClass("last");
			}
			else if((index != 1) &&  ((index % limitCount) == 1))
			{
				$(this).css({"clear":floatSide});
			}
		});
	});

	
	$(".oldCost").each(function(){
		if($(this).text().trim() == "TL")
			$(this).html("");
	});
}

function fixMenuCufon()
{
	var currentLink = window.location.href;
	
	if(currentLink.match(/productgroupId=[0-9]+/))
	{
		var match = currentLink.match(/productgroupId=[0-9]+/).toString();
		var matchedArray = match.split('=');
		var productgroupId = matchedArray[1];
		$("#menuOuter a[href*='productgroupId=" + productgroupId + "']").addClass("selected");
	}
	
	Cufon.replace("#menuOuter a",{hover:true});
}