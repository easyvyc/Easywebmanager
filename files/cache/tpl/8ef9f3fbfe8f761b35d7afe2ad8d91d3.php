<?php $list_iterator=1; foreach(TPL::getLoop("list") as $list_key => $list_val){ if(!is_array($list_val)){ $tmp_val=$list_val; $list_val=array(); $list_val['_VALUE']=$tmp_val; } $list_val['_FIRST']=0; if($list_iterator==1) $list_val['_FIRST']=1; if($list_iterator%2==1) $list_val['_EVEN']=0; else $list_val['_EVEN']=1; $list_val['_INDEX']=$list_iterator++; $list_val['_KEY']=$list_key; ?>
<label class="table" style="float:left;width:170px;">
    <div class="cell" style="width:10px;">
        <input type='checkbox' name='<?php echo TPL::getVar("elm.column_name"); ?>[]' value='<?php if(isset($list_val["id"])) echo $list_val["id"]; ?>' class='FRM <?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?>' <?php if(isset($list_val["selected"]) && $list_val["selected"]){ ?>checked<?php } ?> <?php if(isset($list_val["readonly"]) && $list_val["readonly"]){ ?>disabled<?php } ?> <?php if(isset($list_val["field_extra_params"])) echo $list_val["field_extra_params"]; ?>>
    </div>
    <div class="cell">
        <span style="vertical-align:top;<?php if(isset($list_val["readonly"]) && $list_val["readonly"]){ ?>color:#AAA;<?php } ?>"><?php if(isset($list_val["title"])) echo $list_val["title"]; ?></span>
    </div>
</label>
<?php } ?>
