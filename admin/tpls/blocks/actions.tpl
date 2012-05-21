<div class="action_menu">
<ul id="action_menu_{id}">
{loop actions}
<li {block actions.active}class="a"{-block actions.active}><img src="admin/images/actions/{actions.img}.gif" class="vam" />&nbsp;<a href="{actions.action}">{actions.title}</a></li>
{-loop actions}
</ul>
</div>