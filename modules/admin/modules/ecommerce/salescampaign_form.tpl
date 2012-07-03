<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
<table>
{if $msg ne ""}
<caption class="ui-state-error ui-corner-all">
	Hata Kodu: {$msg}
	{if $msg eq "salescampaignTitle_empty"}Lütfen bir başlık girin
	{elseif $msg eq "salescampaignContent_empty"}Lütfen bir içerik girin
	{/if}
</caption>
{/if}
<tbody>
	<tr class="dn">
		<td>{#LABEL_Id#}</td>
		<td>
			<input type="text" name="salescampaignId" value="{$data.model.salescampaignId}"/>
		</td>
	</tr>
	<tr>
		<td>başlık:</td>
		<td>
			<input type="text" name="salescampaignTitle" value="{$data.model.salescampaignTitle|escape}"/>
		</td>
	</tr>
	<tr>
		<td valign="top">içerik:</td>
		<td>
			<textarea class="wysiwyg" name="salescampaignContent">{$data.model.salescampaignContent|escape}</textarea>
		</td>
	</tr>
	<tr>
		<td>{#LABEL_Start#}</td>
		<td><input type="text" class="datetimepicker" name="salescampaignStart" value="{$data.model.salescampaignStart}"/></td>
	</tr>
	<tr>
		<td>{#LABEL_End#}</td>
		<td><input type="text" class="datetimepicker" name="salescampaignEnd" value="{$data.model.salescampaignEnd}"/></td>
	</tr>
	<tr>
		<td>Ürünler</td>
		<td>
			<select class="multiselect" name="productattributeId[]" multiple="multiple" size="5">
			{html_options options=$data.productattribute.options selected=$data.model.productattribute.selected}
			</select>
			<!--
			<ul id="selectedProducts">
				{foreach from=$data.model.productattribute.aaData item="entry"}
				<li id="p_multiselect_{$entry.productattributeId}">{$entry.productattributeCode}</li>
				{/foreach}
			</ul>
			-->
		</td>
	</tr>
	{$pictureIndex = 0}
	{while $pictureIndex lt 2}
		<tr>
			<td>{#LABEL_Image#}</td>
			<td>
				<input type="hidden" name="MAX_FILE_SIZE" value="2048000" readonly="readonly" />
				<input type="file" name="pictureFile_{$pictureIndex + 1}" />
			</td>
		</tr>
		{if {$data.pictures[$pictureIndex].pictureFile} neq null}
			<tr>
				<td></td>
				<td>
					<img src="img/salescampaign/{$data.pictures[$pictureIndex].pictureFile}" />
				</td>
			</tr>
		{/if}
		{$pictureIndex++}
	{/while}
</tbody>
<tfoot>
	<tr>
		<td></td>
		<td>
			<span class="buttonset">
			<button name="action" value="save">{#BUTTON_Save#}</button>
			{if $data.model.salescampaignId neq null}
			<button name="action" value="delete">{#BUTTON_Delete#}</button>
			<!-- <a action="delete" id="{$data.model.salescampaignId}" href="javascript:return false;">{#BUTTON_Delete#}</a> -->
			{/if}
			</span>
		</td>
	</tr>
</tfoot>
</table>
</form>

<script>
$(function() {
	
	$("form#formSalescampaign a[action=delete]").click(function(){
		var salescampaignId = $(this).attr("id");
		var formData = [];
		formData.push({ name: "action", value: "ajaxDeleteSalescampaign" });
		formData.push({ name: "salescampaignId", value: salescampaignId });
		$.post("{$SCRIPT_NAME}",
				formData,
				function(response, textStatus, xhr) {
					alert("POST returned " + response + ", " + textStatus);
					window.location.replace("{$SCRIPT_NAME}");
				}
		);
	});
	
	$("form#formSalescampaign").submit(function() {
		var formData = $(this).serializeArray();
		console.log(formData);
		/*
		formData.push({ name: "action", value: "ajaxSaveSalescampaign" });

		alert("POSTing this:\n" + jQuery.param(formData));
		
		$.post("{$SCRIPT_NAME}",
				formData,
				function(response, textStatus, xhr){
					//alert("POST returned " + response + ", " + textStatus);
					window.location.replace("{$SCRIPT_NAME}?action=edit&salescampaignId=" + response.salescampaignId);
				},
				"json"
		);
		*/
		return false;
	});

	
	moreInput();
	
	$('#btnAddFile')
		.click(function() {
			moreInput();
		});

});

function moreInput() {
	$('#divFiles').append('<span class="db"><input type="file" name="pictureFile[]"/></span>');
}
</script>