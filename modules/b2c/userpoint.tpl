<div class="casContent">
	<h3 class="subHeader">KAZANDIĞIM PUANLAR</h3>
	<table style="width: 100%;">
	<thead>
		<tr>
			<th></th>
			<th>Kazanılan Puan</th>
			<th>Tarih</th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$data.userpoints.aaData item=userpoint}
		<tr>
			<td style="width: 20%; text-align: center;">{$userpoint.userpointtypeTitle}</td>
			<td style="width: 40%; text-align: center;">{$userpoint.userpointAmount}</td>
			<td style="width: 40%; text-align: center;">{$userpoint.userpointDatetime}</td>
		</tr>
	{/foreach}
	</tbody>
	<tfoot>
		<tr>
			<th>Toplam</th>
			<th>{$data.userpoints.totalUserpoint}</th>
			<th></th>
		</tr>
	</tfoot>
	</table>
</div>

<div class="casContent">
	<h3 class="subHeader">HARCADIĞIM PUANLAR</h3>
	<table style="width: 100%;">
	<thead>
		<tr>
			<th></th>
			<th>Kazanılan Puan</th>
			<th>Tarih</th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$data.userpoints.aaData item=userpoint}
		<tr>
			<td style="width: 20%; text-align: center;">{$userpoint.userpointtypeTitle}</td>
			<td style="width: 40%; text-align: center;">{$userpoint.userpointAmount}</td>
			<td style="width: 40%; text-align: center;">{$userpoint.userpointDatetime}</td>
		</tr>
	{/foreach}
	</tbody>
	<tfoot>
		<tr>
			<th>Toplam</th>
			<th>{$data.userpoints.totalUserpoint}</th>
			<th></th>
		</tr>
	</tfoot>
	</table>
</div>