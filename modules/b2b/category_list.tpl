<div class="casContent">
	<h1 class="subHeader">KATEGORİLER</h1>
	<ul>
		{foreach from=$data.category_list.aaData item="category"}
			<li><a href="modules/b2b/category.php?action=show&categoryId={$category.categoryId}">{$category.categoryTitle}</a></li>
		{/foreach}
	</ul>
</div>
