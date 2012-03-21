// INIT ----------------------------------------------------------
$(function(){
	CommonItems = new CommonItems();
});
//----------------------------------------------------------------


function CommonItems()
{
	// En tepede olmalı
	jQuery.i18n.properties({
		name		: 'Messages', 
		path		: 'configs/', 
		mode		: 'both',
		language	: 'tr',
		callback	: function() {
			// We specified mode: 'both' so translated values will be
			// available as JS vars/functions and as a map

			// Accessing a simple value through the map
			//jQuery.i18n.prop('msg_hello');
			// Accessing a value with placeholders through the map
			//jQuery.i18n.prop('msg_complex', 'John');

			// Accessing a simple value through a JS variable
			//alert(msg_hello +' '+ msg_world);
			// Accessing a value with placeholders through a JS function
			//alert(msg_complex('John'));
		}
	});
	
	$.validator.setDefaults({
		errorPlacement: function(error, element) {
			error.insertAfter(element.parent()).delay(3200).fadeOut(300).addClass("c-ff0000");
		},
		highlight: function(input) {
			$(input).addClass("ui-state-highlight");
		},
		unhighlight: function(input) {
			$(input).removeClass("ui-state-highlight");
		}
	});

	
	$("ul.ulform").ulform();
	
	$("input, textarea, select, table").addClass("ui-widget-content");//ui-corner-all
	$("table caption").addClass("ui-widget-header");//ui-corner-all

	$(".datepicker").datepicker({
		dateFormat: 'yy-mm-dd'
	});
	/*
	$(".datepicker").datepicker({
		yearRange: 'c-50:c',
		maxDate: new Date()
	});
	*/
	
	// START: ADMIN PAGE
	var datetimepicker = $('input.datetimepicker');
	if (datetimepicker.length) {
		$(datetimepicker).datetimepicker({
			dateFormat: 'yy-mm-dd',
			showSecond: true,
			timeFormat: 'hh:mm:ss'
		});
	}
	
	var timepicker = $('input.timepicker');
	if (timepicker.length) {
		$(timepicker).timepicker({
			showSecond: true,
			timeFormat: 'hh:mm:ss'
		});
	}
	
	var $wysiwyg = $('textarea.wysiwyg');
	var wysiwyg_editor = "ckeditor";//ckeditor, elrte
	var language = "tr";
	if ($wysiwyg.length) {
		if (wysiwyg_editor == "ckeditor") {
			$wysiwyg.ckeditor({
				//toolbar				: 'Basic',
				toolbarStartupExpanded	: false,
				uiColor					: 'transparent',
				language				: language,
				skin					: 'kama'
			});
		}
		else if (wysiwyg_editor == "elrte") {
			var jsHost = (("https:" == document.location.protocol) ? "https://" : "http://");
			jQuery.getCss(jsHost + document.location.hostname + "/assets/plugins/elrte/css/elrte.min.css");
			jQuery.getCss(jsHost + document.location.hostname + "/assets/plugins/elfinder/css/elfinder.css");
			if (language == "tr") {
				jQuery.getScript(jsHost + document.location.hostname + "/assets/plugins/elrte/js/i18n/elrte.tr.js");
				jQuery.getScript(jsHost + document.location.hostname + "/assets/plugins/elfinder/js/i18n/elfinder.tr.js");
			}
			jQuery.getScript(jsHost + document.location.hostname + "/assets/plugins/elfinder/js/elfinder.min.js");
			jQuery.getScript(jsHost + document.location.hostname + "/assets/plugins/elrte/js/elrte.min.js", function() {
				try {
					var opts = {
							cssClass : 'el-rte',
							lang     : language,
							height   : 450,
							toolbar  : 'complete',
							//cssfiles : ['css/elrte-inner.css'],
							fmOpen   : function(callback) {
								$('<div id="myelfinder"></div>').elfinder({
									url : jsHost + document.location.hostname + "/assets/plugins/elfinder/connectors/php/connector.php",
									lang : language	,
									dialog : { width : 900, modal : true, title : 'Files' }, // open in dialog
									closeOnEditorCallback : true, // close elFinder after file select
									editorCallback : callback // pass callback to editor
								});
							}
						};
					$wysiwyg.elrte(opts);
				} catch (err) {
					console.log(err);
				}
			});
		}
	}
	
	var editable = $('.editable');
	if (editable.length) {
		$(editable).editable('http://www.example.com/save.php');
	}
	// END: ADMIN PAGE

	$(".accordion").accordion();

	$(".buttonset").buttonset();
	
	$("button, a.button").button();
	
	$("div.tabs").tabs({
		cookie: {
			expires: 1
		}
	});
	
	var qtip = $("input[title], select[title], textarea[title]");
	if (qtip.length) {
		$(qtip).qtip({
			position: {
				at: "right center",
				my: "left center"
			}
		});
	}
	
	var jqzoom = $('a.jqzoom');
	if (jqzoom.length && global_settings.use_jqzoom) {
		$(jqzoom).jqzoom({
			preloadText: jQuery.i18n.prop('ALERT_Loading'),
			zoomType: "reverse",
			position: "right"
		}).find("img")/*.css({
			float: "left",
			marginRight: "20px",
			background: "#000"
		})*/;
	}
	else {
		$('a.jqzoom').click(function() { return false; });
	}
	
	$("input.phone").each(function() {
		$(this).mask("999-999-9999");
	});
	
	$("input.date").each(function() {
		//$(this).mask("99.99.9999");
		$(this).mask("99/99/9999");
		//$(this).mask("9999-99-99");
	});
	
	$("input.ccno").each(function() {
		$(this).mask("9999-9999-9999-9999");
	});

	$("input.cvc").each(function() {
		$(this).mask("999");
	});
	
	$("input.expDate").each(function() {
		$(this).mask("99-99");
	});
	
	$(".multiselect").each(function() {
		$(this).multiselect({
			/*
			click: function (event, ui) {
				if (ui.checked) {
					$('<li/>', {
						'id': 'p_multiselect_'+ui.value,
						'html': ui.text
					}).appendTo('#selectedProducts');
				}
				else {
					$('li#p_multiselect_'+ui.value).remove();
				}
			},
			checkAll: function (event, ui) {
				var array_of_checked_values = $(this).multiselect("getChecked").map(function () {
					return this.value;
				}).get();
				$.each(array_of_checked_values, function (key, val) {
					alert(key+':'+val);
				});
			},
			*/
			checkAllText: jQuery.i18n.prop('LABEL_All'),
			uncheckAllText: "Hiçbiri",
			noneSelectedText: "Seçiniz",
			selectedText: '# seçili',
			selectedList: 3 // 0-based index
		}).multiselectfilter({
			filter: function(event, matches) {
				var first_match = $( matches[0] );
			}
		});
	});

	$("a.fancybox").fancybox({
		transitionIn		: 'elastic',
		transitionOut		: 'elastic',
		speedIn				: 600, 
		speedOut			: 200,
		hideOnOverlayClick	: true,
		modals				: true,
		hideOnContentClick	: true,
		enableEscapeButton	: true,
		showCloseButton		: true
	});

	var casLoaderShow = function ()
	{
		if(($("#blackoutBg").length > 0) && ($("#loaderOuter").length > 0)) // eğer loader gösteriliyorsa
			return;
		
		var loaderImagePath = "assets/css/images/page_loader.gif";
		var loaderHtml = '<div id="blackoutBg"></div>';
		loaderHtml += '<div id="loaderOuter">';
		loaderHtml += '<img src="' + loaderImagePath + '" />';
		loaderHtml += '</div>';
		
		$("body").append(loaderHtml);
		
		var blackoutObject = $("#blackoutBg");
		var loaderOuter = $("#loaderOuter");
		var loaderImage = $("#loaderOuter img");	
		
		$(window).resize(function(){
			var wWidth = $(window).width();
			var wHeight = $(window).height();
			var loaderWidth = $("#loaderOuter").outerWidth();
			var loaderHeight = $("#loaderOuter").outerHeight();
			var loaderLeft = (wWidth - loaderWidth) / 2;
			var loaderTop = (wHeight - loaderHeight) / 2;
			
			loaderOuter.css({
				"display":"block",
				"left":loaderLeft,
				"top":loaderTop
			});
		});
		
		$(window).resize();
	};
	
	var casLoaderHide = function ()
	{
		$("#blackoutBg").remove();
		$("#loaderOuter").remove();
		$(window).unbind("resize");
	};
	
	var casDialog = function (options)
	{
		casLoaderHide();
		
		var defaultOptions = {
			title: jQuery.i18n.prop('LABEL_HeaderDialog'),
			content: '',
			onClosed: function() {}
		};
		
		if (typeof(options) === 'object') {
			options = $.extend(defaultOptions, options);
		}
		else if (typeof(options) === 'string') {
			options = $.extend(defaultOptions, { content: options });
		}
		
		var d = $("<div/>")
		.html(options.content)
		.dialog({
			title: options.title,
			resizable: false,
			height: 140,
			modal: true,
			buttons: {
				Ok: function() {
					$(this).dialog("close");
				}
			},
			close: options.onClosed
		});
		
		setTimeout(function() { $(d).dialog("close"); }, 3000);
		
		// TODO: Remove title bar
		//$(".ui-dialog-titlebar").hide();
	};
	
	var fancyboxPopup = function (t)
	{
		$("<div/>")
			.load($(t).attr("href"))
			.dialog({
				title: $(t).attr("title"),
				resizable: false,
				//height: $(t).attr("height"),
				width: '75%',
				position: 'top',
				modal: true,
				buttons: {
					Ok: function() {
						$(this).dialog("close");
					}
				}
			});
		return false;
	};
	
	var fancyboxThumbnail = function ()
	{
		var $target = $('a.fancyboxThumbnail');
		if ($target.length) {
			$.each($target, function(){
				var index = $(this).index();
				if(index % 4 == 0)
					$(this).css("margin-right","0");
				$(this).find("img").css({
					"width": 50
				});
			}).fancybox({
				onComplete: function() {
					$("#fancybox-img").finezoom({
						zoomIn: "assets/plugins/finezoom/zoom_in.png",
						zoomOut: "assets/plugins/finezoom/zoom_out.png",
						reset: "assets/plugins/finezoom/zoom_reset.png",
						toolbar: true,
						toolbarPos: [ "left", "top" ]
					});
				}
			});
		}
	};

	var getLocation = function ()
	{
		return (window.location.pathname.split("/",3).concat("").join("/"));
		/*
		var location = window.location;
		var path = location.pathname;
		if (document.all) {
			path = path.replace(/\\/g,"/");
		}
		path = path.substr(0, path.lastIndexOf("/")+1);
		return location.protocol + '//' + location.hostname + path;
		*/
	};
	
	var Obj = new Object();
	Obj.fancyboxPopup = fancyboxPopup;
	Obj.fancyboxThumbnail = fancyboxThumbnail;
	Obj.casDialog = casDialog;
	Obj.casLoaderShow = casLoaderShow;
	Obj.casLoaderHide = casLoaderHide;
	Obj.getLocation = getLocation;
	return Obj;
}