<style type="text/css" title="currentStyle">
@import "assets/plugins/DataTables-1.8.2/media/css/demo_table_jui.css";
@import "assets/plugins/DataTables-1.8.2/extras/TableTools/media/css/TableTools_JUI.css";
</style>
<script type="text/javascript" src="assets/plugins/DataTables-1.8.2/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/DataTables-1.8.2/extras/TableTools/media/js/TableTools.min.js"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	$('#example').dataTable( {
		"sDom": 'T<"clear">lfrtip',
		"oTableTools": {
			"aButtons": [
							{
								"sExtends":    "text",
								"fnClick": function ( nButton, oConfig, oFlash ) {
									if (confirm('{#ALERT_AreYouSureToDeleteAll#}')) {
										location.href = '{$SCRIPT_NAME}?action=deleteBanners';
									}
								},
								"sButtonText": "{#BUTTON_DeleteAll#}"
							},
							{
								"sExtends":    "text",
								"fnClick": function ( nButton, oConfig, oFlash ) {
									location.href = '{$SCRIPT_NAME}?action=new';
								},
								"sButtonText": "{#BUTTON_NewEntry#}"
							}
						]
		},
		"aoColumnDefs": [
			{ "bVisible": false,  "aTargets": [ 0 ] },
		],
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
			$('td:eq(0)', nRow).html( '<a href="{$SCRIPT_NAME}?action=edit&bannerId=' + aData[0] + '">' + aData[1] + '</a>' );
			//if (aData[3] != null) $('td:eq(2)', nRow).html( '<a href="{$SCRIPT_NAME}?action=edit&bannerId=' + aData[0] + '"><img src="img/banner/100/' + aData[3] + '" /></a>' );
			return nRow;
		},
		"oLanguage": {
			"oPaginate": {
				"sFirst":    "{#oLanguage_oPaginate_sFirst#}",
				"sLast":     "{#oLanguage_oPaginate_sLast#}",
				"sNext":     "{#oLanguage_oPaginate_sNext#}",
				"sPrevious": "{#oLanguage_oPaginate_sPrevious#}"
			},
			"sEmptyTable":   "{#oLanguage_sEmptyTable#}",
			"sInfo":         "{#oLanguage_sInfo#}",
			"sInfoEmpty":    "{#oLanguage_sInfoEmpty#}",
			"sInfoFiltered": "{#oLanguage_sInfoFiltered#}",
			"sInfoPostFix":  "{#oLanguage_sInfoPostFix#}",
			"sLengthMenu":   "{#oLanguage_sLengthMenu#}",
			"sProcessing":   "{#oLanguage_sProcessing#}",
			"sSearch":       "{#oLanguage_sSearch#}",
			//"sUrl":          "{#oLanguage_sUrl#}",
			"sZeroRecords":  "{#oLanguage_sZeroRecords#}"
		},
		"aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "{#LABEL_All#}"]],
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "{$SCRIPT_NAME}",
		"fnServerData": function ( sSource, aoData, fnCallback ) {
			aoData.push( { "name": "action", "value": "dataTables" } );
			$.getJSON( sSource, aoData, function (json) { 
				fnCallback(json);
			} );
		}
	});
});
</script>

<table class="display" id="example">
<thead>
	<tr>
		<th>{#LABEL_Id#}</th>
		<th>{#LABEL_Title#}</th>
		<th>{#LABEL_Description#}</th>
		<th>{#LABEL_Start#}</th>
		<th>{#LABEL_End#}</th>
	</tr>
</thead>
<tbody>
	<tr>
		<td colspan="5" class="dataTables_empty">Loading data from server</td>
	</tr>
</tbody>
</table>