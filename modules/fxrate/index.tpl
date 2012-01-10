<div style="text-align:right;font-size:1.5em">Exchange Rates History</div>
<div style="text-align:right">Data feed from Central Bank of the Republic of Turkey</div>

<script type="text/javascript" src="assets/ofc/json2.js"></script>
<script type="text/javascript" src="assets/ofc/swfobject.js"></script>
<script type="text/javascript">
var flashvars = {};
var params = {};
params.wmode = "opaque";
var attributes = {};
swfobject.embedSWF("assets/ofc/open-flash-chart.swf", "chartFxrate", "100%", "100%", "9.0.0", "assets/ofc/expressInstall.swf", {}, flashvars, params, attributes);
</script>

<center>
	<form action="{$SCRIPT_NAME}" method="get">
		<label>Draw</label>
		{html_options name=currency options=$data.currency.options selected=$data.currency.selected}
		<label>Between</label>
		<input type="text" class="datepicker" name="start" value="{$data.start}" readonly size="9" />
		<label>and</label>
		<input type="text" class="datepicker" name="end" value="{$data.end}" readonly size="9" />
		<button name="action" value="graph">{#BUTTON_Submit#}</button>
	</form>
</center>
<div id="resize" style="width:100%; height:550px"><div id="chartFxrate"></div></div>

<div id="div_datepicker" title="Please select a date range">
	<form id="form_datepicker2" method="get" action="tools/fxrate/index.php">
		Between <input type="text" class="datepicker" name="start" value="{$data.start}" readonly size="9" />
		and <input type="text" class="datepicker" name="end" value="{$data.end}" readonly size="9" />
	</form>
</div>

<style>
.ui-datepicker { font-size:smaller; z-index: 1003 }
</style>

<script type="text/javascript">
$(document).ready(function(){
	
	$("#resize").resizable();
	
	$('.datepicker').datepicker({
		minDate: new Date(2002, 6 - 1, 18),
		maxDate: new Date(),
		dateFormat: 'yy-mm-dd',
		numberOfMonths: 2,
		showButtonPanel: true,
		changeMonth: true,
		changeYear: true
	});
	
	$("#div_datepicker").dialog({
		width: 350,
		modal: true,
		autoOpen: false,
		buttons: {
			'Okay': function() {
				$("#form_datepicker2").submit();
				$(this).dialog('close');
			},
			'Cancel': function() {
				$(this).dialog('close');
			}
		}
	});
	
});

function datepicker() {
	$('#div_datepicker').dialog('open');
}

function ofc_ready() {
	//alert('ofc_ready');
}
function open_flash_chart_data() {
	//alert('reading data');
	return JSON.stringify(data1);
}
function findSWF(movieName) {
	if (navigator.appName.indexOf("Microsoft")!= -1) {
		return window[movieName];
	} else {
		return document[movieName];
	}
}

var data1 = {$data.chart1};
</script>
