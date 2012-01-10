<div id="content">
	<h1>{#LABEL_PersonalInformation#}</h1>
	<table class="jtable">
	<tbody>
		<tr>
			<th>{#LABEL_Username#}</th>
			<td>{$data.userName}</td>
		</tr>
		<tr>
			<th>{#LABEL_EmailAddress#}</th>
			<td>{$data.userEmail}</td>
		</tr>
		<tr>
			<th>Ad Soyad</th>
			<td>{$data.userFirstname} {$data.userLastname}</td>
		</tr>
		<tr>
			<th>{#LABEL_Birthdate#}</th>
			<td>{$data.userBirthdate}</td>
		</tr>
		<tr>
			<th>TCKN</th>
			<td>{$data.userTckn}</td>
		</tr>
		<tr>
			<th>{#LABEL_Gender#}</th>
			<td>
				{if $data.userGender eq 'F'}Bayan{/if}
				{if $data.userGender eq 'M'}Bay{/if}
			</td>
		</tr>
		<tr>
			<th>{#LABEL_Phone#}</th>
			<td>{$data.userPhone}</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td></td>
			<td>
				<span class="buttonset">
					<a href="{$SCRIPT_NAME}?action=edit">{#BUTTON_Edit#}</a>
				</span>
			</td>
		</tr>
	</tfoot>
	</table>
</div>