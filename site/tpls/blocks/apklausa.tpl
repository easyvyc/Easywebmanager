{block apklausa_data.id}
<div class="apklausa-block">
{block apklausa_data.voted no}
<form id="apklausa-form">
    
    <h2>{phrases.apklausa}</h2>
    
    <b>{apklausa_data.title}</b>
    
    {loop apklausa}
    <label style="margin:5px 0;vertical-align:middle;display:block;"><input type="radio" name="poll" value="{apklausa.id}"> {apklausa.title}</label>
    {-loop apklausa}
    <br />
    <input type="submit" value="{phrases.apklausa_submit}">
    
</form>

<script>

$(document).ready(function(){
    $('#apklausa-form').submit(function(){
        $form = $(this);
        if($("[name=poll]:checked", $form).size() > 0){
            $.ajax({
              url: "index.php?module=apklausos&method=vote&ajax=1&apklausa_id={apklausa_data.id}&variantas_id=" + $("[name=poll]:checked", $form).val(),
              cache: false,
              dataType:"html",
              beforeSend:function(){
                  $('#apklausa').html("<p style='text-align:center'><img src='site/images/loader.gif'></p>");
              },
              success: function(html){
                $('#apklausa').html(html);
              }
            });
        }
    });
});
    
</script>
    
{-block apklausa_data.voted no}

{block apklausa_data.voted}
    
    <h2>{phrases.apklausa}</h2>
    
    <b>{apklausa_data.title}</b>
    <br /><br />
    
    {loop apklausa}
    <div class="result" style="margin:5px 0">
        <span >{apklausa.title} ({apklausa.result}% - {apklausa.vote_count}/{apklausa_data.vote_count})</span>
        <div class="res" style="width:{apklausa.result}%;background:#AAF;height:5px;"></div>
    </div>
    {-loop apklausa}

{-block apklausa_data.voted}
</div>
{-block apklausa_data.id}