<div class="tabs">
	<ul>
		<li><a href="#tabs-1">Ödeme tipi</a></li>
		{if $data.model.paymentgroupId neq null}
		<li><a href="#tabs-2">Taşıma ile ilişkilendir</a></li>
		<li><a href="#tabs-3">Taksitlendirme</a></li>
		{/if}
	</ul>
	<div id="tabs-1">
		<form action="{$SCRIPT_NAME}" method="post" enctype="multipart/form-data">
		<table class="ui-widget-content ui-corner-all">
		<tbody>
			<tr class="dn">
				<td>{#LABEL_Id#}</td>
				<td>
					<input type="text" name="paymentgroupId" value="{$data.model.paymentgroupId}" readonly="readonly" />
				</td>
			</tr>
			<tr>
				<td>Tip</td>
				<td>
					<select name="paymentgroupType">
					<option value="mt"{if $data.model.paymentgroupType eq 'mt'} selected="selected"{/if}>Para Transferi</option>
					<option value="pd"{if $data.model.paymentgroupType eq 'pd'} selected="selected"{/if}>Kapıda Ödeme</option>
					<option value="cc"{if $data.model.paymentgroupType eq 'cc'} selected="selected"{/if}>Kredi Kartı</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>{#LABEL_Sorting#}</td>
				<td>
					<input type="text" name="paymentgroupSorting" value="{$data.model.paymentgroupSorting}" />
				</td>
			</tr>
			<tr>
				<td>class</td>
				<td>
					<input type="text" name="paymentgroupClass" value="{$data.model.paymentgroupClass}" />
				</td>
			</tr>
			<tr>
				<td>{#LABEL_Status#}</td>
				<td>
					<input type="text" name="paymentgroupStatus" value="{$data.model.paymentgroupStatus}" />
				</td>
			</tr>
			<tr>
				<td>Banka</td>
				<td>
					{html_options name=bankCode options=$data.bank.options selected=$data.model.bankCode}
				</td>
			</tr>
			<tr>
				<td>{#LABEL_Server#}</td>
				<td>
					<input type="text" name="paymentgroupGate1" value="{$data.model.paymentgroupGate1}" />
				</td>
			</tr>
			<tr>
				<td>{#LABEL_Server#}</td>
				<td>
					<input type="text" name="paymentgroupGate2" value="{$data.model.paymentgroupGate2}" />
				</td>
			</tr>
			<tr>
				<td>MID</td>
				<td>
					<input type="text" name="paymentgroupMid" value="{$data.model.paymentgroupMid}" />
				</td>
			</tr>
			<tr>
				<td>TID</td>
				<td>
					<input type="text" name="paymentgroupTid" value="{$data.model.paymentgroupTid}" />
				</td>
			</tr>
			<tr>
				<td>POSNET ID</td>
				<td>
					<input type="text" name="paymentgroupPosnetid" value="{$data.model.paymentgroupPosnetid}" />
				</td>
			</tr>
			<tr>
				<td>{#LABEL_Logo#}</td>
				<td>
					<input type="hidden" name="MAX_FILE_SIZE" value="2048000" readonly="readonly" />
					<input type="file" name="pictureFile" />
				</td>
			</tr>
			{if $data.model.pictureFile neq null}
			<tr>
				<td></td>
				<td>
					<img src="img/paymentgroup/100/{$data.model.pictureFile}" />
				</td>
			</tr>
			{/if}
		
		
		
		
			<tr>
				<th></th>
				<td><hr/></td>
			</tr>
		
		
		
			<tr>
				<td class="vat">{#LABEL_Title#}</td>
				<td>
					{foreach from=$data.i18n item="entry"}
					<div>{$entry.iso639.iso639Title}</div>
					<input type="text" name="paymentgroupTitle[{$entry.iso639.iso639Id}]" value="{$entry.model.paymentgroupTitle}"/>
					{/foreach}
				</td>
			</tr>
			<tr>
				<td class="vat">{#LABEL_Content#}</td>
				<td>
					{foreach from=$data.i18n item="entry"}
					<div>{$entry.iso639.iso639Title}</div>
					<textarea name="paymentgroupContent[{$entry.iso639.iso639Id}]">{$entry.model.paymentgroupContent}</textarea>
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
					{if $data.model.paymentgroupId neq null}
					<button name="action" value="delete">{#BUTTON_Delete#}</button>
					{/if}
					</span>
				</td>
			</tr>
		</tfoot>
		</table>
		</form>
	</div>
	{if $data.model.paymentgroupId neq null}
	<div id="tabs-2">
		<form action="{$SCRIPT_NAME}" method="post">
		<table class="ui-widget-content ui-corner-all">
		<tbody>
			<tr class="dn">
				<td>{#LABEL_Id#}</td>
				<td>
					<input type="text" name="paymentgroupId" value="{$data.model.paymentgroupId}" readonly="readonly" />
				</td>
			</tr>
			<tr>
				<td>Taşıma Firmaları</td>
				<td>
					<select name="transportationId[]" multiple="multiple" title="Birden fazla seçim için Ctrl tuşuna basıp seçimlerinizi yapabilirsiniz">
					{html_options options=$data.transportation.options selected=$data.model.transportation.selected}
					</select>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td></td>
				<td>
					<span class="buttonset">
					<button name="action" value="saveTransportation">{#BUTTON_Save#}</button>
					</span>
				</td>
			</tr>
		</tfoot>
		</table>
		</form>
	</div>
	<div id="tabs-3">
		<table style="width: 300px">
		<caption>Taksitler</caption>
		<thead><tr><th>Süre</th><th>Oran</th></tr></thead>
		<tbody>
			<form action="{$SCRIPT_NAME}" method="post">
			<tr>
				<td>
					<input type="text" name="paymentPeriod" size="3" />
				</td>
				<td>
					<input type="text" name="paymentimpactWeight" size="3" />
				</td>
				<td>
					<input type="hidden" name="paymentgroupId" value="{$data.model.paymentgroupId}" readonly="readonly" />
					<span class="buttonset">
					<button name="action" value="savePayment">{#BUTTON_Save#}</button>
					</span>
				</td>
			</tr>
			</form>
			{foreach from=$data.model.payment.aaData item="entry"}
			<tr>
				<td>{$entry.paymentPeriod}</td>
				<td>{$entry.paymentimpactWeight}</td>
				<td><a href="{$SCRIPT_NAME}?action=deletePayment&paymentId={$entry.paymentId}">{#BUTTON_Delete#}</a></td>
			</tr>
			{/foreach}
		</tbody>
		</table>
	</div>
	{/if}
</div>