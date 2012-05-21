<call code="name=item_data::set=var::module=pages::method=loadPage::params={{page_data.id}}">
<div class="box1">
	<div class="border-top">
		<div class="border-right">
			<div class="border-bot">
				<div class="border-left">
					<div class="left-top-corner">
						<div class="right-top-corner">
							<div class="right-bot-corner">
								<div class="left-bot-corner">
									<div class="inner">
										<h1>{item_data.title}</h1>
										

<block name="get.id">

<call code="name=product_data::set=var::module=products::method=loadItem::params={{get.id}}">

<div class="content">

	<div id="path">
	<loop name="id_path">
	<block name="id_path.first" no>
	&nbsp;&nbsp;»&nbsp;&nbsp;
	</block name="id_path.first" no>
	<a href="{lng}{id_path.page_url}" title="{id_path.page_title}">{id_path.title}</a>
	</loop name="id_path">
	&nbsp;&nbsp;»&nbsp;&nbsp;{product_data.title}
	</div>
	
	<div id="data_text">

<div id="main_img_area">

<div id="main_img" class="radius5" style="background:url('{upload_url}{product_data.image}') center center no-repeat;"></div>

<div id="thumb_img">
<block name="product_data.image">
<div class="thumbs radius3" style="background:url('{upload_url}thumb_{product_data.image}') center center no-repeat;" onclick="javascript: $('#main_img').css('background', 'url({upload_url}{product_data.image}) center center no-repeat');"></div>
</block name="product_data.image">
<block name="product_data.image2">
<div class="thumbs radius5" style="background:url('{upload_url}thumb_{product_data.image2}') center center no-repeat;" onclick="javascript: $('#main_img').css('background', 'url({upload_url}{product_data.image2}) center center no-repeat');"></div>
</block name="product_data.image2">
<block name="product_data.image3">
<div class="thumbs radius5" style="background:url('{upload_url}thumb_{product_data.image3}') center center no-repeat;" onclick="javascript: $('#main_img').css('background', 'url({upload_url}{product_data.image3}) center center no-repeat');"></div>
</block name="product_data.image3">
<block name="product_data.image4">
<div class="thumbs radius5 last" style="background:url('{upload_url}thumb_{product_data.image4}') center center no-repeat;" onclick="javascript: $('#main_img').css('background', 'url({upload_url}{product_data.image4}) center center no-repeat');"></div>
</block name="product_data.image4">
</div>

</div>

	<div class="add2cart">
	<call code="name=modifications::set=loop::module=products::method=getModifData::params={{get.id}}">
	<call code="name=is_modif::set=var::module=products::method=isModif::params={{get.id}}">
	<loop name="modifications">
	<p class="item_modif"><span>{modifications.title}:</span> 
	<select id="select_value_{modifications.column_name}" name="{modifications.column_name}">
		<option value="">{phrases.select_modification}</option>
		<loop name="modifications.select_values">
		<option value="{modifications.select_values.id}">{modifications.select_values.title}</option>
		</loop name="modifications.select_values">
	</select>
	</p>
	</loop name="modifications">
	
	<block name="is_modif">
	<div class="orange">
	<a onclick="javascript: if(modifSelected()) add2cart('{config.site_url}ajax.php?content=cart&add={product_data.id}'+getAllModif()+'&ajax=1', 'cartcontent', before_func, addSuccess); else modif_not_selected('{phrases.please_select_modif}');"><em class="l"></em><b>{phrases.kaip_pirkti}<span>{phrases.kaip_pirkti}</span></b><em class="r"></em></a>
	</div>
	</block name="is_modif">
	
	<block name="is_modif" no>
	<div class="orange">
	<a onclick="javascript: add2cart('{config.site_url}ajax.php?content=cart&add={product_data.id}&ajax=1', 'cartcontent', before_func, addSuccess);"><em class="l"></em><b>{phrases.kaip_pirkti}<span>{phrases.kaip_pirkti}</span></b><em class="r"></em></a>
	</div>
	</block name="is_modif" no>
	</div>
	
	
	<br /><br />
	<p class="item_fields price">{phrases.price}: <b>{product_data.price}</b> <block name="product_data.is_old_price"><span>{product_data.old_price}</span></block name="product_data.is_old_price"></p>
	
	<call code="name=fields::set=loop::module=products::method=getFieldsData::params={{get.id}}">
	<loop name="fields">
	<p class="item_fields">{fields.title}: <b>{fields.value}</b></p>
	</loop name="fields">
	
	
	{product_data.description}

	</div>
	
<div class="clear"></div>	
	
</div>



</block name="get.id">

<block name="get.id" no>

<call code="name=mainitems::set=loop::module=products::method=listCategoryItems::params={{data.id}},{{get.offset}}">
<call code="name=paging::set=loop::module=products::method=pagingItems::params={{get.offset}}">
<call code="name=is_paging::set=var::module=products::method=is_pagingItems::params=">


	<div id="path">
	<loop name="id_path">
	<block name="id_path.first" no>
	&nbsp;&nbsp;»&nbsp;&nbsp;
	</block name="id_path.first" no>
	<a href="{lng}{id_path.page_url}" title="{id_path.page_title}">{id_path.title}</a>
	</loop name="id_path">
	</div>

	<div class="mainitems_content">

		<loop name="mainitems">
		<div class="product_thumb radius5">
		<div class="img radius5" style="background:url('{upload_url}thumb_{mainitems.image}') center center no-repeat;">
		<a href="{lng}{mainitems.page_url}{mainitems.product_url}-{mainitems.id}.html"><img src="images/0.gif" alt="" /></a>
		</div>
		<a class="title" href="{lng}{mainitems.page_url}{mainitems.product_url}-{mainitems.id}.html">{mainitems.title}</a>
		<p class="price">{mainitems.price}<block name="mainitems.is_old_price"> <span>{mainitems.old_price}</span></block name="mainitems.is_old_price"></p>
		</div>
		</loop name="mainitems">

		<div class="clear"></div>

	</div>

<block name="is_paging">
<div class="paging">
{phrases.paging}&nbsp;&nbsp;
<loop name="paging">
<a href="{lng}/{page_data.page_url}offset/{paging.value}/">{paging.title}</a>
</loop name="paging">
</div>
</block name="is_paging">


</block name="get.id" no>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="box alt">
	<div class="border-top">
		<div class="border-right">
			<div class="border-bot">
				<div class="border-left">
					<div class="left-top-corner">
						<div class="right-top-corner">
							<div class="right-bot-corner">
								<div class="left-bot-corner">
									<div class="inner">
										<h3>{phrases.siulome}</h3>
										<p>Pets Site is a free websites template created by Templates.com team. This website template is optimized for 1024X768 screen resolution. It is also XHTML &amp; CSS valid.</p>
										<p>The website template goes with two packages ā€“ with PSD source files and without them. PSD source files are available for free for the registered members of Templates.com. The basic package (without PSD is available for anyone without registration).</p>
										<p class="p0">This website template has several pages: <a href="home.html">Home</a>, <a href="about-us.html">About us</a>, <a href="articles.html">Article</a> (with <a href="article.html">Article</a> page), <a href="contact-us.html">Contact us</a> (note that contact us form ā€“ doesnā€™t  work), <a href="sitemap.html">Site Map</a>.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>