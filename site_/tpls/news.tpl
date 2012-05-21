<call code="name=item_data::set=var::module=pages::method=loadPage::params={{page_data.id}}">
<h1>{item_data.title}</h1>

<div id="path">
<loop name="id_path">
<block name="id_path.first" no>
&nbsp;&nbsp;»&nbsp;&nbsp;
</block name="id_path.first" no>
<a href="{lng}{id_path.page_url}" title="{id_path.page_title}">{id_path.title}</a>
</loop name="id_path">
<block name="get.id">
<call code="name=news_data::set=var::module=news::method=loadItem::params={{get.id}}">
&nbsp;&nbsp;»&nbsp;&nbsp;
{news_data.title}
</block name="get.id">
</div>										

<block name="get.id" no>
<call code="name=news_list::set=loop::module=news::method=listItems::params={{get.offset}}">
<loop name="news_list">

<div class="news_item">
<block name="news_list.image">
<img src="{upload_url}thumb_{news_list.image}" alt="" />
</block name="news_list.image">
{news_list.news_date} <a class="news_title" href="{lng}{item_data.page_url}id/{news_list.id}/" ><b>{news_list.title}</b></a>
<p>{news_list.summary}</p> 
<a href="{lng}{item_data.page_url}id/{news_list.id}/">... {phrases.more}</a>
<div class="clear"></div>
</div>

</loop name="news_list">

<call code="name=news_paging::set=loop::module=news::method=pagingItems::params={{get.offset}},7">
<div class="paging">
<loop name="news_paging">
<a href="{lng}{item_data.page_url}{reserved_url_words.offset}/{news_paging.value}" <block name="news_paging.active">class="a"</block name="news_paging.active">>{news_paging.title}</a>
</loop name="news_paging">
</div>
</block name="get.id" no>


<block name="get.id">
<h2>{news_data.title}</h2>
{news_data.description}
<p align="right"><a href="javascript: history.back(1);">{phrases.back}</a></p>
</block name="get.id">