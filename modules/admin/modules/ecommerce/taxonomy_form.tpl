<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
<table class="ui-widget-content ui-corner-all">
{if $msg ne ""}
<caption class="ui-state-error ui-corner-all">
	{if $msg eq "taxonomyTitle_empty"}You must supply a title
	{elseif $msg eq "taxonomyRate_empty"}You must supply a rate
	{/if}
</caption>
{/if}
<tbody>
	<tr class="dn">
		<td>{#LABEL_Id#}</td>
		<td>
			<input type="text" name="taxonomyId" value="{$data.model.taxonomyId}" readonly="readonly" />
		</td>
	</tr>
	<tr>
		<td>{#LABEL_Rate#}</td>
		<td>
			<input type="text" name="taxonomyRate" value="{$data.model.taxonomyRate}" />
		</td>
	</tr>
	<tr>
		<td>{#LABEL_Sorting#}</td>
		<td>
			<input type="text" name="taxonomySorting" value="{$data.model.taxonomySorting}" />
		</td>
	</tr>



	<tr>
		<td></td>
		<td><hr/></td>
	</tr>



	<tr>
		<td class="vat">{#LABEL_Title#}</td>
		<td>
			{foreach from=$data.i18n item="entry"}
			<div>{$entry.iso639.iso639Title}</div>
			<input type="text" name="taxonomyTitle[{$entry.iso639.iso639Id}]" value="{$entry.model.taxonomyTitle}"/>
			{/foreach}
		</td>
	</tr>

</tbody>
<tfoot>
	<tr>
		<td></td>
		<td>
			<span class="buttonset">
			<button name="action" value="save">{#BUTTON_Save#}</button>
			{if $data.model.taxonomyId neq null}
			<button name="action" value="delete">{#BUTTON_Delete#}</button>
			{/if}
			</span>
		</td>
	</tr>
</tfoot>
</table>
</form>