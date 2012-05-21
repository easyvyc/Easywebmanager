<call code="name=citems::set=loop::module=comments::method=listCategoryItems::params={{get.prid}},{{get.offset}}">
<call code="name=paging::set=loop::module=comments::method=pagingItems::params={{get.offset}},10">
<call code="name=is_paging::set=var::module=comments::method=is_pagingItems::params=">

<loop name="citems">
<div class="comment radius3" id="citems_{citems.id}">
	<span><em>{citems.create_date}</em> <b>{citems.author}</b></span>
	<p>{citems.title}</p>
</div>
</loop name="citems">

<block name="is_paging">
<div class="paging">
{phrases.paging}&nbsp;&nbsp;
<loop name="paging">
<a href="javascript: void(ajax('{config.site_url}ajax.php?content=comments&prid={get.prid}&offset={paging.value}', 'comments_list'));" class="radius3 <block name="paging.active">a</block name="paging.active">" >{paging.title}</a>
</loop name="paging">
</div>
</block name="is_paging">