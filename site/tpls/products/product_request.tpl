<form id="product-request-form" action="index.php?module=forms&method=process&formid=14744" method="post" name="product" seltype="mail" target="FORMS_IFRAME">

    <fieldset>
        <legend>{phrases.del_prekes}</legend>
        <input name="product" type="text" value="{product.title} ({product.code})" readonly />
    </fieldset>
    
    <fieldset>
        <input name="name" placeholder="Jūsų vardas" type="text" required="true" />
    </fieldset>
    <fieldset>
        <input name="email" placeholder="Jūsų el. paštas" type="email" required="true" />
    </fieldset>
    <fieldset>
        <input name="phone" placeholder="Jūsų telefonas" type="text" />
    </fieldset>
    <fieldset>
        <textarea name="text" placeholder="Klausimas" required="true"></textarea>
    </fieldset>
    <fieldset>
        <input name="captcha" placeholder="Saugos kodas" required="true" style="width:100px;vertical-align:middle;" type="text" />
        <img onclick="javascript: void(resetCaptcha());" rel="captcha" src="index.php?module=forms&method=captcha&w=200&h=70&t=1" style="cursor:pointer;vertical-align:middle;" title="Click to Reset" />
    </fieldset>
    <div class="submit">
        <input type="submit" value="Siųsti" class="add2cart" />
    </div>

</form>