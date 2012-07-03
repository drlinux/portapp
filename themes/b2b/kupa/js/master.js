$(MasterStart);

global_settings.use_jqzoom = false;
var campaignsTimerList;
var oneSecondInMS = 1000;
var oneMinuteInMS = 60000;
var oneHourInMS = 3600000;
var onDayInMS = 86400000;


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
	
	
	campaignsTimerList = $(".campaignTimer");
	campaignTimer();
	setInterval(campaignTimer, 1000);
}

/*
function campaignTimer()
{
	campaignsTimerList.each(function(){
		var endTime = $(this).find(".endTime");
		var cSecond = $(this).find(".cSecond");
		var cMinute = $(this).find(".cMinute");
		var cHour = $(this).find(".cHour");
		var cDay = $(this).find(".cDay");
		
		var dtDate = endTime.html().replace(/-/g,'/');
		var differenceInMS = Math.abs(new Date() - new Date(dtDate));
		
		var differenceInDY = Math.floor(differenceInMS / 1000 * 60 * 60 * 24);
		differenceInMS -= differenceInMS * ( 1000 * 60 * 60 * 24);
		
		var differenceInSC = Math.floor(differenceInMS / 1000);
		var differenceInMN = Math.floor(differenceInSC / 60);
		var differenceInHR = Math.floor(differenceInMN / 60);
		var differenceInDY = Math.floor(differenceInHR / 24);
		
		cSecond.html((differenceInSC % 60));
		cMinute.html(Math.floor(differenceInMN % 60));
		cHour.html(Math.floor(differenceInHR % 24));
		cDay.html(Math.floor(differenceInDY));
	});
}
*/

function campaignTimer()
{
	campaignsTimerList.each(function(){
		var endTime = $(this).find(".endTime");
		var cSecond = $(this).find(".cSecond");
		var cMinute = $(this).find(".cMinute");
		var cHour = $(this).find(".cHour");
		var cDay = $(this).find(".cDay");
		
		var dtDate = endTime.html().replace(/-/g,'/');
		
		var tempMS = new Date() - new Date(dtDate);
		if(tempMS > 0) return;
		
		var differenceInMS = Math.abs(tempMS);
		var differenceInSC = Math.floor(differenceInMS / 1000);
		var differenceInMN = Math.floor(differenceInSC / 60);
		var differenceInHR = Math.floor(differenceInMN / 60);
		var differenceInDY = Math.floor(differenceInHR / 24);
		
		var secondCount = parseInt(differenceInSC % 60, "10");
		var minuteCount = parseInt(differenceInMN % 60, "10");
		var hourCount	= parseInt(differenceInHR % 24, "10");
		var dayCount	= parseInt(differenceInDY, "10");
		
		
		
		if((secondCount <= 0) && (minuteCount <= 0) && (hourCount <= 0) && (dayCount <= 0))
		{
			setTimeout(function(){
				window.location.reload();
			}, 5000);
			return;
		}
		cSecond.find(".value").html(secondCount);
		
			
		if((minuteCount <= 0) && (hourCount <= 0) && (dayCount <= 0))
			cMinute.css("display","none");
		else
			cMinute.find(".value").html(minuteCount);
		
		if((hourCount <= 0) && (dayCount <= 0))
			cHour.css("display","none");
		else
			cHour.find(".value").html(hourCount);
		
		if(dayCount > 0)
			cDay.find(".value").html(dayCount);
		else
			cDay.css("display","none");
		
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