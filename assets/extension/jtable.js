$(startJtable);

function startJtable() {
	setupJtable();
	setupJtable2();
	ultable();
}

$.fn.reverseText = function(params) {
	// merge default and user parameters
	params = $.extend( {minlength: 0, maxlength: 99999}, params);
	// traverse all nodes
	this.each(function() {
		// express a single node as a jQuery object
		var $t = $(this);
		// find text
		var origText = $t.text(), newText = '';
		// text length within defined limits?
		if (origText.length >= params.minlength &&  origText.length <= params.maxlength) {
			// reverse text
			for (var i = origText.length-1; i >= 0; i--) newText += origText.substr(i, 1);
			$t.text(newText);
		}
	});
	// allow jQuery chaining
	return this;
};

$.fn.juitable = function(params) {
	// merge default and user parameters
	params = $.extend( {minlength: 0, maxlength: 99999}, params);
	// traverse all nodes
	this.each(function() {
		// express a single node as a jQuery object
		var $t = $(this);
		// change css
		$t
			//.addClass("ui-widget-content")
			.css({
				"font-size": "0.8em",
				"border-spacing": "0",
				"width": "100%"
			});
		$t.find("thead").addClass("ui-widget-header");
		$t.find("tbody").addClass("ui-widget-content");
		$t.find("tfoot").addClass("ui-widget-header");
	});
	// allow jQuery chaining
	return this;
};

$.fn.ulmenuh = function(params) {
	// merge default and user parameters
	params = $.extend( {minlength: 0, maxlength: 99999}, params);
	// traverse all nodes
	this.each(function() {
		// express a single node as a jQuery object
		var $t = $(this);
		// change css
		$t
			//.addClass("ui-widget-content")
			.css({
				"list-style-type": "none",
				"margin": "0",
				"padding": "0"
			})
			.find("li").css({
				"float": "left",
				"margin-bottom": "20px",
				"padding-left": "10px"
			})
			.find("a").css({
				"font-size": "0.8em",
				"font-weight": "bold",
				"text-transform": "uppercase",
				"display": "block",
				"clear": "both",
				"color": "#ccc",
				"text-decoration": "none"
			})
			.find("a:hover").css({
				"color": "#000",
				"text-decoration": "overline"
			});
	});
	// allow jQuery chaining
	return this;
};


$.fn.ulform = function(params) {
	// merge default and user parameters
	params = $.extend( {minlength: 0, maxlength: 99999}, params);
	// traverse all nodes
	this.each(function() {
		// express a single node as a jQuery object
		var $t = $(this);
		// change css
		$t
			//.addClass("ui-widget-content")
			.css({
				"list-style-type": "none",
				"margin": "0 auto",
				"padding": "10px"
			})
			.find("li").css({
				"margin-bottom": "10px",
				"clear": "both"
			})
			.find("label").css({
				"font-weight": "bold",
				//"text-transform": "uppercase",
				"display": "block",
				//"margin-bottom": "3px",
				"clear": "both"
			});
	});
	// allow jQuery chaining
	return this;
};


$.fn.juiul = function(params) {
	// merge default and user parameters
	params = $.extend( {minlength: 0, maxlength: 99999}, params);
	// traverse all nodes
	this.each(function() {
		// express a single node as a jQuery object
		var $t = $(this);
		// change css
		$t
			//.addClass("ui-widget-content")
			.css({
				"list-style-type": "none",
				"border": "0px solid red",
				"border-spacing": "0",
				"margin": "0 auto",
				"width": "90%"
			})
			.find("span").css({
				"width": "150px",
				"margin-right": "10px"
			});
	});
	// allow jQuery chaining
	return this;
};

function ultable()
{
	$("ul.ultable").each(function() {
		$(this)
		//.addClass("ui-widget-content")
		.css({
			"list-style-type": "none",
			"padding": "5px"
		})
		.find("li").css({
			"padding": "5px",
			"clear": "both"
		})
		.find("label").css({
			"font-weight": "bold",
			"float": "left",
			"width": 150
		});
	});
}

function setupJtable() {
	$(".jtable").css({
		"width": "90%", 
		"margin-left": "auto", 
		"margin-right": "auto", 
		"border-spacing": 5
	});
	$(".jtable").addClass("ui-widget-content ui-corner-all");
	
	$(".jtable th").each(function() {
		//$(this).addClass("ui-widget-content ui-corner-all");
		$(this).css({
			/*"vertical-align" : "top", */
			"text-align" : "right", 
			"width": "40%"
		});
	});

	$(".jtable td").each(function() {
		//$(this).addClass("ui-widget-content");
	});

	$(".jtable tr").hover(function() {
		//$(this).children("td").addClass("ui-state-hover");
		//$(this).children("td").css({ "font-weight" : "normal" });
	}, function() {
		//$(this).children("td").removeClass("ui-state-hover");
	});

	$(".jtable tr").click(function() {
		//$(this).children("td").toggleClass("ui-state-highlight");
	});
	
	$(".jtable input:text, .jtable input:password, .jtable textarea").each(function() {
		$(this).css({
			"width": "250px", 
			"border": "0", 
			"border-bottom": "1px solid #cccccc", 
			"color": "#cccccc", 
			"background-color": "transparent"
		});
		//$(this).val($(this).attr("title"));
		$(this).focus(function() {
			$(this).css({ "color": "#000000" });
			if ($(this).val() == $(this).attr("title")) {
				$(this).val("");
			}
		});
		$(this).blur(function() {
			if ($(this).val() == "") {
				//$(this).val($(this).attr("title"));
				$(this).css({ "color": "#cccccc" });
			}
			else {
				$(this).css({ "color": "#000000" });
			}
		});
	});

}

function setupJtable2() {
	$(".jtable2").css({
		"width": "90%", 
		"margin-left": "auto", 
		"margin-right": "auto", 
		"border-spacing": 5
	});
	$(".jtable2").addClass("ui-widget-content ui-corner-all");
	
	$(".jtable2 th").each(function() {
		$(this).css({
			"text-align" : "right", 
			"width": "40%"
		});
	});

	$(".jtable2 input:text, .jtable2 input:password, .jtable2 textarea").each(function() {
		//$(this).css({ "width": "350px", "font-size": "1.1em" });
	});
	
}