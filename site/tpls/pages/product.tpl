                <div id="bodyContent" class="grid_39 push_9 "><div>
                
<form name="cart_quantity" >
<div class="contentContainer">
  <div class="contentPadd prods_info_page">
	<div class="prods_info decks big">
		<div class="forecastle">
		<ol class="masthead">
			  <li class="port_side left_side_pic-1">
	  
   			 	<div style="width:230px;" class="hover">
          <div id="piGal" class="wrapper_pic_div fl_left" style="width:220px;height:266px;">
          	<a class="prods_pic_bg" href="{crm_url}primg.php?id={product.record_id}&column=images&w=800&h=700&t=0" target="_blank" rel="fancybox">
          		<img src="{crm_url}primg.php?id={product.record_id}&column=images&w=220&h=266&t=0" alt="{product.title}" title="{product.title}" style="margin:0px 0px 0px 0px;" />
			<div class="wrapper_pic_t" style="width:220px;height:266px;">
				<div class="wrapper_pic_r" style="width:220px;height:266px;">
					<div class="wrapper_pic_b" style="width:220px;height:266px;">
						<div class="wrapper_pic_l" style="width:220px;height:266px;">
							<div class="wrapper_pic_tl" style="width:220px;height:266px;">
								<div class="wrapper_pic_tr" style="width:220px;height:266px;">
									<div class="wrapper_pic_bl" style="width:220px;height:266px;">
										<div class="wrapper_pic_br" style="width:220px;height:266px;">
											<div class="wrapper_pic_zoom" style="width:220px;height:266px;"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
</a></div>        
    			</div>
<script type="text/javascript">
    $("#piGal a[rel^='fancybox']").fancybox({
      cyclic: true
    });
    </script>				
    <div class="bookmarks">
<div class="infoBoxWrapper" style="width:220px;">
	<div class="box_wrapper">  
		<div class="infoBoxHeading prod_page">
			<div class="title-icon"></div>Kontaktai
		</div>  
		<div class="infoBoxContents">
			<table border="0" width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top">-&nbsp;</td>
					<td valign="top">{product.contact.firstname} {product.contact.lastname}</td>
				</tr>
				<tr>
					<td valign="top">-&nbsp;</td>
					<td valign="top"><a href="mailto:{product.contact.email}">{product.contact.email}</a></td>
				</tr>
				<tr>
					<td valign="top">-&nbsp;</td>
					<td valign="top">{product.contact.phone}</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<div class="infoBoxWrapper" style="width:220px;">
	<div class="box_wrapper">  
		<div class="infoBoxHeading prod_page"><div class="title-icon"></div>Pasiūlykite draugams
	</div>  
	<div class="infoBoxContents">
		<!-- a href="http://livedemo00.template-help.com/osc_36712/tell_a_friend.php?products_id=43?osCsid=2o9u6pquv7ubvfrr4r8us83go1">
			<img src="images/social_bookmarks/email.png" border="0" title="Share via E-Mail" alt="Share via E-Mail" />
		</a--> 
		<a href="http://www.facebook.com/share.php?u={encoded_product_url}" target="_blank">
			<img src="site/images/social/facebook.png" border="0" title="Share on Facebook" alt="Share on Facebook" />
		</a> 
		<a href="http://twitter.com/home?status={encoded_product_url}" target="_blank">
			<img src="site/images/social/twitter.png" border="0" title="Share on Twitter" alt="Share on Twitter" />
		</a> 
		<a href="http://www.google.com/buzz/post?url={encoded_product_url}" target="_blank">
			<img src="site/images/social/google_buzz.png" border="0" title="Share on Google Buzz" alt="Share on Google Buzz" />
		</a> 
		<a href="http://digg.com/submit?url={encoded_product_url}" target="_blank">
			<img src="site/images/social/digg.png" border="0" title="Share on Digg" alt="Share on Digg"/>
		</a> 
		<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script><g:plusone size="small"  class="fl_feft"></g:plusone>
</div>
</div>
</div>				</div>		
              </li>
			  <li class="starboard_side right_side_pic-1">
  		
  		
  		<div class="prod_info_next">
          <div class="fl_left">
          	<div class="button_content button_content22">
          		<div class="button bg_button">
          			{block prev.id}
          			<div class="button-t">
          				<span class="tdbLink"><a id="tdb1" href="{lng}/products/info/{prev.url}-{prev.id}.html">Ankstesnis</a></span>
          			<script type="text/javascript">$("#tdb1").button({icons:{primary:"ui-icon-arrowthick-1-w"}}).addClass("ui-priority-secondary").parent().removeClass("tdbLink");</script>
          			</div>
          			{-block prev.id}
          		</div>
          	</div>
          </div>
          
          <div class="fl_right button_next">
          	<div class="button_content button_content22">
          		<div class="button bg_button">
          			{block next.id}
          			<div class="button-t">
          				<span class="tdbLink"><a id="tdb2" href="{lng}/products/info/{next.url}-{next.id}.html">Sekantis</a></span>
          				<script type="text/javascript">$("#tdb2").button({icons:{primary:"ui-icon-arrowthick-1-e"}}).addClass("ui-priority-secondary").parent().removeClass("tdbLink");</script>
          			</div>
          			{-block next.id}
          		</div>
          	</div>
          </div>
          
          <div class="prod_next">Produktas&nbsp;<strong><u>{product_number_in_list}</u></strong> iš <strong>{products_count}</strong> </div>
       	</div>
              
    				<div class="info">
		
                        <div class="data data_padd small_title">Šis produktas patalpintas {product.create_date}.</div>
                        <br />
                        <h2>{product.title}<br /><span class="smallText">[{product.product_code}]</span></h2>
                        <h2 class="price">
	                        <b>Kaina:&nbsp;&nbsp;</b> <span class="productSpecialPrice fl_left">{product.price} LTL</span> 
	                        <!-- del class="fl_left">$49.99</del-->
                        </h2>
            			<div class="desc desc_padd">{product.description}</div>
    
    
                        <!-- div class="buttonSet">
                            <span class="buttonAction"><div class="button_content button_content22"><div class="button bg_button"><div class="button-t"><span class="tdbLink"><a id="tdb3" href="http://livedemo00.template-help.com/osc_36712/product_reviews.php?products_id=43%3FosCsid%3D2o9u6pquv7ubvfrr4r8us83go1">Reviews</a></span><script type="text/javascript">$("#tdb3").button({icons:{primary:"ui-icon-comment"}}).addClass("ui-priority-secondary").parent().removeClass("tdbLink");</script></div></div></div></span>
                
                            <div class="fl_right" align="right"><div class="button_content button_content2"><div class="button bg_button"><div class="button-t"><input type="hidden" name="products_id" value="43" /><span class="tdbLink"><button id="tdb4" type="submit">Add&nbsp;to&nbsp;Cart</button></span><script type="text/javascript">$("#tdb4").button({icons:{primary:"ui-icon-cart"}}).addClass("ui-priority-primary").parent().removeClass("tdbLink");</script></div></div></div></div>
                        </div-->
                        
        			</div> 
              </li>
		</ol>
		</div>	
	</div>
    
    </div>
</div>
           
</form>

                	</div>
                </div>
			 <!-- bodyContent //-->