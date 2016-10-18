<table id="order_steps" align="center">
        <tr>
	<?php $steps_iterator=1; foreach(TPL::getLoop("steps") as $steps_key => $steps_val){ if(!is_array($steps_val)){ $tmp_val=$steps_val; $steps_val=array(); $steps_val['_VALUE']=$tmp_val; } $steps_val['_FIRST']=0; if($steps_iterator==1) $steps_val['_FIRST']=1; if($steps_iterator%2==1) $steps_val['_EVEN']=0; else $steps_val['_EVEN']=1; $steps_val['_INDEX']=$steps_iterator++; $steps_val['_KEY']=$steps_key; ?>
	<td class="step step_<?php if(isset($steps_val["_INDEX"])) echo $steps_val["_INDEX"]; ?><?php if(isset($steps_val["complited"]) && $steps_val["complited"]){ ?>_a<?php } ?><?php if(isset($steps_val["active"]) && $steps_val["active"]){ ?> a<?php } ?>">
		<span class="img"><?php if(isset($steps_val["_INDEX"])) echo $steps_val["_INDEX"]; ?></span> <?php if(isset($steps_val["title"])) echo $steps_val["title"]; ?>
	</td>
	<?php } ?>
        </tr>
</table>