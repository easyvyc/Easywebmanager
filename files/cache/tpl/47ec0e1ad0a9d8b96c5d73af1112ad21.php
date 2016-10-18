<?php if(TPL::getVar("inner_menu")){ ?>
<nav id="inner_menu">

    <ul>
        <?php $inner_menu_iterator=1; foreach(TPL::getLoop("inner_menu") as $inner_menu_key => $inner_menu_val){ if(!is_array($inner_menu_val)){ $tmp_val=$inner_menu_val; $inner_menu_val=array(); $inner_menu_val['_VALUE']=$tmp_val; } $inner_menu_val['_FIRST']=0; if($inner_menu_iterator==1) $inner_menu_val['_FIRST']=1; if($inner_menu_iterator%2==1) $inner_menu_val['_EVEN']=0; else $inner_menu_val['_EVEN']=1; $inner_menu_val['_INDEX']=$inner_menu_iterator++; $inner_menu_val['_KEY']=$inner_menu_key; ?>
        <li class="mn_<?php if(isset($inner_menu_val["template"])) echo $inner_menu_val["template"]; ?> <?php if(isset($inner_menu_val["selected"]) && $inner_menu_val["selected"]){ ?>a<?php } ?>">

            <a href="<?php echo TPL::getVar("lng"); ?><?php if(isset($inner_menu_val["page_url"])) echo $inner_menu_val["page_url"]; ?>" title="<?php if(isset($inner_menu_val["page_title"])) echo $inner_menu_val["page_title"]; ?>"><?php if(isset($inner_menu_val["title"])) echo $inner_menu_val["title"]; ?></a>

            <?php if(isset($inner_menu_val["selected"]) && $inner_menu_val["selected"]){ ?>
            <?php if(isset($inner_menu_val["sub"]) && $inner_menu_val["sub"]){ ?>
            <ul>
                <?php $inner_menu_sub_iterator=1; if(isset($inner_menu_val["sub"])){ foreach($inner_menu_val["sub"] as $inner_menu_sub_key => $inner_menu_sub_val){ if(!is_array($inner_menu_sub_val)){ $tmp_val=$inner_menu_sub_val; $inner_menu_sub_val=array(); $inner_menu_sub_val['_VALUE']=$tmp_val; } $inner_menu_sub_val['_FIRST']=0; if($inner_menu_sub_iterator==1) $inner_menu_sub_val['_FIRST']=1; if($inner_menu_sub_iterator%2==1) $inner_menu_sub_val['_EVEN']=0; else $inner_menu_sub_val['_EVEN']=1; $inner_menu_sub_val['_INDEX']=$inner_menu_sub_iterator++; $inner_menu_sub_val['_KEY']=$inner_menu_sub_key;  ?>
                <li class="<?php if(isset($inner_menu_sub_val["selected"]) && $inner_menu_sub_val["selected"]){ ?>a<?php } ?>">
                    <a href="<?php echo TPL::getVar("lng"); ?><?php if(isset($inner_menu_sub_val["page_url"])) echo $inner_menu_sub_val["page_url"]; ?>" title="<?php if(isset($inner_menu_sub_val["page_title"])) echo $inner_menu_sub_val["page_title"]; ?>"><?php if(isset($inner_menu_sub_val["title"])) echo $inner_menu_sub_val["title"]; ?></a>

                    <?php if(isset($inner_menu_sub_val["selected"]) && $inner_menu_sub_val["selected"]){ ?>
                    <?php if(isset($inner_menu_sub_val["sub"]) && $inner_menu_sub_val["sub"]){ ?>
                    <ul>
                        <?php $inner_menu_sub_sub_iterator=1; if(isset($inner_menu_sub_val["sub"])){ foreach($inner_menu_sub_val["sub"] as $inner_menu_sub_sub_key => $inner_menu_sub_sub_val){ if(!is_array($inner_menu_sub_sub_val)){ $tmp_val=$inner_menu_sub_sub_val; $inner_menu_sub_sub_val=array(); $inner_menu_sub_sub_val['_VALUE']=$tmp_val; } $inner_menu_sub_sub_val['_FIRST']=0; if($inner_menu_sub_sub_iterator==1) $inner_menu_sub_sub_val['_FIRST']=1; if($inner_menu_sub_sub_iterator%2==1) $inner_menu_sub_sub_val['_EVEN']=0; else $inner_menu_sub_sub_val['_EVEN']=1; $inner_menu_sub_sub_val['_INDEX']=$inner_menu_sub_sub_iterator++; $inner_menu_sub_sub_val['_KEY']=$inner_menu_sub_sub_key;  ?>
                        <li class="<?php if(isset($inner_menu_sub_sub_val["selected"]) && $inner_menu_sub_sub_val["selected"]){ ?>a<?php } ?>"><a href="<?php echo TPL::getVar("lng"); ?><?php if(isset($inner_menu_sub_sub_val["page_url"])) echo $inner_menu_sub_sub_val["page_url"]; ?>" title="<?php if(isset($inner_menu_sub_sub_val["page_title"])) echo $inner_menu_sub_sub_val["page_title"]; ?>"><?php if(isset($inner_menu_sub_sub_val["title"])) echo $inner_menu_sub_sub_val["title"]; ?></a></li>
                        <?php }} ?>
                    </ul>
                    <?php } ?>
                    <?php } ?>

                </li>
                <?php }} ?>
            </ul>
            <?php } ?>
            <?php } ?>

        </li>
        <?php } ?>
    </ul>
    &nbsp;
    
    <?php if(TPL::getVar("show_filters")){ ?>
        
    <link href="site/js/nouislider/jquery.nouislider.min.css" rel="stylesheet">
    <link href="site/js/nouislider/jquery.nouislider.pips.min.css" rel="stylesheet">
    <script src="site/js/nouislider/jquery.nouislider.all.js"></script>

    <div class="products-filters-form">
    <h3><?php echo TPL::getVar("phrases.product_filter_title"); ?></h3>
    <form action="<?php echo TPL::getVar("lng"); ?><?php echo TPL::getVar("page_data.page_url"); ?>" method="get">
        
        <script>
            $(document).ready(function(){
                $('#filters_price_range').noUiSlider({
                        start: [ <?php if(TPL::getVar("form_filters.price.min")){ ?><?php echo TPL::getVar("form_filters.price.min"); ?><?php } ?><?php if(!TPL::getVar("form_filters.price.min")){ ?><?php echo TPL::getVar("main_filters_data.min_price"); ?><?php } ?>, <?php if(TPL::getVar("form_filters.price.max")){ ?><?php echo TPL::getVar("form_filters.price.max"); ?><?php } ?><?php if(!TPL::getVar("form_filters.price.max")){ ?><?php echo TPL::getVar("main_filters_data.max_price"); ?><?php } ?> ],
                        connect: true,
                        step:1,
                        range: {
                                'min': <?php echo TPL::getVar("main_filters_data.min_price"); ?>,
                                'max': <?php echo TPL::getVar("main_filters_data.max_price"); ?>
                        }
                });
                
                $("#filters_price_range").Link('lower').to($("#filters_price_range_min"));
                $("#filters_price_range").Link('upper').to($("#filters_price_range_max"));

                $('#filters_price_range').noUiSlider_pips({
                        <?php if(!TPL::getVar("main_filters_data.range_values.v1")){ ?>
                        mode: 'count',
                        values: 5,
                        <?php } ?>
                        <?php if(TPL::getVar("main_filters_data.range_values.v1")){ ?>
                        mode: 'values',
                        values: [<?php echo TPL::getVar("main_filters_data.range_values.v1"); ?>,<?php echo TPL::getVar("main_filters_data.range_values.v2"); ?>,<?php echo TPL::getVar("main_filters_data.range_values.v3"); ?>,<?php echo TPL::getVar("main_filters_data.range_values.v4"); ?>,<?php echo TPL::getVar("main_filters_data.range_values.v5"); ?>],
                        <?php } ?>
                        density: 5,
                        stepped: true
                });
                
            });
        </script>
        
        <div class="range_filter">
            <b><?php echo TPL::getVar("phrases.filter_by_price"); ?></b>
            <div id="filters_price_range"></div>
            <input type="hidden" id="filters_price_range_min" name="filter[price][min]" value="">
            <input type="hidden" id="filters_price_range_max" name="filter[price][max]" value="">
        </div>
        
        <?php $filters_iterator=1; foreach(TPL::getLoop("filters") as $filters_key => $filters_val){ if(!is_array($filters_val)){ $tmp_val=$filters_val; $filters_val=array(); $filters_val['_VALUE']=$tmp_val; } $filters_val['_FIRST']=0; if($filters_iterator==1) $filters_val['_FIRST']=1; if($filters_iterator%2==1) $filters_val['_EVEN']=0; else $filters_val['_EVEN']=1; $filters_val['_INDEX']=$filters_iterator++; $filters_val['_KEY']=$filters_key; ?>
        
        <?php if(isset($filters_val["use_filter_range"]) && $filters_val["use_filter_range"]){ ?>
        <script>
            $(document).ready(function(){
                $('#filters_<?php if(isset($filters_val["id"])) echo $filters_val["id"]; ?>_range').noUiSlider({
                        start: [ <?php if(isset($filters_val["min_value_rng"])) echo $filters_val["min_value_rng"]; ?>, <?php if(isset($filters_val["max_value_rng"])) echo $filters_val["max_value_rng"]; ?> ],
                        connect: true,
                        step:1,
                        range: {
                                'min': <?php if(isset($filters_val["min_value"])) echo $filters_val["min_value"]; ?>,
                                'max': <?php if(isset($filters_val["max_value"])) echo $filters_val["max_value"]; ?>
                        }
                });
                
                $("#filters_<?php if(isset($filters_val["id"])) echo $filters_val["id"]; ?>_range").Link('lower').to($("#filters_<?php if(isset($filters_val["id"])) echo $filters_val["id"]; ?>_range_min"));
                $("#filters_<?php if(isset($filters_val["id"])) echo $filters_val["id"]; ?>_range").Link('upper').to($("#filters_<?php if(isset($filters_val["id"])) echo $filters_val["id"]; ?>_range_max"));

                $('#filters_<?php if(isset($filters_val["id"])) echo $filters_val["id"]; ?>_range').noUiSlider_pips({
                        mode: 'count',
                        values: 5,
                        density: 5,
                        stepped: true
                });
                
            });
        </script>
        <div class="range_filter">
            <b><?php if(isset($filters_val["title"])) echo $filters_val["title"]; ?></b>
            <div id="filters_<?php if(isset($filters_val["id"])) echo $filters_val["id"]; ?>_range"></div>
            <input type="hidden" id="filters_<?php if(isset($filters_val["id"])) echo $filters_val["id"]; ?>_range_min" name="filter[<?php if(isset($filters_val["id"])) echo $filters_val["id"]; ?>][min]" value="">
            <input type="hidden" id="filters_<?php if(isset($filters_val["id"])) echo $filters_val["id"]; ?>_range_max" name="filter[<?php if(isset($filters_val["id"])) echo $filters_val["id"]; ?>][max]" value="">
        </div>            
        <?php } ?>
        
        <?php if(isset($filters_val["use_filter_select"]) && $filters_val["use_filter_select"]){ ?>
        <?php if(isset($filters_val["options"]) && $filters_val["options"]){ ?>
        <select name="filter[<?php if(isset($filters_val["id"])) echo $filters_val["id"]; ?>]" id="form_filter_<?php if(isset($filters_val["id"])) echo $filters_val["id"]; ?>">
            <option value="">--<?php if(isset($filters_val["title"])) echo $filters_val["title"]; ?>--</option>
            <?php $filters_options_iterator=1; if(isset($filters_val["options"])){ foreach($filters_val["options"] as $filters_options_key => $filters_options_val){ if(!is_array($filters_options_val)){ $tmp_val=$filters_options_val; $filters_options_val=array(); $filters_options_val['_VALUE']=$tmp_val; } $filters_options_val['_FIRST']=0; if($filters_options_iterator==1) $filters_options_val['_FIRST']=1; if($filters_options_iterator%2==1) $filters_options_val['_EVEN']=0; else $filters_options_val['_EVEN']=1; $filters_options_val['_INDEX']=$filters_options_iterator++; $filters_options_val['_KEY']=$filters_options_key;  ?>
            <option value="<?php if(isset($filters_options_val["id"])) echo $filters_options_val["id"]; ?>"><?php if(isset($filters_options_val["title"])) echo $filters_options_val["title"]; ?></option>
            <?php }} ?>
        </select>&nbsp;&nbsp;
        <?php } ?>
        <?php } ?>

        <?php if(isset($filters_val["use_filter_checkbox"]) && $filters_val["use_filter_checkbox"]){ ?>
        <?php if(isset($filters_val["options"]) && $filters_val["options"]){ ?>
        <div class="filter_checkbox">
            <b><?php if(isset($filters_val["title"])) echo $filters_val["title"]; ?></b>
            <?php $filters_options_iterator=1; if(isset($filters_val["options"])){ foreach($filters_val["options"] as $filters_options_key => $filters_options_val){ if(!is_array($filters_options_val)){ $tmp_val=$filters_options_val; $filters_options_val=array(); $filters_options_val['_VALUE']=$tmp_val; } $filters_options_val['_FIRST']=0; if($filters_options_iterator==1) $filters_options_val['_FIRST']=1; if($filters_options_iterator%2==1) $filters_options_val['_EVEN']=0; else $filters_options_val['_EVEN']=1; $filters_options_val['_INDEX']=$filters_options_iterator++; $filters_options_val['_KEY']=$filters_options_key;  ?>
            <?php if(isset($filters_options_val["id"]) && $filters_options_val["id"]){ ?>
            <label><input type="checkbox" name="filter[<?php if(isset($filters_val["id"])) echo $filters_val["id"]; ?>][]" value="<?php if(isset($filters_options_val["id"])) echo $filters_options_val["id"]; ?>" <?php if(isset($filters_options_val["selected"]) && $filters_options_val["selected"]){ ?>checked<?php } ?> /> <?php if(isset($filters_options_val["title"])) echo $filters_options_val["title"]; ?></label>
            <?php } ?>
            <?php }} ?>
        </div>
        <?php } ?>
        <?php } ?>
        
        <?php } ?>
        <input type="submit" class="btn" value="<?php echo TPL::getVar("phrases.submit_filters"); ?>">
    </form>
    </div>
    
    <?php if(TPL::getVar("form_filters")){ ?>
    <script>
    $(document).ready(function(){
        <?php $form_filters_iterator=1; foreach(TPL::getLoop("form_filters") as $form_filters_key => $form_filters_val){ if(!is_array($form_filters_val)){ $tmp_val=$form_filters_val; $form_filters_val=array(); $form_filters_val['_VALUE']=$tmp_val; } $form_filters_val['_FIRST']=0; if($form_filters_iterator==1) $form_filters_val['_FIRST']=1; if($form_filters_iterator%2==1) $form_filters_val['_EVEN']=0; else $form_filters_val['_EVEN']=1; $form_filters_val['_INDEX']=$form_filters_iterator++; $form_filters_val['_KEY']=$form_filters_key; ?>
        $('#form_filter_<?php if(isset($form_filters_val["_KEY"])) echo $form_filters_val["_KEY"]; ?>').val('<?php if(isset($form_filters_val["_VALUE"])) echo $form_filters_val["_VALUE"]; ?>');
        <?php } ?>
    });
    </script>
    <?php } ?>
        
    <?php } ?>
    
</nav>
<?php } ?>