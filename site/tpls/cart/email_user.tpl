<style>
    .table {
        width:700px;
        border-collapse:collapse;
        border-color:#999;
    }
    .table td, .table th {
        padding:7px;
        border-color:#999;
    }
    .cart_user_row .t {
        width:250px;
    }
</style>

{message}


<h3>{phrases.cart_title}</h3>
<table border="1" cellpadding="0" cellspacing="0" class="table">
	<tr>
		<th>&nbsp;</th>
		<th align="left">{phrases.product_title}</th>
		<th>{phrases.product_kiekis}</th>
		<th align="right" width="150">{phrases.product_price}</th>
	</tr>
{loop o_items}
	<tr>
		<td><img src="{config.site_url}index.php?module=products&method=first_image&column=image&id={o_items.rel_id}&w=120&h=120&t=landscape" /></td>
		<td>
                    <b>
                        <a href="{config.site_url}{o_items.page_url}{o_items.item_url}-{o_items.rel_id}.html">{o_items.title}</a></b>
                        <div>{o_items.short_description}</div>
                        <div>{o_items.modif}</div>
                </td>
		<td align="center">{o_items.kiekis}</td>
		<td align="right">{o_items.price} {o_data.currency}</td>
	</tr>
{-loop o_items}
</table>

<table border="1" cellpadding="0" cellspacing="0" class="table">
	{block o_data.shipping_price}
        <tr>
		<td align="right">{phrases.shipping_price}</td>
		<td align="right" width="150">{o_data.shipping_price} {o_data.currency}</td>
	</tr>
        {-block o_data.shipping_price}
	{block o_data.discount_sum}
        <tr>
		<td align="right">{phrases.discount_sum}</td>
		<td align="right" width="150">{o_data.discount_sum} {o_data.currency}</td>
	</tr>
        {-block o_data.discount_sum}
	<tr>
		<td align="right">{phrases.cart_total_price}</td>
		<td align="right" width="150"><b>{o_data.order_sum} {o_data.currency}</b></td>
	</tr>
</table>
<br />


<h3>{phrases.cart_payment_info_title}</h3>
<table border="1" cellpadding="0" cellspacing="0" class="table">
    
    <tr class="cart_user_row">
        <td class="t">{phrases.cart_payment_type}</td>
        <td class="v">{o_data.payment_list}</td>
    </tr>
    <tr class="cart_user_row">
        <td class="t">{phrases.cart_payment_status}</td>
        <td class="v"><b>{block o_data.payed}{phrases.cart_payment_status_yes}{-block o_data.payed}{block o_data.payed no}{phrases.cart_payment_status_no}{-block o_data.payed no}</b></td>
    </tr>
    
    {block o_data.payment_type_bank}
    <tr class="cart_user_row">
        <td class="t">{phrases.cart_payment_type_bank_rqz}</td>
        <td class="v">
            {settings.company}<br />
            {settings.company_code}<br />
            {settings.company_bank}<br />
            {settings.company_saskaita}
        </td>
    </tr>
    {-block o_data.payment_type_bank}
        
</table>
<br />
    
<h3>{phrases.cart_shipping_info_title}</h3>
<table border="1" cellpadding="0" cellspacing="0" class="table">
    
    <tr class="cart_user_row">
        <td class="t">{phrases.cart_shipping_type}</td>
        <td class="v">
            {o_data.shipping_type}
        </td>
    </tr>

    <tr class="cart_user_row">
        <td class="t">{phrases.cart_shipping_address}</td>
        <td class="v">{o_data.address_shipping}</td>
    </tr>

    <tr class="cart_user_row">
        <td class="t">{phrases.cart_shipping_info}</td>
        <td class="v">{o_data.info_shipping}</td>
    </tr>

</table>
<br />
    
<h3>{phrases.cart_user_info_title}</h3>
<table border="1" cellpadding="0" cellspacing="0" class="table">
    
    {block o_data.company}
    <tr class="cart_user_row">
        <td class="t">{phrases.cart_user_company}</td>
        <td class="v">{o_data.company}</td>
    </tr>

    <tr class="cart_user_row">
        <td class="t">{phrases.cart_user_company_code}</td>
        <td class="v">{o_data.company_code}</td>
    </tr>

    <tr class="cart_user_row">
        <td class="t">{phrases.cart_user_company_vat} </td>
        <td class="v">{o_data.company_vat}</td>
    </tr>

    <tr class="cart_user_row">
        <td class="t">{phrases.cart_user_city}</td>
        <td class="v">{o_data.city}</td>
    </tr>

    <tr class="cart_user_row">
        <td class="t">{phrases.cart_user_address}</td>
        <td class="v">{o_data.address}</td>
    </tr>
    {-block o_data.company}


    <tr class="cart_user_row">
        <td class="t">{phrases.cart_user_name} </td>
        <td class="v">{o_data.title}</td>
    </tr>

    <tr class="cart_user_row">
        <td class="t">{phrases.cart_user_email} </td>
        <td class="v">{o_data.email}</td>
    </tr>

    <tr class="cart_user_row">
        <td class="t">{phrases.cart_user_phone} </td>
        <td class="v">{o_data.phone}</td>
    </tr>

    {block o_data.company no}
    <tr class="cart_user_row">
        <td class="t">{phrases.cart_user_city}</td>
        <td class="v">{o_data.city}</td>
    </tr>

    <tr class="cart_user_row">
        <td class="t">{phrases.cart_user_address} </td>
        <td class="v">{o_data.address}</td>
    </tr>
    {-block o_data.company no}

    <tr class="cart_user_row">
        <td class="t">{phrases.cart_user_info} </td>
        <td class="v">{o_data.info}</td>
    </tr>
    
</table>