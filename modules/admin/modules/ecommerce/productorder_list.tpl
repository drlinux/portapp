<style type="text/css" title="currentStyle">
@import "assets/plugins/DataTables-1.8.2/media/css/demo_table.css";
@import "assets/plugins/DataTables-1.8.2/extras/TableTools/media/css/TableTools.css";
</style>
<script type="text/javascript" src="assets/plugins/DataTables-1.8.2/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="assets/plugins/DataTables-1.8.2/extras/TableTools/media/js/TableTools.min.js"></script>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
	$('#example').dataTable( {
		"sDom": '<"top"iflpT<"clear">>rt<"bottom"iflp<"clear">>',
		"oTableTools": {
			"sSwfPath": "assets/plugins/DataTables-1.8.2/extras/TableTools/media/swf/copy_cvs_xls_pdf.swf",
			"aButtons": [
							{
								"sExtends": "print",
								"sButtonText": "{#BUTTON_Print#}"
							},
							{
								"sExtends":    "collection",
								"sButtonText": "{#BUTTON_Save#}",
								"aButtons":    [ "xls" ]
							}
						]
		},
		"aoColumnDefs": [
			{ "asSorting": [ "desc" ], "aTargets": [ 0 ] },
			{ "bVisible": false,  "aTargets": [ 0, 1 ] }
		],
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
			$('td:eq(0)', nRow).html( aData[1] + ' ' + aData[2] );
			$('td:eq(1)', nRow).html( '<a href="{$SCRIPT_NAME}?action=show&productorderId=' + aData[0] + '">' + aData[3] + '</a>' );
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
		"bJQueryUI": false,
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
		<th>Kullanıcı</th>
		<th>Kullanıcı</th>
		<th>Sİpariş No</th>
		<th>Tarih</th>
		<th>Ödeme</th>
		<th>Taşıma</th>
		<th>{#LABEL_Status#}</th>
	</tr>
</thead>
<tbody>
	<tr>
		<td colspan="7" class="dataTables_empty">Loading data from server</td>
	</tr>
</tbody>
</table>