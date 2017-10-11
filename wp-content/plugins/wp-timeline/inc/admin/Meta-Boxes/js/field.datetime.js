
/**
 * Date & Time Fields
 */

EXC_MB.addCallbackForClonedField( ['EXC_MB_Date_Field', 'EXC_MB_Time_Field', 'EXC_MB_Date_Timestamp_Field', 'EXC_MB_Datetime_Timestamp_Field' ], function( newT ) {

	// Reinitialize all the datepickers
	newT.find( '.exc_mb_datepicker' ).each(function () {
		jQuery(this).attr( 'id', '' ).removeClass( 'hasDatepicker' ).removeData( 'datepicker' ).unbind().datepicker();
	});

	// Reinitialize all the timepickers.
	newT.find('.exc_mb_timepicker' ).each(function () {
		jQuery(this).timePicker({
			startTime: "00:00",
			endTime: "23:30",
			show24Hours: false,
			separator: ':',
			step: 30
		});
	});

} );

EXC_MB.addCallbackForInit( function() {

	// Datepicker
	jQuery('.exc_mb_datepicker').each(function () {
		jQuery(this).datepicker();
	});
	
	// Wrap date picker in class to narrow the scope of jQuery UI CSS and prevent conflicts
	jQuery("#ui-datepicker-div").wrap('<div class="exc_mb_element" />');

	// Timepicker
	jQuery('.exc_mb_timepicker').each(function () {
		jQuery(this).timePicker({
			startTime: "00:00",
			endTime: "23:30",
			show24Hours: false,
			separator: ':',
			step: 30
		});
	} );

});