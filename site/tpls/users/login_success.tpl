<div class="purchase regiter_success">
    
    <p>{phrases.login_success}</p>
    
    
    <p>
        
        <a href="javascript: void(profile());">{phrases.my_profile}</a><br /><br />
        <a href="javascript: void(close());">{phrases.close}</a>
        
        
        {block continue_checkout}
        <a href="javascript: void(checkout());">{phrases.continue_checkout}</a>
        {-block continue_checkout}
    </p>
    
        
</div>
<script>
location.reload();
</script>