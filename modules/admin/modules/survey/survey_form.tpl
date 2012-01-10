<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
<table>
{if $msg ne ""}
<caption class="ui-state-error ui-corner-all">
	{if $msg eq "surveyTitle_empty"} Lütfen bir başlık girin
	{/if}
</caption>
{/if}
<tbody>
	<tr class="dn">
		<th>{#LABEL_Id#}</th>
		<td><input type="text" name="surveyId" value="{$data.surveyId}" readonly="readonly"/></td>
	</tr>
	<tr>
		<th>{#LABEL_Title#}</th>
		<td><input type="text" name="surveyTitle" value="{$data.surveyTitle}"/></td>
	</tr>
	<tr>
		<th>{#LABEL_Start#}</th>
		<td><input type="text" class="datetimepicker" name="surveyStart" value="{$data.surveyStart}"/></td>
	</tr>
	<tr>
		<th>{#LABEL_End#}</th>
		<td><input type="text" class="datetimepicker" name="surveyEnd" value="{$data.surveyEnd}"/></td>
	</tr>
</tbody>
<tfoot>
	<tr>
		<th></th>
		<td>
			<span class="buttonset">
				<button name="action" value="save">{#BUTTON_Save#}</button>
				{if $data.surveyId neq null}
				<button name="action" value="delete">{#BUTTON_Delete#}</button>
				{/if}
			</span>
		</td>
	</tr>
</tfoot>
</table>
</form>

{if $data.surveyId neq null}
<ul cas-js="editSurvey" cas:var="{$data.surveyId}" cas:url="modules/admin/modules/survey/survey.php"></ul>
{/if}