$(ProductStart);
/*
var resolutions = [
                   {"res_width":40, "res_height":50, "crop_left":0, "crop_top":0, "crop_width":133, "crop_height":100},
                   {"res_width":122, "res_height":150, "crop_left":0, "crop_top":0, "crop_width":133, "crop_height":100},
                   {"res_width":244, "res_height":300, "crop_left":0, "crop_top":0, "crop_width":133, "crop_height":100}
                   ];

var existingFiles = [
                     {"file_url":"source.jpg", "res_width":1024, "res_height":768, "crop_left":0, "crop_top":0, "crop_width":133, "crop_height":100},
                     {"file_url":"source.jpg", "res_width":900, "res_height":600, "crop_left":0, "crop_top":0, "crop_width":133, "crop_height":100},
                     {"file_url":"source.jpg", "res_width":1100, "res_height":600, "crop_left":0, "crop_top":0, "crop_width":133, "crop_height":100}
                     ];*/

function ProductStart()
{
	$(".btnCropImage").each(function(){
		var thumbsListObject = $(this).parent().find(".thumbsListOuter ul");
		var base_image = $(this).attr("base_image");
		listProductThumbs($(this).attr("base_image"), thumbsListObject);
		$(this).click(function(){
			openCropWindow(base_image, null, resolutions, function(){				//alert("ef");
				listProductThumbs(base_image, thumbsListObject);
			});
		});
	});	
	//$(".thumbsListOuter .del").live("click",deleteThumb);
	/*
	 * METHODS
	 * ---------------------------------------------------------------------------------------------------------
	 * openCropWindow(sourceImage, existingFiles, resolutions): resim croplayıcıyı açar.
	 * --sourceImage: croplamada kullanılacak büyük resim 		(gerekli)
	 * --existingFiles:  yukarıdaki "existingFiles"  dizisi formatında önceden croplanmış resimlerin listesi.  		(gerekli değil)
	 * --resolutions: yukarıdaki "resolutions" dizisi formatında öntanımlı çözünürlüklerin listesi 		(gerekli değil)
	 * 
	 * closeCropWindow(): resim croplayıcıyı kapatır.
	 * 
	 */
}
function listProductThumbs(basefilename, thumbsListObject)
{
	$.ajax({
		type:"post",
		url : "modules/admin/modules/ecommerce/image_process/crop.php",
		data : "action=listproductthumbs&file=" + basefilename,
		dataType:"json",
		cache:false,
		success:function(response){			var thumbs = response.thumbs;			thumbsListObject.html("");						for(var i=0; i<thumbs.length; i++)			{				var date = new Date();				var tempHtml = '<li>';				tempHtml += '<img src="/' + thumbs[i].file + "?cache=" + date.getTime() + '" />';				tempHtml += '<span class="res">' + thumbs[i].label + '</span>';				tempHtml += '';				tempHtml += '</li>';								thumbsListObject.append(tempHtml);			}
		},
		complete:function(){
		}
	});
}