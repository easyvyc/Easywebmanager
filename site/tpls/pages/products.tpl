                <div id="bodyContent" class="grid_39 push_9 "><div>
                

<div class="title-t">
	<div class="title-b">
		<div class="title-icon"></div>
		<h1 class="cl_both "><a>{category.title}</a></h1>
	</div>
</div>
<div class="contentContainer">
  <div class="contentPadd">
    <div class="prods_content prods_table">
    <ul class="row_featured_name" id="row_featured-0">
    
    {loop products}
    <li style="width:178px;" class="wrapper_prods equal-height_featured_block hover">
    <div class="border_prods">		
   		<div class="pic_padd wrapper_pic_div" style="width:178px;height:216px;">
		    <a href="{lng}/products/info/{products.url}-{products.id}.html">
		    	<img src="{crm_url}primg.php?id={products.id}&column=images&w=178&h=216&t=0" alt="{products.title}" title="{products.title}" />
		    </a>
			<div class="wrapper_pic_t" style="width:178px;height:216px;">
				<div class="wrapper_pic_r" style="width:178px;height:216px;">
					<div class="wrapper_pic_b" style="width:178px;height:216px;">
						<div class="wrapper_pic_l" style="width:178px;height:216px;">
							<div class="wrapper_pic_tl" style="width:178px;height:216px;">
								<div class="wrapper_pic_tr" style="width:178px;height:216px;">
									<div class="wrapper_pic_bl" style="width:178px;height:216px;">
										<div class="wrapper_pic_br" style="width:178px;height:216px;"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
		<div class="prods_padd">		
			<div class="name name_padd equal-height_featured_name">
				<span><a href="{lng}/products/list/{products.url}-{products.id}.html">{products.title}</a></span>&nbsp;
				<a href="{lng}/products/list/{products.url}-{products.id}.html">{products.code}</a>
			</div>
			<div class="price price_padd"><b>Kaina:&nbsp;&nbsp;</b><span class="productSpecialPrice">{products.price}</span></div>
			<div class="button__padd">
				<div class="button_content button_content22">
					<div class="button bg_button">
						<div class="button-t">
							<a href="{lng}/products/info/{products.url}-{products.id}.html" id="tdb1" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-secondary" role="button"><span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-e"></span><span class="ui-button-text">Daugiau</span></a>
						</div>
					</div>
				</div>&nbsp;
				<!-- div class="button_content button_content2">
					<div class="button bg_button">
						<div class="button-t">
							<a href="http://livedemo00.template-help.com/osc_36712/products_new.php?action=buy_now&amp;products_id=41" id="tdb1" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary ui-priority-secondary" role="button"><span class="ui-button-icon-primary ui-icon ui-icon-cart"></span><span class="ui-button-text">Add&nbsp;to&nbsp;Cart</span></a>
						</div>
					</div>
				</div-->
			</div>
		</div>
	</div>
	</li>
	{-loop products}

</ul>

<div class="paging">
{loop paging}
<a href="{lng}/products/list/{category.url}-{category.record_id}.html?offset={paging.value}" {block paging.active}class="a"{-block paging.active}>{paging.title}</a>
{-loop paging}
</div>

</div>  
</div>
</div>


                	</div>
                </div>
			 <!-- bodyContent //-->