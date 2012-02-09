<div class="fl">
	<form action="{$SCRIPT_NAME}" method="post">
	<table>
	{if $msg ne ""}
	<caption class="ui-state-error ui-corner-all">
		{if $msg eq "voucherTitle_empty"} Lütfen bir başlık girin
		{/if}
	</caption>
	{/if}
	<tbody>
		<tr class="dn">
			<th>{#LABEL_Id#}</th>
			<td><input type="text" name="voucherId" value="{$data.model.voucherId}" readonly="readonly"/></td>
		</tr>
		<tr>
			<th>{#LABEL_Title#}</th>
			<td><input type="text" name="voucherTitle" value="{$data.model.voucherTitle}"/></td>
		</tr>
		<tr>
			<th>{#LABEL_Start#}</th>
			<td><input type="text" class="datetimepicker" name="voucherStart" value="{$data.model.voucherStart}"/></td>
		</tr>
		<tr>
			<th>{#LABEL_End#}</th>
			<td><input type="text" class="datetimepicker" name="voucherEnd" value="{$data.model.voucherEnd}"/></td>
		</tr>
		<tr>
			<th>İndirim Oranı</th>
			<td><input type="text" name="voucherDiscountRate" value="{$data.model.voucherDiscountRate}"/></td>
		</tr>
		<tr>
			<th>İndirim Fiyatı</th>
			<td><input type="text" name="voucherDiscountPrice" value="{$data.model.voucherDiscountPrice}"/></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th></th>
			<td>
				<span class="buttonset">
					<button name="action" value="save">{#BUTTON_Save#}</button>
					{if $data.model.voucherId neq null}
					<button name="action" value="delete">{#BUTTON_Delete#}</button>
					{/if}
				</span>
			</td>
		</tr>
	</tfoot>
	</table>
	</form>
</div>
<div class="fr">
	<form method="post" action="{$SCRIPT_NAME}">
	<table>
		<tr class="dn">
			<th>voucherId</th>
			<td><input type="text" name="voucherId" value="{$data.model.voucherId}" readonly="readonly"/></td>
		</tr>
		<tr>
			<th>Üretilecek Kod Miktarı</th>
			<td><input type="text" class="spinnerhide" name="voucherQuantity" value="1" /></td>
		</tr>
		<tr>
			<th></th>
			<td><button type="submit" name="action" value="generate">Kod Oluştur</button></td>
		</tr>
		{foreach from=$data.vouchercode.aaData key="key" item="entry"}
		<tr bgcolor="{cycle values="#dedede,#eeeeee" advance=true}">
			<td style="width: 30px;">{$key+1}</td>
			<td>{$entry.voucherCode}</td>
		</tr>
		{foreachelse}
		<tr>
			<td colspan="2">{#ALERT_NoRecords#}</td>
		</tr>
		{/foreach}
	</table>
	</form>
</div>

<script>
$(function() {
	$('.spinnerhide')
	.spinner({
		//showOn: 'both',
		//max: 100,
		min: 1
	})
	.change(function() {
		return false;
	});
});
</script>
