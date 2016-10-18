                <div id="bodyContent" class="grid_39 push_9 "><div>
                

<div class="title-t">
	<div class="title-b">
		<div class="title-icon"></div>
		<h1 class="cl_both "><a>Detali paieška</a></h1>
	</div>
</div>


<form name="advanced_search" action="{lng}/search/advanced/" method="get" onsubmit="return check_form(this);">

<input type="hidden" name="a" value="search" />

<div class="contentContainer">
  <div class="contentPadd">
  
  <h3>Paieškos kriterijai</h3>

  <div class="contentInfoText">

    <table border="0" width="100%" cellspacing="0" cellpadding="2">

      <tr>
        <td class="fieldKey"><div class="crosspiece100"></div>Paieškos frazė:</td>
        <td class="fieldValue" width="100%">
        	<input type="text" name="q" class="input" value="{get.q}" />
        </td>
      </tr>
      
      <tr>
        <td class="fieldKey"><div class="crosspiece100"></div>Kategorija:</td>
        <td class="fieldValue" width="100%">
        	<select name="cat"  class="input">
        		
        		<option value="" selected="selected">Visos kategorijos</option>
        		
        		{loop pr_menu}
        		<option value="{pr_menu.record_id}">{pr_menu.title}</option>
        		{-loop pr_menu}
        		
        	</select>
        
        {block get.cat}
        <script type="text/javascript">
		$('select[name=cat]').val({get.cat});
        </script>
        {-block get.cat}
        	
        </td>
      </tr>
      <tr>
        <td class="fieldKey">Kaina nuo:</td>
        <td class="fieldValue"><input type="text" name="pfrom" class="input" value="{get.pfrom}" /></td>
      </tr>
      <tr>
        <td class="fieldKey">Kaina iki:</td>
        <td class="fieldValue"><input type="text" name="pto" class="input" value="{get.pto}" /></td>
      </tr>
      <tr>
        <td class="fieldKey ">Data nuo:</td>
        <td class="fieldValue"><input type="text" name="dfrom" id="dfrom" class="input" value="{get.dfrom}" /><script type="text/javascript">jQuery(document).ready(function () {$('#dfrom').datepicker({dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, yearRange: '-20:+0'});});</script></td>
      </tr>
      <tr>
        <td class="fieldKey">Data iki:</td>
        <td class="fieldValue"><input type="text" name="dto" id="dto" class="input" value="{get.dto}" /><script type="text/javascript">jQuery(document).ready(function () {$('#dto').datepicker({dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, yearRange: '-20:+0'});});</script></td>
      </tr>
    </table>
	</div>


    <div class="buttonSet">
    {block no}
      <span><a href="#" target="_blank" onclick="$('#helpSearch').dialog('open'); return false;"><u>Paieškos pagalba</u> [?]</a></span>
    {-block no}
      <span style="float: right;"><div class="button_content button_content2"><div class="button bg_button"><div class="button-t"><span class="tdbLink"><button id="tdb1" type="submit">Search</button></span><script type="text/javascript">$("#tdb1").button({icons:{primary:"ui-icon-search"}}).addClass("ui-priority-primary").parent().removeClass("tdbLink");</script></div></div></div></span>
    </div>

	
    <div id="helpSearch" title="Search Help">
      <p>Keywords may be separated by AND and/or OR statements for greater control of the search results.<br /><br />For example, <u>Microsoft AND mouse</u> would generate a result set that contain both words. However, for <u>mouse OR keyboard</u>, the result set returned would contain both or either words.<br /><br />Exact matches can be searched for by enclosing keywords in double-quotes.<br /><br />For example, <u>"notebook computer"</u> would generate a result set which match the exact string.<br /><br />Brackets can be used for further control on the result set.<br /><br />For example, <u>Microsoft and (keyboard or mouse or "visual basic")</u>.</p>
    </div>
<script type="text/javascript">
	jQuery(document).ready(function () {$('#helpSearch').dialog({
	  autoOpen: false,
	  buttons: {
		Ok: function() {
		  $(this).dialog('close');
		}
	  }
	});});
</script>
  </div>

</div>
</form>

<div style="clear:both"></div>

<div class="contentContainer">
  <div class="contentPadd">
    <div class="prods_content prods_table">
    
    
		{block no_results}
		Nieko nerasta. Patikslinkite paiešką.
		{-block no_results}
		
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
<a href="{lng}/search/advanced/?a=search&q={get.q}&cat={get.cat}&pfrom={get.pfrom}&pto={get.pto}&dfrom={get.dfrom}&dto={get.dto}&offset={paging.value}" {block paging.active}class="a"{-block paging.active}>{paging.title}</a>
{-loop paging}
</div>

</div>  
</div>
</div>


                	</div>
                </div>
			 <!-- bodyContent //-->