<h1 class="title">{phrases.title_rss}</h1>

<div class="page_description">

<loop name="modules">
<a href="rss.php?module={modules.table_name}&lng={lng}">{modules.title}</a><br />
</loop name="modules">

</div>