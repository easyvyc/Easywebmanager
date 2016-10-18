{block inner_menu}
<nav id="inner_menu">

    <ul>
        {loop inner_menu}
        <li class="mn_{inner_menu.template} {block inner_menu.selected}a{-block inner_menu.selected}">

            <a href="{lng}{inner_menu.page_url}" title="{inner_menu.page_title}">{inner_menu.title}</a>

            {block inner_menu.selected}
            {block inner_menu.sub}
            <ul>
                {loop inner_menu.sub}
                <li class="{block inner_menu.sub.selected}a{-block inner_menu.sub.selected}">
                    <a href="{lng}{inner_menu.sub.page_url}" title="{inner_menu.sub.page_title}">{inner_menu.sub.title}</a>

                    {block inner_menu.sub.selected}
                    {block inner_menu.sub.sub}
                    <ul>
                        {loop inner_menu.sub.sub}
                        <li class="{block inner_menu.sub.sub.selected}a{-block inner_menu.sub.sub.selected}"><a href="{lng}{inner_menu.sub.sub.page_url}" title="{inner_menu.sub.sub.page_title}">{inner_menu.sub.sub.title}</a></li>
                        {-loop inner_menu.sub.sub}
                    </ul>
                    {-block inner_menu.sub.sub}
                    {-block inner_menu.sub.selected}

                </li>
                {-loop inner_menu.sub}
            </ul>
            {-block inner_menu.sub}
            {-block inner_menu.selected}

        </li>
        {-loop inner_menu}
    </ul>
    &nbsp;
    
    {block show_filters}
        
    <link href="site/js/nouislider/jquery.nouislider.min.css" rel="stylesheet">
    <link href="site/js/nouislider/jquery.nouislider.pips.min.css" rel="stylesheet">
    <script src="site/js/nouislider/jquery.nouislider.all.js"></script>

    <div class="products-filters-form">
    <h3>{phrases.product_filter_title}</h3>
    <form action="{lng}{page_data.page_url}" method="get">
        
        <script>
            $(document).ready(function(){
                $('#filters_price_range').noUiSlider({
                        start: [ {block form_filters.price.min}{form_filters.price.min}{-block form_filters.price.min}{block form_filters.price.min no}{main_filters_data.min_price}{-block form_filters.price.min no}, {block form_filters.price.max}{form_filters.price.max}{-block form_filters.price.max}{block form_filters.price.max no}{main_filters_data.max_price}{-block form_filters.price.max no} ],
                        connect: true,
                        step:1,
                        range: {
                                'min': {main_filters_data.min_price},
                                'max': {main_filters_data.max_price}
                        }
                });
                
                $("#filters_price_range").Link('lower').to($("#filters_price_range_min"));
                $("#filters_price_range").Link('upper').to($("#filters_price_range_max"));

                $('#filters_price_range').noUiSlider_pips({
                        {block main_filters_data.range_values.v1 no}
                        mode: 'count',
                        values: 5,
                        {-block main_filters_data.range_values.v1 no}
                        {block main_filters_data.range_values.v1}
                        mode: 'values',
                        values: [{main_filters_data.range_values.v1},{main_filters_data.range_values.v2},{main_filters_data.range_values.v3},{main_filters_data.range_values.v4},{main_filters_data.range_values.v5}],
                        {-block main_filters_data.range_values.v1}
                        density: 5,
                        stepped: true
                });
                
            });
        </script>
        
        <div class="range_filter">
            <b>{phrases.filter_by_price}</b>
            <div id="filters_price_range"></div>
            <input type="hidden" id="filters_price_range_min" name="filter[price][min]" value="">
            <input type="hidden" id="filters_price_range_max" name="filter[price][max]" value="">
        </div>
        
        {loop filters}
        
        {block filters.use_filter_range}
        <script>
            $(document).ready(function(){
                $('#filters_{filters.id}_range').noUiSlider({
                        start: [ {filters.min_value_rng}, {filters.max_value_rng} ],
                        connect: true,
                        step:1,
                        range: {
                                'min': {filters.min_value},
                                'max': {filters.max_value}
                        }
                });
                
                $("#filters_{filters.id}_range").Link('lower').to($("#filters_{filters.id}_range_min"));
                $("#filters_{filters.id}_range").Link('upper').to($("#filters_{filters.id}_range_max"));

                $('#filters_{filters.id}_range').noUiSlider_pips({
                        mode: 'count',
                        values: 5,
                        density: 5,
                        stepped: true
                });
                
            });
        </script>
        <div class="range_filter">
            <b>{filters.title}</b>
            <div id="filters_{filters.id}_range"></div>
            <input type="hidden" id="filters_{filters.id}_range_min" name="filter[{filters.id}][min]" value="">
            <input type="hidden" id="filters_{filters.id}_range_max" name="filter[{filters.id}][max]" value="">
        </div>            
        {-block filters.use_filter_range}
        
        {block filters.use_filter_select}
        {block filters.options}
        <select name="filter[{filters.id}]" id="form_filter_{filters.id}">
            <option value="">--{filters.title}--</option>
            {loop filters.options}
            <option value="{filters.options.id}">{filters.options.title}</option>
            {-loop filters.options}
        </select>&nbsp;&nbsp;
        {-block filters.options}
        {-block filters.use_filter_select}

        {block filters.use_filter_checkbox}
        {block filters.options}
        <div class="filter_checkbox">
            <b>{filters.title}</b>
            {loop filters.options}
            {block filters.options.id}
            <label><input type="checkbox" name="filter[{filters.id}][]" value="{filters.options.id}" {block filters.options.selected}checked{-block filters.options.selected} /> {filters.options.title}</label>
            {-block filters.options.id}
            {-loop filters.options}
        </div>
        {-block filters.options}
        {-block filters.use_filter_checkbox}
        
        {-loop filters}
        <input type="submit" class="btn" value="{phrases.submit_filters}">
    </form>
    </div>
    
    {block form_filters}
    <script>
    $(document).ready(function(){
        {loop form_filters}
        $('#form_filter_{form_filters._KEY}').val('{form_filters._VALUE}');
        {-loop form_filters}
    });
    </script>
    {-block form_filters}
        
    {-block show_filters}
    
</nav>
{-block inner_menu}