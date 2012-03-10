var jCrop;
var predefinedResolutions;
var resizeWidth;
var resizeHeight;
var resizeRatio;
var croppedImagesOuter;
var croppedImagesList;
var btnCrop;
var preDefResolutions;
var waitTimeAfterCropHappened = 2000;
var originalFileUrl = "";
var loaderFileUrl = "modules/admin/modules/ecommerce/image_process/loader.gif";
var currentCrop = { "res_width": 0, "res_height": 0, "crop_left": 0, "crop_top": 0, "crop_width": 100, "crop_height": 100 };

/// PUBLIC //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function openCropWindow(imageUrl, existingFiles, resolutions, onClose) {
    $(document).unbind("onCloseCallback").bind("onCloseCallback", onClose);
    preDefResolutions = resolutions;
    originalFileUrl = imageUrl;
    setupJCrop(imageUrl, function () {
        if ((existingFiles != undefined) && (existingFiles != null) && (existingFiles.length > 0)) {
            var fileCount = existingFiles.length;
            for (var i = 0; i < fileCount; i++) {
                var animate = (i == (fileCount - 1)) ? true : false;
                addCroppedImageToList(existingFiles[i], animate);
            }
        }
    });
}

function closeCropWindow() {
    $(document).trigger("onCloseCallback");
    $("#cropWholeOuter").remove();
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// PRIVATE /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function setupJCrop(imageUrl, onLoadCallback) {
    var cropHtml = '<div id="cropWholeOuter">';
    cropHtml += '<div id="cropBackHide"></div>';
    cropHtml += '<div id="cropperOuter">';
    cropHtml += '<h2>Resim Kırpıcı <span id="closeCropper">x</span></h2>';
    cropHtml += '<div id="originalImageOuter">';
    cropHtml += '<img id="cropImage" src="' + imageUrl + '" />';
    cropHtml += '</div>';
    cropHtml += '<div id="cropperFormOuter">';
    cropHtml += '<h3>Resim Özellikleri</h3>';
    cropHtml += '<label>Öntanımlı Ölçüler</label>';
    cropHtml += '<select id="predefinedResolutions"></select>';
    cropHtml += '<div style="display:none;">';
    cropHtml += '<span style="width:90px; float:left;">';
    cropHtml += '<label>Genişlik</label>';
    cropHtml += '<input class="sizeData" id="resizeWidth" type="text" name="width" />';
    cropHtml += '</span>';
    cropHtml += '<span style="float:left; width:40px; height:20px; position:relative; top:36px; font-size: 20px;">x</span>';
    cropHtml += '<span style="width:90px; float:left;">';
    cropHtml += '<label>Yükseklik</label>';
    cropHtml += '<input class="sizeData" id="resizeHeight" type="text" name="height" />';
    cropHtml += '</span>';
    cropHtml += '<span style="float:left; width:40px; height:20px; position:relative; top:38px; font-size: 20px;"></span>';
    cropHtml += '<span style="float:left; width:40px;">';
    cropHtml += '<label style="float:left;">Oran</label>';
    cropHtml += '<input class="sizeData" id="resizeRatio" style="width:30px;" type="text" name="ratio" value="0" />';
    cropHtml += '</span>';
    cropHtml += '</div>';
    cropHtml += '<input id="btnCrop" type="submit" value="Kırp" />';
    cropHtml += '<img id="cropLoader" src="' + loaderFileUrl + '" />';
    cropHtml += '<h3 style="margin-top:50px;">Türetilmiş Resimler</h3>';
    cropHtml += '<div id="croppedImagesOuter"><ul></ul></div>';
    cropHtml += '</div></div>';
    cropHtml += '</div>';
    if ($("#cropWholeOuter").length <= 0) {
        $("#cropWholeOuter").remove();
    }
    $("body").append(cropHtml);
    $("#cropImage").Jcrop({
        boxWidth: 350,
        boxHeight: 440,
        minSize: [200, 200],
        onSelect: function (image) {
            currentCrop.res_width = resizeWidth.val();
            currentCrop.res_height = resizeHeight.val();
            currentCrop.crop_left = image.x;
            currentCrop.crop_top = image.y;
            currentCrop.crop_width = image.w;
            currentCrop.crop_height = image.h;
        },
        onChange: function (image) {
            if (resizeRatio.val() <= 0) {
                resizeWidth.val(image.w);
                resizeHeight.val(image.h);
            }
        }
    }, function () {
        jCrop = this;
        onJCropLoad(jCrop);
        onLoadCallback();
    });
}

function onJCropLoad(jCrop) {
    fixCropperPosition();
    predefinedResolutions = $("#predefinedResolutions");
    croppedImagesOuter = $("#croppedImagesOuter");
    croppedImagesList = croppedImagesOuter.find("ul");
    resizeWidth = $("#resizeWidth");
    resizeHeight = $("#resizeHeight");
    resizeRatio = $("#resizeRatio");
    btnCrop = $("#btnCrop");
    setResolutions(resolutions);
    bindCropperEvents();
    // Init Selection
    jCrop.setSelect([0, 0, 400, 400]);
}

function bindCropperEvents() {
    btnCrop.unbind("click").bind("click", cropImage);
    $(".sizeData").unbind("click").click(function () { $(this).select(); });
    $(".sizeData").unbind("keyup").bind("keyup", fixValues);
    predefinedResolutions.unbind("change").bind("change", setPredefinedValue).change();
    $("#closeCropper").unbind("click").bind("click", closeCropWindow);
}

