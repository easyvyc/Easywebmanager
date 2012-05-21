<call code="name=item_data::set=var::module=pages::method=loadPage::params={{page_data.id}}">

<h1>{item_data.title}</h1>

<div id="path">
<loop name="id_path">
<block name="id_path.first" no>
&nbsp;&nbsp;»&nbsp;&nbsp;
</block name="id_path.first" no>
<a href="{lng}{id_path.page_url}" title="{id_path.page_title}">{id_path.title}</a>
</loop name="id_path">
</div>	
	
<block name="get.ok" no>
<call code="name=edit_user::set=var::module=users::method=loadEditUser::params=">
{edit_user}	
</block name="get.ok" no>

<block name="get.ok">
<p>{phrases.user_info_saved_success}</p>
</block name="get.ok">