(function ($) {
	'use strict';
	$(document).ready(function () {
		function initFlatpickr(selector) {
			if ($(selector).length) {
				flatpickr(selector, {
					altInput: true,
					altFormat: "F j, Y",
					dateFormat: "Y-m-d",
				});
			}
		}
		/** Init Flatpickr */
		if (typeof flatpickr !== 'undefined') {
			if ($('#start_date').length) {
				initFlatpickr("#start_date");
			}
			if ($('#end_date').length) {
				initFlatpickr("#end_date");
			}
		}
	});

})(jQuery);
