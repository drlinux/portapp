<div class="areaHeader">
	<span class="museo500">Bilgilendirme mesajları hizmeti</span>
</div>

<div style="width:100%; float:left;">
<form autocomplete="off" action="{$SCRIPT_NAME}" method="post">
<table class="jtable2">
{if $msg ne ""}
<caption class="ui-state-error ui-corner-all">
	{if $msg eq "optinoutEmail_empty"} Lütfen e-posta adresinizi girin
	{elseif $msg eq "optinoutEmail_error"} Hatalı e-posta adresi formatı
	{elseif $msg eq "success"} İşleminiz tamamlandı
	{/if}
</caption>
{/if}
<tbody>
	<tr>
		<th>{#LABEL_EmailAddress#}</th>
		<td><input type="text" name="optinoutEmail" value="{$data.optinoutEmail}" title="E-posta adresinizi girin" /></td>
	</tr>
</tbody>
<tfoot>
	<tr>
		<td></td>
		<td>
			<span class="buttonset">
				<button name="action" value="saveOptin">Üye ol</button>
				<button name="action" value="saveOptout">Üyelikten çık</button>
			</span>
		</td>
	</tr>
</tfoot>
</table>
</form>
</div>