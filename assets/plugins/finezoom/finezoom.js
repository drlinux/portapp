(function($) {
	var Q = {
		init : function(P) {
			return this
					.each(function() {
						var g = {
							'maxZoom' : 4,
							'zoomIn' : 'img/zoomin.png',
							'zoomOut' : 'img/zoomout.png',
							'reset' : 'img/reset.png',
							'toolbar' : 'mouseover',
							'toolbarPos' : [ 'left', 'top' ],
							'opacity' : 1,
							'sensivity' : 10,
							'overrideMousewheel' : true,
							'mousewheel' : true,
							'smoothMove' : 3,
							'zoomStep' : 1.4,
							'resetImage' : true
						};
						if (this.tagName != 'IMG') {
							$.error('Zoomer plugin applies only to img tag.');
							return false
						}
						var h = $(this);
						var j = this;
						var k = j.src;
						if (h.hasClass('ax-zoom'))
							return;
						try {
							eval('var inlineOpts = {' + $(this).attr('title')
									+ '}')
						} catch (err) {
						}
						if (P)
							$.extend(g, P);
						if (typeof (inlineOpts) != 'undefined')
							$.extend(g, inlineOpts);
						h.data('init-status', {
							parent : h.parent(),
							src : k
						}).addClass('ax-zoom').css({
							'position' : 'absolute',
							'top' : 0,
							'left' : 0
						}).data('settings', g);
						var l = ("ontouchstart" in document.documentElement) ? true
								: false;
						var m = 'touchmove.finezoom mousemove.finezoom';
						var n = 'touchend.finezoom mouseup.finezoom';
						var o = 'touchstart.finezoom mousedown.finezoom';
						var p = $(
								'<div class="ax-container" style="position:relative;overflow:hidden;left:0;top:0;" />')
								.appendTo(h.parent()).data('author',
										'http://www.albanx.com/').hover(
										function() {
											if (g.toolbar == 'mouseover' && !l)
												q.show('fast')
										}, function() {
											if (g.toolbar == 'mouseover' && !l)
												q.hide('fast')
										});
						h.data('container', p);
						var q = $('<div class="ax-toolbar" />').css({
							'z-index' : 1000,
							'position' : 'absolute',
							'opacity' : g.opacity
						}).appendTo(p);
						if (g.toolbar === true || g.toolbar == 'mouseover' || l)
							q.show();
						else if (g.toolbar === false)
							q.hide();
						var r;
						h.controlZoom = function(x, a) {
							O = x;
							if (a) {
								if (h.zoomLevel > 1) {
									setTimeout(function() {
										h.controlZoom(x, a)
									}, 30)
								}
							} else {
								r = setTimeout(function() {
									h.controlZoom(x, false)
								}, 30)
							}
						};
						var s = 0;
						var t = 0;
						if (g.zoomIn) {
							var u = false;
							if (typeof (g.zoomIn) == 'string') {
								u = $('<img src="' + g.zoomIn + '" alt="+" />')
										.appendTo(q).css('cursor', 'pointer')
										.load(function() {
											setUpControls()
										})
							} else if (typeof (g.zoomIn) == 'object') {
								u = g.zoomIn
							}
							if (u)
								u.bind(o, function(e) {
									e.stopPropagation();
									G = s / 2;
									H = t / 2;
									h.controlZoom(0.05)
								}).bind('dblclick', function(e) {
									e.stopPropagation()
								}).bind(n + ' mouseout', function() {
									clearTimeout(r)
								})
						}
						if (g.zoomOut) {
							var v = false;
							if (typeof (g.zoomOut) == 'string') {
								v = $('<img src="' + g.zoomOut + '" alt="+" />')
										.appendTo(q).css('cursor', 'pointer')
							} else if (typeof (g.zoomOut) == 'object') {
								v = g.zoomOut
							}
							if (v)
								v.bind(o, function(e) {
									e.stopPropagation();
									G = s / 2;
									H = t / 2;
									h.controlZoom(-0.05)
								}).bind('dblclick', function(e) {
									e.stopPropagation()
								}).bind(n + ' mouseout', function() {
									clearTimeout(r)
								})
						}
						if (g.reset) {
							var w = false;
							if (typeof (g.reset) == 'string') {
								w = $('<img src="' + g.reset + '" alt="*" />')
										.appendTo(q).css('cursor', 'pointer')
							} else if (typeof (g.reset) == 'object') {
								w = g.reset
							}
							if (w)
								w.bind(o, function(e) {
									e.stopPropagation();
									G = s / 2;
									H = t / 2;
									h.controlZoom(-0.1, true)
								}).bind('dblclick', function(e) {
									e.stopPropagation()
								})
						}
						var y = h.attr('src-high');
						if (g.srcHigh)
							y = g.srcHigh;
						var z = 0, MAIN_LEFT = 0;
						var A = new Image();
						A.onload = function() {
							s = j.width;
							t = j.height;
							h.data('dims', {
								'width' : s,
								'height' : t
							});
							p.css({
								'width' : s,
								'height' : t
							}).append(h);
							setUpControls()
						};
						A.src = k;
						function setUpControls() {
							var a = g.toolbarPos[0];
							var b = g.toolbarPos[1];
							if (typeof (a) == 'string')
								a = (a == 'right') ? s - q.width() : 0;
							if (typeof (b) == 'string')
								b = (b == 'bottom') ? t - q.height() : 0;
							q.css({
								'left' : a,
								'top' : b
							})
						}
						var C = 0;
						function medium_coors(e, a) {
							var b = 1;
							var c = $(a).offset().top;
							var d = $(a).offset().left;
							if (l) {
								e = e.originalEvent;
								b = e.touches.length;
								var f = 0, ysum = 0;
								for ( var i = 0; i < b; i++) {
									f += (e.touches[i].pageX - d);
									ysum += (e.touches[i].pageY - c)
								}
								return [ f / b, ysum / b, b ]
							} else {
								return [ e.pageX - d, e.pageY - c, b ]
							}
						}
						var D = false;
						var E = 0;
						var F = 0;
						var G = 0;
						var H = 0;
						var I = 0, LIMIT_Y = 0;
						var J;
						p.bind(o, function(e) {
							e.preventDefault();
							var a = medium_coors(e, this);
							G = a[0];
							H = a[1];
							E = j.offsetLeft - G;
							F = j.offsetTop - H;
							C = a[2];
							if (e.shiftKey)
								h.controlZoom(0.05);
							else if (e.altKey)
								h.controlZoom(-0.05);
							else
								h.drag()
						}).bind(m, function(e) {
							e.preventDefault();
							var a = medium_coors(e, this);
							G = a[0];
							H = a[1];
							C = a[2]
						}).bind(n, function(e) {
							clearTimeout(r);
							clearTimeout(J)
						}).bind('dblclick', function(e) {
							if (!e.altKey && !e.shiftKey)
								O = 0.3
						}).bind('mousewheel', function(e, a) {
							if (g.mousewheel) {
								e.preventDefault();
								if (g.overrideMousewheel)
									e.stopPropagation();
								O = a / g.sensivity
							}
						});
						j.ongesturechange = function(e) {
							e.preventDefault();
							if (C >= 2) {
								var a = (e.scale < 1) ? -1 : 1;
								O = a / g.sensivity
							}
						};
						$(document).bind(n, function(a) {
							clearTimeout(r);
							clearTimeout(J)
						});
						h.data('ENABLE-AXZ', true);
						var K = 0;
						var L = 0;
						h.drag = function() {
							if (h.data('ENABLE-AXZ')) {
								K += (G + E - K) / g.smoothMove;
								L += (H + F - L) / g.smoothMove;
								if (K <= 0 && K >= I)
									h.css({
										'left' : K
									});
								if (L <= 0 && L >= LIMIT_Y)
									h.css({
										'top' : L
									})
							}
							J = setTimeout(function() {
								h.drag()
							}, 30)
						};
						h.zoomLevel = 1;
						var M;
						h.zoomInOut = function() {
							if (h.data('ENABLE-AXZ')) {
								O = O / g.zoomStep;
								if (Math.abs(O) > 0.009) {
									var a = h.width() * (1 + O);
									if (a <= s)
										a = s;
									var b = h.height() * (1 + O);
									if (b <= t)
										b = t;
									var c = a / s;
									if (c >> 0 <= g.maxZoom) {
										h.zoomLevel = c;
										I = -s * (h.zoomLevel - 1);
										LIMIT_Y = -t * (h.zoomLevel - 1);
										var d = O * (j.offsetLeft - G)
												+ j.offsetLeft;
										var e = O * (j.offsetTop - H)
												+ j.offsetTop;
										if (d < I)
											d = I;
										if (d >= 0)
											d = 0;
										if (e <= LIMIT_Y)
											e = LIMIT_Y;
										if (e >= 0)
											e = 0;
										K = d;
										L = e;
										h.css({
											'width' : a,
											'height' : b,
											'top' : e,
											'left' : d
										})
									}
									if (h.zoomLevel > 1.2 && y != ''
											&& y != null && y != h.attr('src')) {
										var f = new Image();
										f.onload = function() {
											j.src = y
										};
										f.src = y
									} else if (h.zoomLevel <= 1.2
											&& g.resetImage
											&& h.attr('src') != k) {
										j.src = k
									}
								}
							}
							setTimeout(function() {
								h.zoomInOut()
							}, 30)
						};
						var O = 0;
						h.zoomInOut();
					})
		},
		enable : function() {
			return this.each(function() {
				var a = $(this);
				a.data('ENABLE-AXZ', true)
			})
		},
		disable : function() {
			return this.each(function() {
				var a = $(this);
				a.data('ENABLE-AXZ', false)
			})
		},
		destroy : function() {
			return this.each(function() {
				var a = $(this);
				a.removeData('settings').removeClass('ax-zoom');
				var b = a.data('init-status');
				var c = a.data('dims');
				a.css({
					'width' : c.width,
					'height' : c.height
				}).appendTo(b.parent).attr('src', b.src).data('container')
						.remove();
				$(document).unbind('.finezoom')
			})
		},
		option : function(c, d) {
			return this.each(function() {
				var a = $(this);
				var b = a.data('settings');
				if (d != null && d != undefined) {
					b[c] = d;
					a.data('settings', b)
				} else
					return b[c]
			})
		}
	};
	$.fn.finezoom = function(a, b) {
		if (Q[a]) {
			return Q[a].apply(this, Array.prototype.slice.call(arguments, 1))
		} else if (typeof a === 'object' || !a) {
			return Q.init.apply(this, arguments)
		} else {
			$.error('Method ' + a + ' does not exist on jQuery.finezoom')
		}
	}
})(jQuery);