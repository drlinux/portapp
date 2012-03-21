// INIT ----------------------------------------------------------
$(function(){
	User = new User();
	User.getLoginoutButton();
	User.getLoginoutFormAndMenu();
});
//----------------------------------------------------------------

function User()
{
	var checkAuthenticated = function ()
	{
		var op = false;
		$.ajax({
			url: CommonItems.getLocation() + 'index.php',
			dataType: 'json',
			async: false,
			data: "action=checkAuthenticated",
			success: function(response) {
				op = response.authenticated;
			}
		});
		return op;
	};
	
	var getLoginoutFormAndMenu = function ()
	{
		var $target = $('[cas-form=getLoginoutFormAndMenu]');
		if ($target.length) {
			$.each($target, function(index, element) {
				if ( User.checkAuthenticated() ) {
					$.getJSON(CommonItems.getLocation() + 'index.php', {
						'action': 'breadcrumbsMenu'
					}, function(response) {
						$(element).html(tree4breadcrumbsMenu(response));
					});
				}
			});
		}
	};
	
	var getLoginoutButton = function ()
	{
		var $target = $('[cas-js=getLoginoutButton]');
		if ($target.length) {
			if ( User.checkAuthenticated() ) {
				$.getJSON(CommonItems.getLocation() + 'index.php', {
					'action': 'breadcrumbsMenu'
				}, function(response) {
					//$('#treeMenu').html(tree4breadcrumbsMenu(response));
					$target
						.button({
							label: jQuery.i18n.prop('LABEL_Menu'),
							text: true,
							icons: {
								primary: "ui-icon-unlocked",
								secondary: "ui-icon-triangle-1-s"
							}
						})
						.menu({
							crumbDefaultText: jQuery.i18n.prop('ALERT_PleaseMakeAChoice'),
							backLinkText: jQuery.i18n.prop('BUTTON_Back'),
							topLinkText: jQuery.i18n.prop('LABEL_All'),
							content: tree4breadcrumbsMenu(response),
							flyOut: false,
							positionOpts: {
								posX: 'left', 
								posY: 'bottom',
								offsetX: 0,
								offsetY: 0,
								directionH: 'left',
								directionV: 'down', 
								detectH: true, // do horizontal collision detection  
								detectV: true, // do vertical collision detection
								linkToFront: false
							},
							backLink: false
						});
				});
			}
			else {
				var type = $target.attr("cas:type");
				if(type === undefined) {
					$target.remove();
				}
				else if(type == "page") {
					$target
					.button({
						label: 'Giriş yap',
						text: true
					})
					.bind("click", function() {
						window.location.replace(CommonItems.getLocation() + 'index.php?action=login');
						return false;
					});
				}
				else if(type == "popup") {
					$target
						.button({
							label: 'Giriş yap',
							text: true
						})
						.bind("click", function() {
							// TODO: login form popup olarak yapılacak
						})
						.css({
							cursor: 'pointer'
						});
					
					// TODO: login form submit ajaxSubmit ile yapılacak
					/*
					$("#formUserlogin").bind("submit", function() {
						var formData = $(this).serializeArray();
						formData.push({ name: "action", value: "loginUser" });
				
						if ($(this).find("#username").val().length < 1 || $(this).find("#passopen").val().length < 1) {
							$("#errorUserlogin").show();
							return false;
						}
				
						$.ajax({
							type	: "POST",
							cache	: false,
							url		: CommonItems.getLocation() + 'index.php',
							data	: formData,
							dataType: 'json',
							success: function(response) {
								console.log(response);
								if (response.authenticated == true) {
									window.location.replace(response.uri);
								}
								else {
									//CommonItems.casDialog(jQuery.i18n.prop('ALERT_AuthenticationFailed'));
								}
							}
						});
				
						return false;
					});
					*/
				}
			}
		}
	};
	
	var tree4breadcrumbsMenu = function (json)
	{
		var op = '<ul>';
		$.each(json, function(key, val) {
			if(val.children!=null) {
				op += '<li><a href="#">' + val.text + '</a>' + tree4breadcrumbsMenu(val.children) + '</li>';
			}
			else {
				op += '<li><a href="' + val.href + '">' + val.text + '</a></li>';
			}
		});
		op += '</ul>';
		return op;
	};

	var saveUser = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'saveUser' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
						CommonItems.casLoaderShow();
					},
					success: function(response) {
						if (response.success == true) {
							CommonItems.casDialog(response.msg);
						}
						else {
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				userFirstname: {
					required: true
				},
				userLastname: {
					required: true
				},
				userEmail: {
					email: true,
					required: true
				},
				userAgreement: {
					required: true
				}
			},
			messages: {
				userFirstname: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userLastname: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userEmail: {
					email: jQuery.i18n.prop('ALERT_PleaseEnterAValidEmailAddress'),
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userAgreement: {
					required: jQuery.i18n.prop('ALERT_PleaseAcceptUserAgreement')
				}
			}
		});
		return false;
	};
	
	var updateUser = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				/*
				$form.ajaxSubmit(function(response) {
					if(response == "succeed")
						alert("Send Succeed!"); 
					else
						alert("Error Happened");
				});
				*/
				$form.ajaxSubmit({
					data: { action: 'updateUser' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						if (response.success == true) {
							CommonItems.casDialog({
								content: jQuery.i18n.prop('ALERT_Completed'),
								onClosed: function () {
									window.location.reload();
								}
							});
						}
						else {
							// TODO: input title dan alıp alert verilebilir mi?
							//CommonItems.casDialog(response.msg + ' - ' + response.field + ' - ' + $("[name="+response.field+"]").attr("title"));
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				userTcknNew: {
					minlength: 11,
					required: true
				},
				userEmailNew: {
					email: true,
					required: true
				},
				userNameNew: {
					required: true
				},
				userGender: {
					required: true
				},
				userFirstname: {
					required: true
				},
				userLastname: {
					required: true
				},
				userBirthdate: {
					date: true,
					required: true
				},
				userPhone: {
					required: true
				}
			},
			messages: {
				userTcknNew: {
					minlength: "11 dijit uzunluğunda olmalı",
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userEmailNew: {
					email: jQuery.i18n.prop('ALERT_PleaseEnterAValidEmailAddress'),
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userNameNew: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userGender: {
					required: jQuery.i18n.prop('ALERT_PleaseMakeAChoice')
				},
				userFirstname: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userLastname: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userBirthdate: {
					date: jQuery.i18n.prop('ALERT_PleaseCheckOutDateFormat'),
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				userPhone: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};
	
	var loginUser = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'loginUser' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						if (response.success == true) {
							CommonItems.casDialog({
								content: response.msg,
								onClosed: function () {
									if (response.uri != null && response.uri != "") {
										window.location.replace(response.uri);
									}
									else {
										window.location.reload();
									}
								}
							});
						}
						else {
							CommonItems.casDialog({
								content: response.msg
							});
						}
					}
				});
			},
			rules: {
				username: {
					email: true,
					required: true
				},
				password: {
					required: true
				}
			},
			messages: {
				username: {
					email: jQuery.i18n.prop('ALERT_PleaseEnterAValidEmailAddress'),
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				password: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};
	
	var resetUserPass = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'resetUserPass' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
						CommonItems.casLoaderShow();
					},
					success: function(response) {
						if (response.success == true) {
							CommonItems.casDialog(response.msg);
						}
						else {
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				userEmail: {
					email: true,
					required: true
				}
			},
			messages: {
				userEmail: {
					email: jQuery.i18n.prop('ALERT_PleaseEnterAValidEmailAddress'),
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};

	var sendRecommendation = function (form)
	{
		if ( User.checkAuthenticated() ) {
			$form = $(form);
			$form.validate({
				submitHandler: function(f) {
					$form.ajaxSubmit({
						data: { action: 'sendRecommendation' },
						dataType: 'json',
						beforeSubmit: function(a,f,o) {
							//console.log(a);
							CommonItems.casLoaderShow();
						},
						success: function(response) {
							//console.log(response);
							if (response.success == true) {
								CommonItems.casDialog(response.msg);
							}
							else {
								CommonItems.casDialog(response.msg);
							}
						}
					});
				},
				rules: {
					userEmail: {
						email: true,
						required: true
					}
				},
				messages: {
					userEmail: {
						email: jQuery.i18n.prop('ALERT_PleaseEnterAValidEmailAddress'),
						required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
					}
				}
			});
		}
		else {
			CommonItems.casDialog("Giriş yapmalısınız");
		}
		return false;
	};

	var Obj = new Object();
	Obj.checkAuthenticated = checkAuthenticated;
	Obj.getLoginoutFormAndMenu = getLoginoutFormAndMenu;
	Obj.getLoginoutButton = getLoginoutButton;
	Obj.saveUser = saveUser;
	Obj.updateUser = updateUser;
	Obj.loginUser = loginUser;
	Obj.resetUserPass = resetUserPass;
	Obj.sendRecommendation = sendRecommendation;
	return Obj;
}