;(function($){
	$(document).ready(function($) {
		function wpex_timeline_scroll(){
			var $this = $(this);
			$(".wpex-timeline-list").each(function(){
				var Id_tm = jQuery(this).attr("id");
				var this_tl = $(this);
				var $tl_top = this_tl.offset().top;
				var $tl_end = $tl_top + this_tl.height();
				$tl_top =  $tl_top -200;
				$tl_end =  $tl_end;
				if (($(document).scrollTop() >= $tl_top) && ($(document).scrollTop() <= $tl_end)) {
					$("#"+Id_tm+" .wpex-filter").addClass('active');
				}else{
					$("#"+Id_tm+" .wpex-filter").removeClass('active');
				}
				var windowHeight = $(window).height(),
				gridTop = windowHeight * .3;
				var scrollTop = $this.scrollTop();
				$("#"+Id_tm+" ul li").each(function(){
					var ftid = $(this).data('id');
					var thisTop = $(this).offset().top - $(window).scrollTop();
					var thisBt =  thisTop + $(this).height(); 
					if (thisTop >= gridTop) {
						$('#'+ftid).removeClass('active');
					} else {
						$('#'+ftid).addClass('active');
					}
					/*-- If animation enable --*/
					var animations  		= $("#"+Id_tm).data('animations');
					if((animations !='') && (thisTop < windowHeight * .7)){
						$(this).children(":first").removeClass('scroll-effect').addClass( animations+' animated');
					}
					
					
					 
					/*var topDistance = $(this).offset().top;
					var ftid = $(this).data('id');
					var btDistance = topDistance + $(this).height();
					if ( (scrollTop >= topDistance) && ( scrollTop <= btDistance)) {
						$('#'+ftid).addClass('active');
					}else {
						$('#'+ftid).removeClass('active');
					}*/
				});
			});
		};
		$(".wpex-filter:not(.year-ft)").on('click', 'div span',function() {
			var contenId = jQuery(this).attr("id");
			var windowHeight = $(window).height();
			$('html,body').animate({
				scrollTop: $("."+contenId).offset().top - windowHeight * .2},
				'slow');
		});
		if($(".wpex-timeline-list").length ){
			wpex_timeline_scroll();
			$(document).scroll(function() {
				wpex_timeline_scroll();
			});
		}
		/*--year filter--*/
		$(".wpex-filter.year-ft").on('click', 'div span',function() {
			var $this_click = $(this);
			var timelineId = jQuery(this).data('id');
			$('#timeline-'+timelineId).addClass("loading no-more");
			var id_crsc = 'timeline-'+timelineId;
			$('#'+id_crsc+' .wpex-filter.year-ft div span').removeClass("active");
			$this_click.addClass('active');
			var tax = jQuery(this).data('value');
			var mult ='';
			if($('#'+id_crsc+' .wpex-taxonomy-filter li a.active').length ){
				mult = $('#'+id_crsc+' .wpex-taxonomy-filter li a.active').data('value');
			}
			var ajax_url  		= $('#timeline-'+timelineId+' input[name=ajax_url]').val();
			var param_shortcode  		= $('#timeline-'+timelineId+' input[name=param_shortcode]').val();
			$('#'+id_crsc+' .wpex-loadmore.lbt').addClass("hidden");
			$('#timeline-'+timelineId+' ul.wpex-timeline li').fadeOut(300, function() { $(this).remove(); });
			var param = {
				action: 'wpex_filter_year',
				taxonomy_id : tax,
				mult : mult,
				param_shortcode: param_shortcode,
			};
			$.ajax({
				type: "post",
				url: ajax_url,
				dataType: 'json',
				data: (param),
				success: function(data){
					if(data != '0')
					{
						if(data != ''){ 
							var $_container = $('#'+id_crsc+' ul.wpex');
							$_container.html('');
							if(data.html_content != ''){ 
								$('#'+id_crsc+' .wpex-tltitle.wpex-loadmore').prepend('<span class="yft">'+$this_click.html()+'</span>');
								$('#'+id_crsc+' .wpex-loadmore:not(.lbt)').removeClass("hidden");
								$_container.append(data.html_content);
							}else{
								$('#'+id_crsc+' .wpex-loadmore').addClass("hidden");
								$_container.append('<h2 style="text-align: center;">'+data.massage+'</h2>');
							}
							setTimeout(function(){ 
								$('#'+id_crsc+' ul.wpex > li').addClass("active");
							}, 200);
							$('#'+id_crsc).removeClass("loading");
						}
						wpex_timeline_scroll();
						$(".wpex-timeline-list .wpex-filter:not(.active)").css("right", $(".wpex-timeline-list .wpex-filter").width()*(-1));
					}else{$('.row.loadmore').html('error');}
				}
			});
			return false;
		});
		/*--Taxonomy filter--*/
		$(".wpex-taxonomy-filter").on('click', 'li a',function() {
			var $this_click = $(this);
			var timelineId = jQuery(this).data('id');
			var id_crsc = 'timeline-'+timelineId;
			$('#timeline-'+timelineId+' .wpex-taxonomy-filter li a').removeClass("active");
			$('#'+id_crsc+' .wpex-filter.year-ft div span').removeClass("active");
			$('#'+id_crsc+' .wpex-loadmore').removeClass("hidden");
			$this_click.addClass('active');
			var tax = jQuery(this).data('value');
			var ajax_url  		= $('#timeline-'+timelineId+' input[name=ajax_url]').val();
			var param_shortcode  		= $('#timeline-'+timelineId+' input[name=param_shortcode]').val();
			$('#timeline-'+timelineId).addClass("loading");
			$('#timeline-'+timelineId+' ul.wpex-timeline li').fadeOut(300, function() { $(this).remove(); });
			$('#'+id_crsc+' input[name=num_page_uu]').val(1);
			$('#'+id_crsc+' input[name=current_page]').val(1);
			$('#'+id_crsc+' .wpex-tltitle.wpex-loadmore .yft').remove();
			var param = {
				action: 'wpex_filter_taxonomy',
				taxonomy_id : tax,
				param_shortcode: param_shortcode,
			};
			$.ajax({
				type: "post",
				url: ajax_url,
				dataType: 'json',
				data: (param),
				success: function(data){
					if(data != '0')
					{
						if(data == ''){ 
							$('#'+id_crsc+' .wpex-loadmore.lbt').addClass("hidden");
						}
						else{
							var $_container = $('#'+id_crsc+' ul.wpex');
							$_container.html('');
							$_container.append(data.html_content);
							$('#'+id_crsc+' .wpex-filter:not(.year-ft) div span').remove();
							$('#'+id_crsc+' .wpex-filter:not(.year-ft) div').append(data.date);
							setTimeout(function(){ 
								$('#'+id_crsc+' ul.wpex > li').addClass("active");
							}, 200);
							$('#'+id_crsc).removeClass("loading");
							$('#'+id_crsc+' input[name=param_query]').val(JSON.stringify(data.data_query));
						}
						if(data.more != 1){
							$('#'+id_crsc).addClass("no-more");
							$('#'+id_crsc+' .wpex-loadmore.lbt').addClass("hidden");
						}else{
							$('#'+id_crsc).removeClass("no-more");
						}
						wpex_timeline_scroll();
						$(".wpex-timeline-list .wpex-filter:not(.active)").css("right", $(".wpex-timeline-list .wpex-filter").width()*(-1));
					}else{$('.row.loadmore').html('error');}
				}
			});
			return false;
		});
		/*-loadmore-*/
		$('.loadmore-timeline').on('click',function() {
			var $this_click = $(this);
			$this_click.addClass('disable-click');
			var id_crsc  		= $this_click.data('id');
			var n_page = $('#'+id_crsc+' input[name=num_page_uu]').val();
			$('#'+id_crsc+' .loadmore-timeline').addClass("loading");
			var param_query  		= $('#'+id_crsc+' input[name=param_query]').val();
			var page  		= $('#'+id_crsc+' input[name=current_page]').val();
			var num_page  		= $('#'+id_crsc+' input[name=num_page]').val();
			var ajax_url  		= $('#'+id_crsc+' input[name=ajax_url]').val();
			var param_shortcode  		= $('#'+id_crsc+' input[name=param_shortcode]').val();
			var crr_y = '';
			if($('#'+id_crsc+' li:last-child > input.crr-year').length){
				crr_y = $('#'+id_crsc+' li:last-child > input.crr-year').val();
			}
				var param = {
					action: 'wpex_loadmore_timeline',
					param_query: param_query,
					page: page*1+1,
					param_shortcode: param_shortcode,
					param_year: crr_y,
				};
	
				$.ajax({
					type: "post",
					url: ajax_url,
					dataType: 'json',
					data: (param),
					success: function(data){
						if(data != '0')
						{
							n_page = n_page*1+1;
							$('#'+id_crsc+' input[name=num_page_uu]').val(n_page)
							if(data.html_content == ''){ 
								$('#'+id_crsc+' .wpex-loadmore.lbt').addClass("hidden");
							}
							else{
								$('#'+id_crsc+' input[name=current_page]').val(page*1+1);
								var $_container = $('#'+id_crsc+' ul.wpex');
								$_container.append(data.html_content);
								$('#'+id_crsc+' .wpex-filter:not(.year-ft) div').append(data.date);
								setTimeout(function(){ 
									$('#'+id_crsc+' ul.wpex > li').addClass("active");
								}, 200);
							}
							if(n_page == num_page){
								$('#'+id_crsc).addClass("no-more");
								$('#'+id_crsc+' .wpex-loadmore.lbt').addClass("hidden");
							}
							wpex_timeline_scroll();
							$(".wpex-timeline-list .wpex-filter:not(.active)").css("right", $(".wpex-timeline-list .wpex-filter").width()*(-1));
							$('#'+id_crsc+' .loadmore-timeline').removeClass("loading");
							$this_click.removeClass('disable-click');
						}else{$('.row.loadmore').html('error');}
					}
				});
			return false;	
		});
		/*----*/
		$(".wpex-timeline-list .wpex-filter").css("right", $(".wpex-timeline-list .wpex-filter").width()*(-1));
		$(".wpex-timeline-list .wpex-filter > .fa").on('click',function() {
			var id_crsc  		= $(this).data('id');
			if(!$('#'+id_crsc+' .wpex-filter').hasClass('show-filter')){
				$('#'+id_crsc+' .wpex-filter').addClass('show-filter');
				$('#'+id_crsc+' .wpex-filter').css("right", 0);
			}else{
				$('#'+id_crsc+' .wpex-filter').removeClass('show-filter');
				$('#'+id_crsc+' .wpex-filter').css("right", $(".wpex-timeline-list .wpex-filter").width()*(-1));
			}
		});
		if($(".wpex-timeline-list").length){
			var $tl_top = $(".wpex-timeline-list").offset().top;
			var $tl_end = $tl_top + $(".wpex-timeline-list ul").height();
			if (($(document).scrollTop() >= $tl_top) && ($(document).scrollTop() <= $tl_end)) {
				/*//$(".wpex-timeline-list .wpex-filter").addClass('active');*/
			}
		}
		/*--Light box--*/
		wpex_timeline_lightbox();
		function wpex_timeline_lightbox(){
			$('.wpex-timeline-list').each(function(){
				var $this = $(this);
				var id =  $this.attr("id");
				if($($this).hasClass('wptl-lightbox')){
					if($('#'+id).hasClass('left-tl') && $('#'+id).hasClass('show-icon')){
						$('#'+id+' ul.wpex-timeline').slickLightbox({
							itemSelector: '> li .wpex-content-left > a',
							useHistoryApi: true
						});
					}else if($('#'+id).hasClass('left-tl') || ($('#'+id).hasClass('center-tl') && !$('#'+id).hasClass('show-icon'))){
						$('#'+id+' ul.wpex-timeline').slickLightbox({
							itemSelector: '> li .wpex-timeline-time > a',
							useHistoryApi: true
						});
					}else{
						$('#'+id+' ul.wpex-timeline').slickLightbox({
							itemSelector: '> li .timeline-details > a',
							useHistoryApi: true
						});
					}
				}
			});
		}
		/*--Slider timeline--*/
		$('.horizontal-timeline.ex-multi-item').each(function(){
			var $this = $(this);
			var id =  $this.data('id');
			var slidesshow =  $this.data('slidesshow');
			var startit =  $this.data('startit') > 0 ? $this.data('startit') : 1;
			var auto_play = $this.data('autoplay');
			var auto_speed = $this.data('speed');
			var rtl_mode = $this.data('rtl');
			var start_on =  $this.data('start_on') > 0 ? $this.data('start_on') : 0;
			$('#'+id+' .horizontal-nav').EX_ex_s_lick({
				infinite: false,
				initialSlide:start_on,
				rtl: rtl_mode =='yes' ? true : false,
				prevArrow:'<button type="button" class="ex_s_lick-prev"><i class="fa fa-angle-left"></i></button>',
				nextArrow:'<button type="button" class="ex_s_lick-next"><i class="fa fa-angle-right"></i></button>',	
				slidesToShow: slidesshow,
				slidesToScroll: 1,
				dots: false,
				autoplay: auto_play==1 ? true : false,
				autoplaySpeed: auto_speed!='' ? auto_speed : 3000,
				arrows: true,
				centerMode:  false,
				focusOnSelect: true,
				adaptiveHeight: true,
				responsive: [
					{
					  breakpoint: 1024,
					  settings: {
						slidesToShow: 3,
						slidesToScroll: 1,
					  }
					},
					{
					  breakpoint: 768,
					  settings: {
						slidesToShow: 2,
						slidesToScroll: 1
					  }
					},
					{
					  breakpoint: 480,
					  settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					  }
					}
				  ]
				
			});
		});
		$('.horizontal-timeline:not(.ex-multi-item) ul.horizontal-nav li').on('click',function() {
			$(this).prevAll().addClass('prev_item');
			$(this).nextAll().removeClass('prev_item');
		});
		$(window).resize(function() {
			$('.horizontal-timeline:not(.ex-multi-item)').each(function(){
				var $this = $(this);
				setTimeout(function() {
					var id =  $this.data('id');
					var $slide = $('#'+id+' ul.horizontal-nav li.ex_s_lick-current');
					var crrleft = $slide.offset();
					var ct_left = $('#'+id+' .horizontal-nav').offset();
					var ct_width = $slide.width();
					var ps_width = (crrleft.left - ct_left.left) + ct_width/2;
					$('#'+id+' .timeline-pos-select').css( 'width',ps_width);
				}, 200);
			});
		});
		$('.horizontal-timeline:not(.ex-multi-item)').each(function(){
			var $this = $(this);
			if($this.hasClass('tl-hozsteps')){center_mode = false}
			var style = $this.data('layout');
			var id =  $this.data('id');
			var slidesshow =  $this.data('slidesshow');
			var arrowpos =  $this.data('arrowpos');
			var startit =  $this.data('startit') > 0 ? $this.data('startit') : 1;
			var auto_play = $this.data('autoplay');
			var auto_speed = $this.data('speed');
			var rtl_mode = $this.data('rtl');
			
			var start_on =  $this.data('start_on') > 0 ? $this.data('start_on') : 0;
			
			var center_mode = $this.data('center');
			
			$('#'+id+' .horizontal-content')
			
			.on('beforeChange', function(event, EX_ex_s_lick, currentSlide, nextSlide){
				$li_curr = nextSlide + 1;
				$('#'+id+' .horizontal-nav li.ex_s_lick-slide:nth-child('+$li_curr+')').prevAll().addClass('prev_item');
				$('#'+id+' .horizontal-nav li.ex_s_lick-slide:nth-child('+$li_curr+')').nextAll().removeClass('prev_item');
			  }
			)
			.on('afterChange', function(event, EX_ex_s_lick, direction,nextSlide){
				for (var i = 0; i < EX_ex_s_lick.$slides.length; i++)
				{
					var $slide = $(EX_ex_s_lick.$slides[i]);
					if ($slide.hasClass('ex_s_lick-current')) {
						/* update width */
						$pos_c = i + 1;
						//var $slide = $(EX_ex_s_lick.$slides[i]);
						var $slide = $('#'+id+' ul.horizontal-nav li:nth-child('+$pos_c+')');
						var crrleft = $slide.offset();
						var ct_left = $('#'+id+' .horizontal-nav').offset();
						var ct_width = $slide.width();
						var ps_width = (crrleft.left - ct_left.left) + ct_width/2;
						$('#'+id+' .timeline-pos-select').css( 'width',ps_width);
						
						
						$slide.removeClass('prev_item');
						$slide.nextAll().removeClass('prev_item');
						break;
					}
				}
			  }
			)
			
			.EX_ex_s_lick({
				infinite: false,
				speed:auto_speed!='' ? auto_speed : 250,
				initialSlide:start_on,
				rtl: rtl_mode =='yes' ? true : false,
				slidesToShow: 1,
				slidesToScroll: 1,
				adaptiveHeight:true,
				arrows: arrowpos !='top' ? true : false,
				prevArrow:'<button type="button" class="ex_s_lick-prev"><i class="fa fa-angle-left"></i></button>',
				nextArrow:'<button type="button" class="ex_s_lick-next"><i class="fa fa-angle-right"></i></button>',
				fade: true,
				asNavFor: '#'+id+' .horizontal-nav',
			});
			$('#'+id+' .horizontal-nav')
			.on('init', function(event, EX_ex_s_lick, direction){
				if(start_on!='' && $.isNumeric(start_on)){
					var $slide = $(EX_ex_s_lick.$slides[start_on]);
					$slide.addClass('ex_s_lick-current');
					$(EX_ex_s_lick.$slides[0]).removeClass('ex_s_lick-current');
					$slide.nextAll().removeClass('prev_item');
					$slide.prevAll().addClass('prev_item');
				}else{
					var $slide = $(EX_ex_s_lick.$slides[0]);
				}
				//console.log($slide);
				if ($slide.hasClass('ex_s_lick-current')) {
					var crrleft = $slide.offset();
					var ct_left = $('#'+id+' .horizontal-nav').offset();
					var ct_width = $slide.width();
					var ps_width = (crrleft.left - ct_left.left) + ct_width/2;
				}
				$('#'+id+' .timeline-pos-select').css( 'width',ps_width);
			})
			.EX_ex_s_lick({
				infinite: false,
				speed:auto_speed!='' ? auto_speed : 250,
				initialSlide:start_on,
				rtl: rtl_mode =='yes' ? true : false,
				prevArrow:'<button type="button" class="ex_s_lick-prev"><i class="fa fa-angle-left"></i></button>',
				nextArrow:'<button type="button" class="ex_s_lick-next"><i class="fa fa-angle-right"></i></button>',	
				slidesToShow: slidesshow,
				slidesToScroll: 1,
				asNavFor: '#'+id+' .horizontal-content',
				dots: false,
				autoplay: auto_play==1 ? true : false,
				autoplaySpeed: auto_speed!='' ? auto_speed : 3000,
				arrows: arrowpos =='top' ? true : false,
				centerMode: center_mode !='left' ? true : false,
				focusOnSelect: true,
				
				
				responsive: [
					{
					  breakpoint: 1024,
					  settings: {
						slidesToShow: 3,
						slidesToScroll: 1,
					  }
					},
					{
					  breakpoint: 600,
					  settings: {
						slidesToShow: 3,
						slidesToScroll: 1
					  }
					},
					{
					  breakpoint: 480,
					  settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					  }
					}
				  ]
				
			});
		});
		$('.slider-timeline').each(function(){
			var $this = $(this);
			var style = $this.data('layout');
			var id =  $this.data('id');
			var startit =  $this.data('startit') > 0 ? $this.data('startit') : 1;
			var auto_play = $this.data('autoplay');
			var settings = ({
				orientation: style,
				id_control: '#'+id,
				containerDiv: '#'+id,
				datesDiv: '.wpex-dates',			/*// value: any HTML tag or #id, default to #dates*/
				datesSelectedClass: 'selected',		/*// value: any class, default to selected*/
				issuesDiv: '.wptl-item',
				autoPlay: auto_play?true:false,
				autoPlayDirection: 'forward',
				issuesSelectedClass: 'selected',
				issuesSpeed: 'fast',				/*// value: integer between 100 and 1000 (recommended) or 'slow', 'normal' or 'fast'; default to fast*/
				issuesTransparency: 0.2,					/*// value: integer between 0 and 1 (recommended), default to 0.2*/
				issuesTransparencySpeed: 500,					/*// value: integer between 100 and 1000 (recommended), default to 500 (normal)*/
				prevButton: '#prev',			/*// value: any HTML tag or #id, default to #prev*/
				nextButton: '#next',			/*// value: any HTML tag or #id, default to #next*/
				arrowKeys: 'false',			/*// value: true | false, default to false*/
				startAt: startit,						/*// value: integer, default to 1 (first)*/
				autoPlayDirection: 'forward',		/*// value: forward | backward, default to forward*/
				autoPlayPause: 2000					/*// value: integer (1000 = 1 seg), default to 2000 (2segs)*/
		   });
		   if(settings.orientation == 'vertical') {
			   /*//$(settings.id_control).height($(settings.id_control+' '+settings.issuesDiv+' li').height());*/
		   }
		   wpex_timeline(settings)
		});	
	});

	function wpex_timeline(settings){
		if ($(settings.id_control+' '+settings.datesDiv).length > 0 && $(settings.id_control+' '+settings.issuesDiv).length > 0) {
			/*// setting variables... many of them*/
			var howManyDates = $(settings.id_control+' '+settings.datesDiv+' li').length;
			var howManyIssues = $(settings.id_control+' '+settings.issuesDiv+' li').length;
			var currentDate = $(settings.id_control+' '+settings.datesDiv).find('a.'+settings.datesSelectedClass);
			var currentIssue = $(settings.id_control+' '+settings.issuesDiv).find('li.'+settings.issuesSelectedClass);
			/*//-- add by exthemes --//*/
			var widthContainer = $(settings.containerDiv).width();
			/*//-- end --//*/
			if(settings.orientation == 'horizontal') {
				$(settings.id_control+' '+settings.issuesDiv+' li').width($(settings.containerDiv).width());
			}
			var heightContainer = $(settings.containerDiv).height();
			var widthIssues = $(settings.id_control+' '+settings.issuesDiv).width();
			var heightIssues = $(settings.id_control+' '+settings.issuesDiv).height();
			var widthIssue = $(settings.id_control+' '+settings.issuesDiv+' li').width();
			var heightIssue = $(settings.id_control+' '+settings.issuesDiv+' li').height();
			var widthDates = $(settings.id_control+' '+settings.datesDiv).width();
			var heightDates = $(settings.id_control+' '+settings.datesDiv).height();
			var widthDate = $(settings.id_control+' '+settings.datesDiv+' li').width();
			var heightDate = $(settings.id_control+' '+settings.datesDiv+' li').height();
			/*// set positions!*/
			
			if(settings.orientation == 'horizontal') {
				$(settings.id_control+' '+settings.issuesDiv).width(widthIssue*howManyIssues);
				$(settings.id_control+' '+settings.datesDiv).width(widthDate*howManyDates).css('marginLeft',widthContainer/2-widthDate/2);
				var defaultPositionDates = parseInt($(settings.id_control+' '+settings.datesDiv).css('marginLeft').substring(0,$(settings.datesDiv).css('marginLeft').indexOf('px')));
				
				
			} else if(settings.orientation == 'vertical') {
				$(settings.id_control+' '+settings.issuesDiv).height(heightIssue*howManyIssues);
				$(settings.id_control+' '+settings.datesDiv+' li').height();
				/*//$(settings.id_control+' '+settings.datesDiv).height(heightDate*howManyDates).css('marginTop',heightContainer/2-heightDate/2);*/
				var defaultPositionDates = parseInt($(settings.id_control+' '+settings.datesDiv).css('marginTop').substring(0,$(settings.id_control+' '+settings.datesDiv).css('marginTop').indexOf('px')));
			}
			
			/*//-- add by exthemes --//*/
			$(window).resize(function() {
				if(settings.orientation == 'horizontal') {
					$(settings.id_control+' '+settings.issuesDiv+' li').width($(settings.containerDiv).width());
				}
				widthContainer = $(settings.containerDiv).width();
				heightContainer = $(settings.containerDiv).height();
				widthIssues = $(settings.id_control+' '+settings.issuesDiv).width();
				heightIssues = $(settings.id_control+' '+settings.issuesDiv).height();
				widthIssue = $(settings.id_control+' '+settings.issuesDiv+' li').width();
				heightIssue = $(settings.id_control+' '+settings.issuesDiv+' li').height();
				widthDates = $(settings.id_control+' '+settings.datesDiv).width();
				heightDates = $(settings.id_control+' '+settings.datesDiv).height();
				widthDate = $(settings.id_control+' '+settings.datesDiv+' li').width();
				heightDate = $(settings.id_control+' '+settings.datesDiv+' li').height();
				if(settings.orientation == 'horizontal') {	
					$(settings.id_control+' '+settings.issuesDiv).width(widthIssue*howManyIssues);
					var nb_pre = $(settings.id_control+' a.selected').parent().prevAll().length;
					$(settings.id_control+' '+settings.datesDiv).width(widthDate*howManyDates).css('marginLeft',widthContainer/2-widthDate/2);
					defaultPositionDates = parseInt($(settings.id_control+' '+settings.datesDiv).css('marginLeft').substring(0,$(settings.id_control+' '+settings.datesDiv).css('marginLeft').indexOf('px')));
				} else if(settings.orientation == 'vertical') {
					/*//$(settings.id_control+' '+settings.issuesDiv).width(widthIssue*howManyIssues - 100);
					//$(settings.id_control).height($(settings.id_control+' '+settings.issuesDiv+' li.selected').height());*/
				}
			});
			/*//-- end --//*/
			
			$(settings.id_control+' '+settings.datesDiv+' a').click(function(event){
				event.preventDefault();
				/*// first vars*/
				var whichIssue = $(this).text();
				var currentIndex = $(this).parent().prevAll().length;
				/*// moving the elements*/
				var li_cur = ' li:nth-child('+(currentIndex+1)+')';
				if(settings.orientation == 'horizontal') {
					/*//-- add by exthemes --//*/
					$(window).resize(function() {
						widthIssue = $(settings.id_control+' '+settings.issuesDiv+' li').width();
						$(settings.id_control+' '+settings.issuesDiv).animate({'marginLeft':-widthIssue*currentIndex},{queue:false, duration:settings.issuesSpeed});
						$(settings.id_control).height($(settings.id_control+' '+settings.issuesDiv+' '+li_cur).height() + 110);
					});
					/*//-- end --//*/
					$(settings.id_control+' '+settings.issuesDiv).animate({'marginLeft':-widthIssue*currentIndex},{queue:false, duration:settings.issuesSpeed});
					/*$(settings.id_control).height($(settings.id_control+' '+settings.issuesDiv+' '+li_cur).height() + 110);*/
				} else if(settings.orientation == 'vertical') {
					var totalheight = 0;
					var $pl_h = 245;
					if($(settings.id_control+' '+settings.issuesDiv+' '+li_cur).height() > 365){
						$pl_h =0;
						$(settings.id_control).height($(settings.id_control+' '+settings.issuesDiv+' '+li_cur).height());
					}
					if(currentIndex > 0){
						$(settings.id_control+' '+settings.issuesDiv+' '+li_cur).prevAll().each(function(index) {
							totalheight += parseInt($(this).height(), 10);
						});
					}
					if(currentIndex!=0){
						$(settings.id_control+' '+settings.issuesDiv).animate({'marginTop':-totalheight + $pl_h},{queue:false, duration:settings.issuesSpeed});
					}else{
						$(settings.id_control+' '+settings.issuesDiv).animate({'marginTop':0},{queue:false, duration:settings.issuesSpeed});
					}
					/*//-- add by exthemes --//*/
					$(window).resize(function() {
						var totalheight = 0;
						$pl_h =0;
						if($(settings.id_control+' '+settings.issuesDiv+' '+li_cur).height() > 365){
							$(settings.id_control).height($(settings.id_control+' '+settings.issuesDiv+' '+li_cur).height());
						}
						if(currentIndex > 0){
							$(settings.id_control+' '+settings.issuesDiv+' '+li_cur).prevAll().each(function(index) {
								totalheight += parseInt($(this).height(), 10);
							});
						}
						if(currentIndex!=0){
							$(settings.id_control+' '+settings.issuesDiv).animate({'marginTop':-totalheight + $pl_h},{queue:false, duration:settings.issuesSpeed});
						}else{
							$(settings.id_control+' '+settings.issuesDiv).animate({'marginTop':0},{queue:false, duration:settings.issuesSpeed});
						}
					});
					/*//-- end --//*/
				}
				$(settings.id_control+' '+settings.issuesDiv+' > li').animate({'opacity':settings.issuesTransparency},{queue:false, duration:settings.issuesSpeed}).removeClass(settings.issuesSelectedClass).eq(currentIndex).addClass(settings.issuesSelectedClass).fadeTo(settings.issuesTransparencySpeed,1);
				/*// prev/next buttons now disappears on first/last issue | bugfix from 0.9.51: lower than 1 issue hide the arrows | bugfixed: arrows not showing when jumping from first to last date*/
				if(howManyDates == 1) {
					$(settings.id_control+' '+settings.prevButton+','+settings.nextButton).addClass('wptl-disable');
				} else if(howManyDates == 2) {
					if($(settings.id_control+' '+settings.issuesDiv+' li:first-child').hasClass(settings.issuesSelectedClass)) {
						$(settings.id_control+' '+settings.prevButton).addClass('wptl-disable');
						$(settings.id_control+' '+settings.nextButton).removeClass('wptl-disable');
					}
					else if($(settings.id_control+' '+settings.issuesDiv+' li:last-child').hasClass(settings.issuesSelectedClass)) {
						$(settings.id_control+' '+settings.nextButton).addClass('wptl-disable');
						$(settings.id_control+' '+settings.prevButton).removeClass('wptl-disable');
					}
				} else {
					if( $(settings.id_control+' '+settings.issuesDiv+' li:first-child').hasClass(settings.issuesSelectedClass) ) {
						$(settings.id_control+' '+settings.nextButton).removeClass('wptl-disable');
						$(settings.id_control+' '+settings.prevButton).addClass('wptl-disable');
					}
					else if( $(settings.id_control+' '+settings.issuesDiv+' li:last-child').hasClass(settings.issuesSelectedClass) ) {
						$(settings.id_control+' '+settings.prevButton).removeClass('wptl-disable');
						$(settings.id_control+' '+settings.nextButton).addClass('wptl-disable');
					}
					else {
						$(settings.id_control+' '+settings.prevButton).removeClass('wptl-disable');
						$(settings.id_control+' '+settings.nextButton).removeClass('wptl-disable');
						$(settings.id_control+' '+settings.nextButton+','+settings.prevButton).fadeIn('slow');
					}
				}
				/*// now moving the dates*/
				$(settings.id_control+' '+settings.datesDiv+' a').removeClass(settings.datesSelectedClass);
				$(this).addClass(settings.datesSelectedClass);
				/*//add by exthemes*/
				$(this).parent().prevAll().addClass('tl-old-item');
				$(this).parent().nextAll().removeClass('tl-old-item');
				
				if(settings.orientation == 'horizontal') {
					$(settings.id_control+' '+settings.datesDiv).animate({'marginLeft':defaultPositionDates-(widthDate*currentIndex)},{queue:false, duration:'settings.datesSpeed'});
					/*// add by exthemes*/
					var pos_act = defaultPositionDates + (widthDate/2);
					/*//var pos_act = $(settings.id_control).width()/2;
					//console.log(defaultPositionDates);*/
					$(settings.id_control+' .tl-date .timeline-pos-select').animate({'width':pos_act},{queue:false, duration:'settings.datesSpeed'});
					$(window).resize(function() {
						$(settings.id_control+' '+settings.datesDiv).animate({'marginLeft':defaultPositionDates-(widthDate*currentIndex)},{queue:false, duration:'settings.datesSpeed'});
						var pos_act = defaultPositionDates + (widthDate/2);
						$(settings.id_control+' .tl-date .timeline-pos-select').animate({'width':pos_act},{queue:false, duration:'settings.datesSpeed'});
					});
					/*//$(settings.id_control+' .tl-date .timeline-pos-select').width(defaultPositionDates-(widthDate*currentIndex) + 50);*/
				} else if(settings.orientation == 'vertical') {
					/*//console.log($(settings.id_control+' '+settings.issuesDiv+' li.selected').height());
					//$(settings.id_control).height($(settings.id_control+' '+settings.issuesDiv+' li.selected').height());*/
					var pli_cur = ' li:nth-child('+(currentIndex+1)+')';
					var ptotalheight = 0;
					if(currentIndex > 0){
						$(settings.id_control+' '+settings.datesDiv+' '+li_cur).prevAll().each(function(index) {
							ptotalheight += parseInt($(this).height(), 10);
						});
						var ver_hi = $(settings.id_control).height()/2;
						$(settings.id_control+' '+settings.datesDiv).animate({'marginTop':ver_hi-(ptotalheight) -90 },{queue:false, duration:'settings.datesSpeed'});
						
						var pos_act = $(settings.id_control).height()/2 - 40;
						$(settings.id_control+' .tl-date .timeline-pos-select').animate({'height':pos_act},{queue:false, duration:'settings.datesSpeed'});
					}else{
						$(settings.id_control+' '+settings.datesDiv).animate({'marginTop': 0 },{queue:false, duration:'settings.datesSpeed'});
						$(settings.id_control+' .tl-date .timeline-pos-select').animate({'height':50},{queue:false, duration:'settings.datesSpeed'});
					}
					$(window).resize(function() {
						var pli_cur = ' li:nth-child('+(currentIndex+1)+')';
						var ptotalheight = 0;
						if(currentIndex > 0){
							$(settings.id_control+' '+settings.datesDiv+' '+li_cur).prevAll().each(function(index) {
								ptotalheight += parseInt($(this).height(), 10);
							});
							var ver_hi = $(settings.id_control).height()/2;
							$(settings.id_control+' '+settings.datesDiv).animate({'marginTop':ver_hi-(ptotalheight) -90 },{queue:false, duration:'settings.datesSpeed'});
							var pos_act = $(settings.id_control).height()/2 - 40;
							$(settings.id_control+' .tl-date .timeline-pos-select').animate({'height':pos_act},{queue:false, duration:'settings.datesSpeed'});
						}else{
							$(settings.id_control+' '+settings.datesDiv).animate({'marginTop': 0 },{queue:false, duration:'settings.datesSpeed'});
							$(settings.id_control+' .tl-date .timeline-pos-select').animate({'height':50},{queue:false, duration:'settings.datesSpeed'});
						}
					});
				}
			});
			$(settings.id_control+' '+settings.nextButton).bind('click', function(event){
				event.preventDefault();
				/*// bugixed from 0.9.54: now the dates gets centered when there's too much dates.*/
				var currentIndex = $(settings.id_control+' '+settings.issuesDiv).find('li.'+settings.issuesSelectedClass).index();
				if(settings.orientation == 'horizontal') {
					var currentPositionIssues = parseInt($(settings.id_control+' '+settings.issuesDiv).css('marginLeft').substring(0,$(settings.id_control+' '+settings.issuesDiv).css('marginLeft').indexOf('px')));
					var currentIssueIndex = currentPositionIssues/widthIssue;
					var currentPositionDates = parseInt($(settings.id_control+' '+settings.datesDiv).css('marginLeft').substring(0,$(settings.id_control+' '+settings.datesDiv).css('marginLeft').indexOf('px')));
					var currentIssueDate = currentPositionDates-widthDate;
					if(currentPositionIssues <= -(widthIssue*howManyIssues-(widthIssue))) {
						$(settings.id_control+' '+settings.issuesDiv).stop();
						$(settings.id_control+' '+settings.datesDiv+' li:last-child a').click();
					} else {
						if (!$(settings.id_control+' '+settings.issuesDiv).is(':animated')) {
							/*// bugixed from 0.9.52: now the dates gets centered when there's too much dates.*/
							$(settings.id_control+' '+settings.datesDiv+' li').eq(currentIndex+1).find('a').trigger('click');
						}
					}
				} else if(settings.orientation == 'vertical') {
					var currentPositionIssues = parseInt($(settings.id_control+' '+settings.issuesDiv).css('marginTop').substring(0,$(settings.id_control+' '+settings.issuesDiv).css('marginTop').indexOf('px')));
					var currentIssueIndex = currentPositionIssues/heightIssue;
					var currentPositionDates = parseInt($(settings.id_control+' '+settings.datesDiv).css('marginTop').substring(0,$(settings.id_control+' '+settings.datesDiv).css('marginTop').indexOf('px')));
					var currentIssueDate = currentPositionDates-heightDate;
					if(currentPositionIssues <= -(heightIssue*howManyIssues-(heightIssue))) {
						$(settings.id_control+' '+settings.issuesDiv).stop();
						$(settings.id_control+' '+settings.datesDiv+' li:last-child a').click();
					} else {
						if (!$(settings.id_control+' '+settings.issuesDiv).is(':animated')) {
							/*// bugixed from 0.9.54: now the dates gets centered when there's too much dates.*/
							$(settings.id_control+' '+settings.datesDiv+' li').eq(currentIndex+1).find('a').trigger('click');
						}
					}
				}
				/*// prev/next buttons now disappears on first/last issue | bugfix from 0.9.51: lower than 1 issue hide the arrows*/
				if(howManyDates == 1) {
					$(settings.id_control+' '+settings.prevButton+','+settings.nextButton).addClass('wptl-disable');
				} else if(howManyDates == 2) {
					if($(settings.id_control+' '+settings.issuesDiv+' li:first-child').hasClass(settings.issuesSelectedClass)) {
						$(settings.id_control+' '+settings.prevButton).addClass('wptl-disable');
						$(settings.id_control+' '+settings.nextButton).removeClass('wptl-disable');
					}
					else if($(settings.id_control+' '+settings.issuesDiv+' li:last-child').hasClass(settings.issuesSelectedClass)) {
						$(settings.id_control+' '+settings.nextButton).addClass('wptl-disable');
						$(settings.id_control+' '+settings.prevButton).removeClass('wptl-disable');
					}
				} else {
					if( $(settings.id_control+' '+settings.issuesDiv+' li:first-child').hasClass(settings.issuesSelectedClass) ) {
						$(settings.id_control+' '+settings.prevButton).addClass('wptl-disable');
					}
					else if( $(settings.id_control+' '+settings.issuesDiv+' li:last-child').hasClass(settings.issuesSelectedClass) ) {
						$(settings.id_control+' '+settings.nextButton).addClass('wptl-disable');
					}
					else {
						$(settings.id_control+' '+settings.nextButton+','+settings.prevButton).removeClass('wptl-disable');
					}
				}
			});
		
			$(settings.id_control+' '+settings.prevButton).click(function(event){
				event.preventDefault();
				/*// bugixed from 0.9.54: now the dates gets centered when there's too much dates.*/
				var currentIndex = $(settings.id_control+' '+settings.issuesDiv).find('li.'+settings.issuesSelectedClass).index();
				if(settings.orientation == 'horizontal') {
					var currentPositionIssues = parseInt($(settings.id_control+' '+settings.issuesDiv).css('marginLeft').substring(0,$(settings.id_control+' '+settings.issuesDiv).css('marginLeft').indexOf('px')));
					var currentIssueIndex = currentPositionIssues/widthIssue;
					var currentPositionDates = parseInt($(settings.id_control+' '+settings.datesDiv).css('marginLeft').substring(0,$(settings.id_control+' '+settings.datesDiv).css('marginLeft').indexOf('px')));
					var currentIssueDate = currentPositionDates+widthDate;
					if(currentPositionIssues >= 0) {
						$(settings.id_control+' '+settings.issuesDiv).stop();
						$(settings.id_control+' '+settings.datesDiv+' li:first-child a').click();
					} else {
						if (!$(settings.id_control+' '+settings.issuesDiv).is(':animated')) {
							/*// bugixed from 0.9.54: now the dates gets centered when there's too much dates.*/
							$(settings.id_control+' '+settings.datesDiv+' li').eq(currentIndex-1).find('a').trigger('click');
						}
					}
				} else if(settings.orientation == 'vertical') {
					var currentPositionIssues = parseInt($(settings.id_control+' '+settings.issuesDiv).css('marginTop').substring(0,$(settings.id_control+' '+settings.issuesDiv).css('marginTop').indexOf('px')));
					var currentIssueIndex = currentPositionIssues/heightIssue;
					var currentPositionDates = parseInt($(settings.id_control+' '+settings.datesDiv).css('marginTop').substring(0,$(settings.id_control+' '+settings.datesDiv).css('marginTop').indexOf('px')));
					var currentIssueDate = currentPositionDates+heightDate;
					if(currentPositionIssues >= 0) {
						$(settings.id_control+' '+settings.issuesDiv).stop();
						$(settings.id_control+' '+settings.datesDiv+' li:first-child a').click();
					} else {
						if (!$(settings.id_control+' '+settings.issuesDiv).is(':animated')) {
							/*// bugixed from 0.9.54: now the dates gets centered when there's too much dates.*/
							$(settings.id_control+' '+settings.datesDiv+' li').eq(currentIndex-1).find('a').trigger('click');
						}
					}
				}
				/*// prev/next buttons now disappears on first/last issue | bugfix from 0.9.51: lower than 1 issue hide the arrows*/
				if(howManyDates == 1) {
					$(settings.id_control+' '+settings.prevButton+','+settings.id_control+' '+settings.nextButton).addClass('wptl-disable');
				} else if(howManyDates == 2) {
					if($(settings.id_control+' '+settings.issuesDiv+' li:first-child').hasClass(settings.issuesSelectedClass)) {
						$(settings.id_control+' '+settings.prevButton).addClass('wptl-disable');
						$(settings.id_control+' '+settings.nextButton).removeClass('wptl-disable');
					}
					else if($(settings.id_control+' '+settings.issuesDiv+' li:last-child').hasClass(settings.issuesSelectedClass)) {
						$(settings.id_control+' '+settings.nextButton).addClass('wptl-disable');
						$(settings.id_control+' '+settings.prevButton).removeClass('wptl-disable');
					}
				} else {
					if( $(settings.id_control+' '+settings.issuesDiv+' li:first-child').hasClass(settings.issuesSelectedClass) ) {
						$(settings.id_control+' '+settings.prevButton).addClass('wptl-disable');
					}
					else if( $(settings.id_control+' '+settings.issuesDiv+' li:last-child').hasClass(settings.issuesSelectedClass) ) {
						$(settings.id_control+' '+settings.nextButton).addClass('wptl-disable');
					}
					else {
						$(settings.id_control+' '+settings.nextButton+','+settings.id_control+' '+settings.prevButton).removeClass('wptl-disable');
					}
				}
			});
			/*// keyboard navigation, added since 0.9.1*/
			if(settings.arrowKeys=='true') {
				if(settings.orientation=='horizontal') {
					$(document).keydown(function(event){
						if (event.keyCode == 39) {
						   $(settings.id_control+' '+settings.nextButton).click();
						}
						if (event.keyCode == 37) {
						   $(settings.id_control+' '+settings.prevButton).click();
						}
					});
				} else if(settings.orientation=='vertical') {
					$(document).keydown(function(event){
						if (event.keyCode == 40) {
						   $(settings.id_control+' '+settings.nextButton).click();
						}
						if (event.keyCode == 38) {
						   $(settings.id_control+' '+settings.prevButton).click();
						}
					});
				}
			}
			/*// default position startAt, added since 0.9.3*/
			$(settings.id_control+' '+settings.datesDiv+' li').eq(settings.startAt-1).find('a').trigger('click');
			/*// autoPlay, added since 0.9.4*/
			if(settings.autoPlay == true) {
				setInterval(function(){
					if($(settings.id_control).is(":hover")){
					}else{
						wptl_autoPlay(settings);
					};
				}, settings.autoPlayPause);
				
			}
		}
	
	}
	function wptl_autoPlay(settings){
		var currentDate = jQuery(settings.id_control+' '+settings.datesDiv).find('a.'+settings.datesSelectedClass);
		if(settings.autoPlayDirection == 'forward') {
			if(currentDate.parent().is('li:last-child')) {
				jQuery(settings.id_control+' '+settings.datesDiv+' li:first-child').find('a').trigger('click');
			} else {
				currentDate.parent().next().find('a').trigger('click');
			}
		} else if(settings.autoPlayDirection == 'backward') {
			if(currentDate.parent().is('li:first-child')) {
				jQuery(settings.id_control+' '+settings.datesDiv+' li:last-child').find('a').trigger('click');
			} else {
				currentDate.parent().prev().find('a').trigger('click');
			}
		}
	}
}(jQuery));

