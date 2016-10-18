<div id="id_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.name"); ?>" class="formElementsField <?php echo TPL::getVar("elm.style"); ?>">
    <div class="t">
        <span class=""><?php echo TPL::getVar("elm.title"); ?>:<?php if(TPL::getVar("elm.required")){ ?>*<?php } ?></span>
        <span class="mini"><?php echo TPL::getVar("phrases.autocomplete_field_text"); ?></span>
        <?php if(TPL::getVar("elm.show_error")){ ?><span class="error_message"><?php echo TPL::getVar("elm.error_message"); ?></span><?php } ?>
    </div>
    <div class="e">

        <div id="autocomplete_<?php echo TPL::getVar("elm.name"); ?>" data-multiple="<?php echo TPL::getVar("elm.list_values.multiple"); ?>">
            
        <?php if(!TPL::getVar("elm.list_values.multiple")){ ?>
        <?php if(TPL::getVar("elm.value")){ ?>
        <div id="autocomplete_<?php echo TPL::getVar("elm.name"); ?>_<?php echo TPL::getVar("elm.value"); ?>" class="autocomplete_values">
                <input type="hidden" name="<?php echo TPL::getVar("elm.name"); ?>" value="<?php echo TPL::getVar("elm.value"); ?>">
                <?php if(TPL::getVar("elm.editable")){ ?><a href="javascript: void(eFORM.remove_autocomplete_value('<?php echo TPL::getVar("elm.name"); ?>', <?php echo TPL::getVar("elm.value"); ?>));" class="close">x</a><?php } ?>
                <a><?php echo TPL::getVar("auto_complete_data.label"); ?></a>
        </div>
        <?php } ?>
        <?php } ?>
            
        <?php if(TPL::getVar("elm.list_values.multiple")){ ?>
        <?php $list_iterator=1; foreach(TPL::getLoop("list") as $list_key => $list_val){ if(!is_array($list_val)){ $tmp_val=$list_val; $list_val=array(); $list_val['_VALUE']=$tmp_val; } $list_val['_FIRST']=0; if($list_iterator==1) $list_val['_FIRST']=1; if($list_iterator%2==1) $list_val['_EVEN']=0; else $list_val['_EVEN']=1; $list_val['_INDEX']=$list_iterator++; $list_val['_KEY']=$list_key; ?>
        <div id="autocomplete_<?php echo TPL::getVar("elm.name"); ?>_<?php if(isset($list_val["id"])) echo $list_val["id"]; ?>" class="autocomplete_values">
                <input type="hidden" name="<?php echo TPL::getVar("elm.name"); ?>[]" value="<?php if(isset($list_val["id"])) echo $list_val["id"]; ?>">
                <?php if(TPL::getVar("elm.editable")){ ?><a href="javascript: void(eFORM.remove_autocomplete_value('<?php echo TPL::getVar("elm.name"); ?>', <?php if(isset($list_val["id"])) echo $list_val["id"]; ?>));" class="close">x</a><?php } ?>
                <a><?php if(isset($list_val["label"])) echo $list_val["label"]; ?></a>
        </div>
        <?php } ?>
        <?php } ?>
        
        </div>

        <div>
            <input type='text' id="auto_text_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.column_name"); ?>" value='' class='<?php echo TPL::getVar("style"); ?>_<?php echo TPL::getVar("elm.elm_type"); ?>' <?php if(!TPL::getVar("elm.editable")){ ?>readonly<?php } ?> />
            <?php if(TPL::getVar("elm.list_values.create_new")){ ?>
            <a class="dotted" href="javascript: void($NAV.open_dialog('<?php echo TPL::getVar("elm.list_values.module"); ?>_<?php echo TPL::getVar("elm.column_name"); ?>_<?php echo TPL::getVar("form_data.id"); ?>', '?module=<?php echo TPL::getVar("elm.list_values.module"); ?>&method=create_from_autocomplete&no_tree_reload=1&json=0&multiple=<?php echo TPL::getVar("elm.list_values.multiple"); ?>&column=<?php echo TPL::getVar("elm.column_name"); ?>', '<?php echo TPL::getVar("phrases.main.catalog.new_element"); ?>'));">[ NEW ]</a>
            <?php } ?>
        </div>


        <script type="text/javascript">

            $( "#auto_text_<?php echo TPL::getVar("form_settings.id"); ?>_<?php echo TPL::getVar("elm.column_name"); ?>" )
                // don't navigate away from the field on tab when selecting an item
                .bind( "keydown", function( event ) {
                  if ( event.keyCode === $.ui.keyCode.TAB &&
                      $( this ).autocomplete( "instance" ).menu.active ) {
                    event.preventDefault();
                  }
                })
                .autocomplete({
                  source: function( request, response ) {
                    $.getJSON( "?module=<?php echo TPL::getVar("elm.list_values.module"); ?>&method=<?php if(TPL::getVar("elm.list_values.method")){ ?><?php echo TPL::getVar("elm.list_values.method"); ?><?php } ?><?php if(!TPL::getVar("elm.list_values.method")){ ?>listAutocompleteItems<?php } ?>&columns=<?php echo TPL::getVar("elm.list_values.columns"); ?>&left=1&right=1<?php if(TPL::getVar("elm.list_values.list_title")){ ?>&list_title=<?php echo TPL::getVar("elm.list_values.list_title"); ?><?php } ?>", {
                      term: request.term
                    }, response );
                  },
                  search: function() {
                    // custom minLength
                    if ( this.value < 2 ) {
                      return false;
                    }
                  },
                  focus: function() {
                    // prevent value inserted on focus
                    return false;
                  },
                  select: function( event, ui ) {
                    var terms = this.value;
                    // remove the current input
                    
                    <?php if(!TPL::getVar("elm.list_values.multiple")){ ?>
                    eFORM.clear_autocomplete_value('<?php echo TPL::getVar("elm.name"); ?>');
                    <?php } ?>

                    eFORM.add_autocomplete_value('<?php echo TPL::getVar("elm.name"); ?>', ui.item);
                    
                    this.value = "";
                    return false;
                  }
                
            });

        </script>		

    </div>	
</div>
