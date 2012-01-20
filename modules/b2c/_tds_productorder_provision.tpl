<div class="casContent">
	<h1 class="subHeader">İşlem Sonucu</h1>
	
	{if $data.response.approved eq 1}
	<p>{$data.response.msg}</p>
	{else}
	<p class="c-ff0000">
	Hata Kodu: {$data.response.respCode}<br/>
	{$data.response.msg}<br/>
	</p>
	{/if}
	
</div>