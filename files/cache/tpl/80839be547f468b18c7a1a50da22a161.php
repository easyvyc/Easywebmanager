<fieldset class="formElementsField table action_info">
    
    <legend><?php echo TPL::getVar("phrases.main.common.info_title"); ?></legend>
    
    <div class="row">
        <span class="cell">ID#:</span> 
        <span class="cell"><?php echo TPL::getVar("info.id"); ?></span>
    </div>
    
    <div class="row">
        <span class="cell"><?php echo TPL::getVar("phrases.main.common.info_module"); ?>:</span> 
        <span class="cell"><?php echo TPL::getVar("info.module_info.title"); ?> (<?php echo TPL::getVar("info.module_info.table_name"); ?> - #<?php echo TPL::getVar("info.module_info.id"); ?>)</span>
    </div>

    <?php if(TPL::getVar("no")){ ?>
    <?php if(TPL::getVar("info.parent_id")){ ?>
    <div class="row">
        <span class="cell"><?php echo TPL::getVar("phrases.main.common.info_parent_id"); ?>:</span> 
        <span class="cell">
            <a href="javascript: void()"><?php echo TPL::getVar("info.parent_id"); ?></a>
        </span>
    </div>
    <?php } ?>
    <?php } ?>
        
    <div class="row">
        <span class="cell"><?php echo TPL::getVar("phrases.main.common.info_sort_number"); ?>:</span> 
        <span class="cell"><?php echo TPL::getVar("info.sort_order"); ?></span>
    </div>

    <?php if(TPL::getVar("info.module_info.multilng")){ ?>
    <div class="row">
        <span class="cell"><?php echo TPL::getVar("phrases.main.common.info_languages_saved"); ?>:</span> 
        <span class="cell">
            <?php $item_lng_status_iterator=1; foreach(TPL::getLoop("item_lng_status") as $item_lng_status_key => $item_lng_status_val){ if(!is_array($item_lng_status_val)){ $tmp_val=$item_lng_status_val; $item_lng_status_val=array(); $item_lng_status_val['_VALUE']=$tmp_val; } $item_lng_status_val['_FIRST']=0; if($item_lng_status_iterator==1) $item_lng_status_val['_FIRST']=1; if($item_lng_status_iterator%2==1) $item_lng_status_val['_EVEN']=0; else $item_lng_status_val['_EVEN']=1; $item_lng_status_val['_INDEX']=$item_lng_status_iterator++; $item_lng_status_val['_KEY']=$item_lng_status_key; ?>
            <label><input type="checkbox" disabled <?php if(isset($item_lng_status_val["disabled"]) && $item_lng_status_val["disabled"]){ ?>checked<?php } ?>><?php if(isset($item_lng_status_val["_KEY"])) echo $item_lng_status_val["_KEY"]; ?></label>
            <?php } ?>
        </span>
    </div>
    <?php } ?>
    
    <?php $info_extra_iterator=1; foreach(TPL::getLoop("info_extra") as $info_extra_key => $info_extra_val){ if(!is_array($info_extra_val)){ $tmp_val=$info_extra_val; $info_extra_val=array(); $info_extra_val['_VALUE']=$tmp_val; } $info_extra_val['_FIRST']=0; if($info_extra_iterator==1) $info_extra_val['_FIRST']=1; if($info_extra_iterator%2==1) $info_extra_val['_EVEN']=0; else $info_extra_val['_EVEN']=1; $info_extra_val['_INDEX']=$info_extra_iterator++; $info_extra_val['_KEY']=$info_extra_key; ?>
    <div class="row">
        <span class="cell"><?php if(isset($info_extra_val["title"])) echo $info_extra_val["title"]; ?>:</span> 
        <span class="cell"><?php if(isset($info_extra_val["value"])) echo $info_extra_val["value"]; ?></span>
    </div>
    <?php } ?>
        
</fieldset>
    
<fieldset class="formElementsField table action_info">
    
    <legend><?php echo TPL::getVar("phrases.main.common.info_created"); ?></legend>
    
    <div class="row">
        <span class="cell"><?php echo TPL::getVar("phrases.main.common.info_created_date"); ?>:</span> 
        <span class="cell"><?php echo TPL::getVar("info.create_date"); ?></span>
    </div>

    <?php if(TPL::getVar("info.create_by_admin.title")){ ?>
    <div class="row">
        <span class="cell"><?php echo TPL::getVar("phrases.main.common.info_created_by"); ?>:</span> 
        <span class="cell"><?php echo TPL::getVar("info.create_by_admin.title"); ?></span>
    </div>
    <?php } ?>

    <div class="row">
        <span class="cell"><?php echo TPL::getVar("phrases.main.common.info_created_ip"); ?>:</span> 
        <span class="cell"><?php echo TPL::getVar("info.create_by_ip"); ?></span>
    </div>

</fieldset>

<fieldset class="formElementsField table action_info">
    
    <legend><?php echo TPL::getVar("phrases.main.common.info_updated"); ?></legend>
    
    <div class="row">
        <span class="cell"><?php echo TPL::getVar("phrases.main.common.info_updated_date"); ?>:</span> 
        <span class="cell"><?php echo TPL::getVar("info.last_modif_date"); ?></span>
    </div>

    <?php if(TPL::getVar("info.last_modif_by_admin.title")){ ?>
    <div class="row">
        <span class="cell"><?php echo TPL::getVar("phrases.main.common.info_updated_by"); ?>:</span> 
        <span class="cell"><?php echo TPL::getVar("info.last_modif_by_admin.title"); ?></span>
    </div>
    <?php } ?>

    <div class="row">
        <span class="cell"><?php echo TPL::getVar("phrases.main.common.info_updated_ip"); ?>:</span> 
        <span class="cell"><?php echo TPL::getVar("info.last_modif_by_ip"); ?></span>
    </div>
    
</fieldset>