// INIT ----------------------------------------------------------
$(function(){
	Survey = new Survey();
	Survey.getSurvey();
	Survey.editSurvey();
});
//----------------------------------------------------------------

function Survey()
{
	var Obj = new Object();
	
	var saveSurvey = function ()
	{
		$.editable.addInputType('jeditable', {
			element : $.editable.types.text.element,
			buttons : function(settings, original) {
				var default_buttons = $.editable.types['defaults'].buttons;
				default_buttons.apply(this, [settings, original]);

				var aid = $(original).attr("id").split("_");
				var table = aid[0];
				var id = aid[1];
				
				if (id > 0) {
					var third = $('<input type="button">');
					third.val(settings.third);
					$(this).append(third);
					$(third).click(function() {
						var formData = [];
						formData.push({ name: "action", value: "deleteSurvey" });
						formData.push({ name: "id", value: id });
						formData.push({ name: "table", value: table });
						$.ajax({
							url: url,
							type: 'post',
							data: formData,
							dataType: 'json',
							success: function(response) {
								getSurvey();
							}
						});
					});
				}
			}
		});
		
		$('.jeditable').editable(function(value, settings) {
			//console.log(this);
			//console.log(value);
			//console.log(settings);
			//return(value);
			
			var aid = $(this).attr("id").split("_");
			var table = aid[0];
			var id = aid[1];
			
			var formData = [];
			formData.push({ name: "action", value: "saveSurvey" });
			formData.push({ name: "id", value: id });
			formData.push({ name: "value", value: value });
			formData.push({ name: "table", value: table });
			
			if (id > 0) {
				//update
			}
			else {
				//insert
				if (table == "surveyq") {
					formData.push({ name: "surveyId", value: $(this).attr("id_survey") });
				}
				else if (table == "surveya") {
					formData.push({ name: "surveyqId", value: $(this).attr("id_surveyq") });
				}
				
			}
			
			/*
			console.log("table: " + table);
			console.log("id: " + id);
			console.log("id_surveyq: " + $(this).attr("id_surveyq"));
			console.log("id_survey: " + $(this).attr("id_survey"));
			*/
			
			$.ajax({
				url: url,
				type: 'post',
				data: formData,
				dataType: 'json',
				complete: function() {
					Obj.getSurvey();
				},
				success: function(response) {
					console.log(response);
				}
			});

		}, {
			id: 'id',
			name: 'value',
			type: "jeditable",
			indicator: jQuery.i18n.prop('LABEL_Saving'),
			submit: jQuery.i18n.prop('BUTTON_Ok'),
			cancel: jQuery.i18n.prop('BUTTON_Cancel'),
			third: jQuery.i18n.prop('BUTTON_Delete'),
			tooltip: jQuery.i18n.prop('LABEL_ClickToEdit'),
			width: 200,
			callback : function(value, settings) {
				//console.log(this);
				//console.log(value);
				//console.log(settings);
			}
		});
	};

	var deleteSurvey = function (surveyId)
	{
		
	};
	
	var getSurvey = function ()
	{
		var $target = $('ul[cas-js=getSurvey]');
		if ($target.length) {
			
			var url = $target.attr("cas:url");
			var surveyId = $target.attr("cas:var");
			
			var formData = [];
			formData.push({ name: "action", value: "jsonSurvey" });
			formData.push({ name: "surveyId", value: surveyId });
			
			$.ajax({
				url: url,
				type: 'get',
				data: formData,
				dataType: 'json',
				beforeSend: function() {
				},
				complete: function() {
					//Obj.saveSurvey();
				},
				statusCode: {
					404: function() {
						CommonItems.casDialog(jQuery.i18n.prop('ALERT_PageNotFound'));
					}
				},
				success: function(response) {
					$target.html('');
					var items = [];
					$.each(response.surveyq, function(keyq, surveyq) {
						items.push('<li>');
						items.push('<div>'+surveyq.surveyqTitle+'</div>');
						items.push('<ul>');
						$.each(surveyq.surveya, function(keya, surveya) {
							items.push('<li>');
							// FIXME: ilk radio input için  required="required" kullanabiliriz. tümünde kullanınca hepsi için seçilmesi geretiği uyarısını veriyor
							items.push('<input type="radio" name="surveyq['+surveyq.surveyqId+']" value="'+surveya.surveyaId+'" />'+surveyq.surveyqId+'-'+surveya.surveyaId+'-');
							items.push('<span id="surveya_'+surveya.surveyaId+'">'+surveya.surveyaTitle+'</span>');
							items.push('</li>');
						});
						items.push('</ul>');
						items.push('</li>');
					});
					items.push('<li>');
					items.push('<button type="submit" onclick="Survey.voteSurvey(this.form); return false;">Vote</button>');
					items.push('</li>');
					$target.append(items.join(''));
				}
			});
		}
	};
	
	var voteSurvey = function (form)
	{
		$form = $(form);
		$form.validate({
			submitHandler: function(f) {
				$form.ajaxSubmit({
					data: { action: 'saveUserticket' },
					dataType: 'json',
					beforeSubmit: function(a,f,o) {
						//console.log(a);
					},
					success: function(response) {
						if (response.success == true) {
							CommonItems.casDialog({
								content: jQuery.i18n.prop('ALERT_Completed'),
								onClosed: function () {
									//window.location.reload();
								}
							});
						}
						else {
							CommonItems.casDialog(response.msg);
						}
					}
				});
			},
			rules: {
				productId: {
					required: true
				},
				productPrice: {
					required: true
				}
			},
			messages: {
				productId: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				},
				productPrice: {
					required: jQuery.i18n.prop('ALERT_PleaseFillOutThisField')
				}
			}
		});
		return false;
	};

	var editSurvey = function ()
	{
		var $target = $('ul[cas-js=editSurvey]');
		if ($target.length) {
			
			var url = $target.attr("cas:url");
			var surveyId = $target.attr("cas:var");
			
			var formData = [];
			formData.push({ name: "action", value: "jsonSurvey" });
			formData.push({ name: "surveyId", value: surveyId });
			
			$.ajax({
				url: url,
				type: 'get',
				data: formData,
				dataType: 'json',
				beforeSend: function() {
				},
				complete: function() {
					Obj.saveSurvey();
				},
				statusCode: {
					404: function() {
						CommonItems.casDialog(jQuery.i18n.prop('ALERT_PageNotFound'));
					}
				},
				success: function(response) {
					$target.html('');
					var items = [];
					$.each(response.surveyq, function(keyq, surveyq) {
						items.push('<li>');
						items.push('<div class="jeditable" id="surveyq_'+surveyq.surveyqId+'">'+surveyq.surveyqTitle+'</div>');
						items.push('<ul>');
						$.each(surveyq.surveya, function(keya, surveya) {
							items.push('<li>');
							items.push('<div class="jeditable" id="surveya_'+surveya.surveyaId+'">'+surveya.surveyaTitle+'</div>');
							items.push('</li>');
						});
						items.push('<li>');
						items.push('<div class="jeditable" id_surveyq="'+surveyq.surveyqId+'" id="surveya_0"></div>');
						items.push('</li>');
						items.push('</ul>');
						items.push('</li>');
					});
					items.push('<li>');
					items.push('<div class="jeditable" id_survey="'+response.surveyId+'" id="surveyq_0"></div>');
					items.push('</li>');
					$target.append(items.join(''));
				}
			});
		}
	};
	
	Obj.saveSurvey = saveSurvey;
	Obj.deleteSurvey = deleteSurvey;
	Obj.getSurvey = getSurvey;
	Obj.editSurvey = editSurvey;
	Obj.voteSurvey = voteSurvey;
	return Obj;
}