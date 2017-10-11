;(function($){
	$(document).ready(function() {
		if(jQuery("#we_allday input").prop('checked')){
			jQuery('#we_startdate .exc_mb_timepicker').css('display', 'none');
			jQuery('#we_enddate .exc_mb_timepicker').css('display', 'none');
		}
		jQuery("#we_allday input").click(function(){
			if(jQuery('#we_allday input').prop('checked')){			
				jQuery('#we_startdate .exc_mb_timepicker').css('display', 'none');
				jQuery('#we_enddate .exc_mb_timepicker').css('display', 'none');
			}else{
				jQuery('#we_startdate .exc_mb_timepicker').css('display', 'inline');
				jQuery('#we_enddate .exc_mb_timepicker').css('display', 'inline');
			}
		});
		/*-ajax save meta-*/
		jQuery('input[name="wpex_timeline_sort"]').change(function() {
			var $this = $(this);
			var post_id = $this.attr('data-id');
			var valu = $this.val();
           	var param = {
	   			action: 'wpex_change_timeline_sort',
	   			post_id: post_id,
				value: valu
	   		};
	   		$.ajax({
	   			type: "post",
	   			url: wpex_timeline.ajaxurl,
	   			dataType: 'html',
	   			data: (param),
	   			success: function(data){
	   				return true;
	   			}	
	   		});
		});
		/*-ajax save meta-*/
		jQuery('input[name="wpex_timeline_date"]').change(function() {
			var $this = $(this);
			var post_id = $this.attr('data-id');
			var valu = $this.val();
           	var param = {
	   			action: 'wpex_change_timeline_date',
	   			post_id: post_id,
				value: valu
	   		};
	   		$.ajax({
	   			type: "post",
	   			url: wpex_timeline.ajaxurl,
	   			dataType: 'html',
	   			data: (param),
	   			success: function(data){
	   				return true;
	   			}	
	   		});
		});
	});
}(jQuery));