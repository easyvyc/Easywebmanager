/* Lithuanian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* @author Arturas Paleicikas <arturas@avalon.lt> */
jQuery(function($){
	$.datepicker.regional['ru'] = {
		closeText: 'закрыть',
		prevText: '&#x3c;назад',
		nextText: 'вперед&#x3e;',
		currentText: 'сегодня',
		monthNames: ['январь','февраль','март','апрель','май','июнь','июль','август','сентябрь','октябрь','ноябрь','декабрь'],
		monthNamesShort: ['янв','фев','мар','апр','май','июнь','июль','авг','сен','окт','ноя','дек'],
		dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
		dayNamesShort: ['вск','пон','вто','сре','чет','пят','суб'],
		dayNamesMin: ['вс','пн','вт','ср','чт','пт','сб'],
		weekHeader: 'Wk',
		dateFormat: 'yy-mm-dd',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
	$.datepicker.setDefaults($.datepicker.regional['ru']);
});