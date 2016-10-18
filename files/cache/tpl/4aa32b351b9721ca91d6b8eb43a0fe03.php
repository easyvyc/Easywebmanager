<div class="action_menu">
<ul id="action_menu_<?php echo TPL::getVar("id"); ?>">
<?php $actions_iterator=1; foreach(TPL::getLoop("actions") as $actions_key => $actions_val){ if(!is_array($actions_val)){ $tmp_val=$actions_val; $actions_val=array(); $actions_val['_VALUE']=$tmp_val; } $actions_val['_FIRST']=0; if($actions_iterator==1) $actions_val['_FIRST']=1; if($actions_iterator%2==1) $actions_val['_EVEN']=0; else $actions_val['_EVEN']=1; $actions_val['_INDEX']=$actions_iterator++; $actions_val['_KEY']=$actions_key; ?>
<li <?php if(isset($actions_val["active"]) && $actions_val["active"]){ ?>class="a"<?php } ?>><img src="admin/images/actions/<?php if(isset($actions_val["img"])) echo $actions_val["img"]; ?>.gif" class="vam" />&nbsp;<a href="<?php if(isset($actions_val["action"])) echo $actions_val["action"]; ?>"><?php if(isset($actions_val["title"])) echo $actions_val["title"]; ?></a></li>
<?php } ?>
</ul>
</div>