function setCroppedImagesList(dataList) {
    var listLength = dataList.length;
    croppedImagesList.html("");
    for (var i = 0; i < listLength; i++) {
        addCroppedImageToList(dataList[i], false);
    }
}

function getCroppedImagesList() {
    var dataList = new Array();
    var listLength = croppedImagesList.find("li").length;
    for (var i = 0; i < listLength; i++) {
        var res_width = $(this).attr("rs_w");
        var res_height = $(this).attr("rs_h");
        var crop_left = $(this).attr("cr_l");
        var crop_top = $(this).attr("cr_t");
        var crop_width = $(this).attr("cr_w");
        var crop_height = $(this).attr("cr_h");
        var file_url = $(this).find("a").attr("href");
        dataList.push({ "file_url": file_url, "res_width": res_width, "res_height": res_height, "crop_left": crop_left, "crop_top": crop_top, "crop_width": crop_width, "crop_height": crop_height });
    }
    return dataList;
}

function setResolutions(resolutions) {
    if (resolutions.length > 0) {
        var predefinedOptions = '';
        for (var i = 0; i < resolutions.length; i++) {
            predefinedOptions += '<option value="' + i + '">' + resolutions[i].res_width + " x " + resolutions[i].res_height + '</option>';
        }
        predefinedResolutions.html(predefinedOptions);
    }
}

function addCroppedImageToList(image, animate) {
    var croppedFileId = "res_" + image.res_width + "_" + image.res_height + "_crop_" + image.crop_left + "_" + image.crop_top + "_" + image.crop_width + "_" + image.crop_height;
    var customAttributes = 'rs_w="' + image.res_width + '" rs_h="' + image.res_height + '" cr_l="' + image.crop_left + '" cr_t="' + image.crop_top + '" cr_w="' + image.crop_width + '" cr_h="' + image.crop_height + '" ';
    var existingFile = $("#" + croppedFileId);
    var newHtml = '<li id="' + croppedFileId + '" class="lastAdded" ' + customAttributes + ' >';
    newHtml += '<a href="' + image.file_url + '" target="_blank"></a>';
    newHtml += '<span>' + image.res_width + ' x ' + image.res_height + '</span></li>';
    var newCroppedObject = $(newHtml);
    if (existingFile.length > 0) {
        existingFile.replaceWith(newCroppedObject);
    }
    else {
        croppedImagesList.append(newCroppedObject);
    }
    var moveTo_top = croppedImagesOuter.find(".lastAdded").position().top;
    croppedImagesOuter.find(".lastAdded").removeClass("lastAdded");
    if (animate)
        croppedImagesOuter.animate({ "scrollTop": moveTo_top }, 500);
}

function fixCropperPosition() {
    var cropper = $("#originalImageOuter .jcrop-holder");
    var top = (440 - parseInt(cropper.height())) / 2;
    cropper.css("top", top);
}

function fixValues() {
    var width = parseInt(resizeWidth.val());
    var height = parseInt(resizeHeight.val());
    var ratio = parseFloat(resizeRatio.val());
    var id = $(this).attr("id");
    if (ratio > 0) {
        if ((id == "resizeWidth") || (id == "resizeRatio")) {
            height = Math.round(width / ratio);
            resizeHeight.val(height);
        }
        else if (id == "resizeHeight") {
            width = Math.round(height * ratio);
            resizeWidth.val(width);
        }
    }
    jCrop.setOptions({ aspectRatio: ratio });
}

function setPredefinedValue() {
    var value = parseInt($(this).val());
    if (value >= 0) {
        var width = preDefResolutions[value].res_width;
        var height = preDefResolutions[value].res_height;
        var ratio = width / height;
        resizeWidth.val(width);
        resizeHeight.val(height);
        resizeRatio.val(ratio);
        var temp = jCrop.tellSelect();
        jCrop.setSelect([temp.x, temp.y, width, height]);
        jCrop.setOptions({ aspectRatio: ratio });
    }
}

////////////////////////////////////////////////////////////////////////
function cropImage() {
    var ratio = currentCrop.res_width / currentCrop.res_height;
    var croppedFileId = "res_" + currentCrop.res_width + "_" + currentCrop.res_height + "_crop_" + currentCrop.crop_left + "_" + currentCrop.crop_top + "_" + currentCrop.crop_width + "_" + currentCrop.crop_height;
    if ($("#" + croppedFileId).length <= 0) {
        $("#cropLoader").css("display", "block");
        $.ajax({
            type: "post",
            url: "modules/admin/modules/ecommerce/image_process/crop.php",
            data: "action=cropImage&file=" + originalFileUrl + "&rs_w=" + currentCrop.res_width + "&rs_h=" + currentCrop.res_height + "&cr_l=" + currentCrop.crop_left + "&cr_t=" + currentCrop.crop_top + "&cr_w=" + currentCrop.crop_width + "&cr_h=" + currentCrop.crop_height,
            dataType: "json",
            success: function (response) {
                if (response.error == false) {
                    currentCrop.file_url = response.file_url;
                    addCroppedImageToList(currentCrop, true);
                    jCrop.setOptions({ aspectRatio: ratio });
                }
                else {
                    alert(JSON.stringify(response));
                }
                $("#closeCropper").click();	   
            },
            complete: function () {
            	$("#cropLoader").css("display", "none"); 
            }
        });
    }
    else {
        jCrop.setOptions({ aspectRatio: ratio });
    }
}