{if $data.isApproved eq true}
	İşleminiz başarı ile tamamlandı.
	Siparişlerinizin durumunu "<a href="modules/b2c/productorder.php">Siparişlerim</a>" menüsünden takip edebilirsiniz.
{else}
	<a href="modules/b2c/sales.php">İşleminiz başarısız. Lütfen yeniden deneyin.</a>
{/if}

<table class="dn">
{foreach from=$data item="entry" key="k"}
<tr bgcolor="{cycle values="#dedede,#eeeeee" advance=true}">
	<td>{$k}</td>
	<td>{$entry}</td>
</tr>
{/foreach}
</table>