<div class="calendar-title">{phrases.calendar}</div>

<div id="calendar-datepicker"></div>
<script>
$(function() {

    var easy_current_year = <?= date('Y') ?>;
    var easy_current_month = <?= date('m') ?>;
    var easy_selected_dates = new Array;
    easy_selected_dates[easy_current_year] = new Array;
    easy_selected_dates[easy_current_year][easy_current_month] = new Array;

    function getCalendarMonthDays(Y, M){
        $.ajax({
            async: false,
            dataType: "json",
            url: "?module=events&method=listCalendarMonthDates&ajax=1&y="+Y+"&m="+(M<10?"0"+M:M),
            beforeSend: function(){
            },
            success: function(json){
                if(!easy_selected_dates[Y]){
                        easy_selected_dates[Y] = new Array;
                }
                if(!easy_selected_dates[Y][M]){
                        easy_selected_dates[Y][M] = new Array;
                }
                $.each(json, function(key, val) {
                        easy_selected_dates[Y][M][easy_selected_dates[Y][M].length] = { date:new Date(Y, M-1, parseInt(val.day)), text:val.text };
                });
            }					  
        });
    }

    function loadEasyCalendar(){

        getCalendarMonthDays(easy_current_year, easy_current_month);

        $("#calendar-datepicker").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            onChangeMonthYear: function(year, month, inst) {
                easy_current_year = year;
                easy_current_month = month;
                if(!easy_selected_dates[year] || !easy_selected_dates[year][month]){
                    getCalendarMonthDays(easy_current_year, easy_current_month);
                }
            },
            beforeShowDay: function(date) {
                for(var i=0; i<easy_selected_dates[easy_current_year][easy_current_month].length; i++) {
                    if((!(date>easy_selected_dates[easy_current_year][easy_current_month][i].date || easy_selected_dates[easy_current_year][easy_current_month][i].date>date))) {
                        return [true, 'ui-datepicker-highlight', easy_selected_dates[easy_current_year][easy_current_month][i].text];
                    }
                }
                return [true];
            },				
            onSelect: function(selectedDate, inst) {
                location = '{events_page.page_url}?date=' + selectedDate;
                //showAjaxDialog("ajax.php?content=call&module=_main&method=showCalendarDay&params[year]="+dt[0]+"&params[month]="+dt[1]+"&params[day]="+dt[2], selectedDate, selectedDate);
            }
        });

    }

    loadEasyCalendar();
    
});
</script>
<div style="height:15px;">&nbsp;</div>