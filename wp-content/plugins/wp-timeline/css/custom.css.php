<?php
$wptl_main_color = get_option('wptl_main_color');
if($wptl_main_color !=''){?>
	.wpex-filter > .fa,
    .wpex-endlabel.wpex-loadmore span, .wpex-tltitle.wpex-loadmore span, .wpex-loadmore .loadmore-timeline,
    .wpex-timeline-list.show-icon .wpex-timeline > li:after, .wpex-timeline-list.show-icon .wpex-timeline > li:first-child:before,
    .wpex-tl-horizontal #next:not(.wptl-disable):hover, .wpex-tl-horizontal #prev:not(.wptl-disable):hover,
    .wpex-tl-horizontal .wpex-dates li a.selected:before,
    .wpex-tl-vertical .wpex-dates li a.selected,
    .wpex-timeline-list.show-icon .wpex-timeline.style-center > li .wpex-content-left .wpex-leftdate,
    .wpex-timeline-list.show-icon li .wpex-timeline-icon .fa,
    .wpex .timeline-details .wptl-readmore > a:hover,
    .wpex.wpex-tl-vertical #next:hover, .wpex.wpex-tl-vertical #prev:hover,
    .wpex-spinner > div,
    .wpex.horizontal-timeline .ex_s_lick-prev:hover, .wpex.horizontal-timeline .ex_s_lick-next:hover,
    .wpex.horizontal-timeline .horizontal-content .ex_s_lick-next:hover,
    .wpex.horizontal-timeline .horizontal-content .ex_s_lick-prev:hover,
    .wpex.horizontal-timeline .horizontal-nav li.ex_s_lick-current a:before,
    .wpex.horizontal-timeline.tl-hozsteps .horizontal-nav li.ex_s_lick-current a i,
    .timeline-navigation a.btn,
    .timeline-navigation div > a,
    .wpex.horizontal-timeline.ex-multi-item .horizontal-nav li a:before,
    .wpex.horizontal-timeline.ex-multi-item .horizontal-nav li.ex_s_lick-current a:before,
    .wpex.wpex-horizontal-3.ex-multi-item .horizontal-nav  h2 a,
    .wpex-timeline-list:not(.show-icon) .wptl-feature-name span,
    .wpex.horizontal-timeline.ex-multi-item:not(.wpex-horizontal-4) .horizontal-nav li a.wpex_point,
    .wpex.horizontal-timeline.ex-multi-item:not(.wpex-horizontal-4) .horizontal-nav li a.wpex_point,
    .wpex-timeline > li .wpex-timeline-icon .fa{ background:<?php echo esc_html($wptl_main_color);?>}
    .wpex-timeline-list.show-icon li .wpex-timeline-icon .fa:before,
    .wpex-filter span.active,
    .wpex-tl-vertical #next, .wpex-tl-vertical #prev,
    .wpex-tl-horizontal.arrow-top #next, .wpex-tl-horizontal.arrow-top #prev,
    .wpex-timeline-list .wpex-taxonomy-filter a:hover, .wpex-timeline-list .wpex-taxonomy-filter a.active,
    .wpex.horizontal-timeline .ex_s_lick-prev, .wpex.horizontal-timeline .ex_s_lick-next,
    .wpex.horizontal-timeline.tl-hozsteps .horizontal-nav li.prev_item:not(.ex_s_lick-current) a i,
    .wpex.horizontal-timeline.ex-multi-item .horizontal-nav li a.wpex_point i,
    .wpex-timeline > li .wpex-timeline-time span:last-child{ color:<?php echo esc_html($wptl_main_color);?>}
    .wpex-tl-horizontal.arrow-top #next, .wpex-tl-horizontal.arrow-top #prev,
    .wpex .timeline-details .wptl-readmore > a,
    .wpex-tl-vertical .timeline-pos-select,
    .wpex-tl-vertical .wpex-dates li.tl-old-item a,
    .wpex-tl-horizontal .wpex-dates li a.selected:before,
    .wpex-tl-horizontal .timeline-pos-select,
    .wpex-tl-horizontal .wpex-dates li a:hover:before,
    .wpex-tl-horizontal #next:not(.wptl-disable):hover, .wpex-tl-horizontal #prev:not(.wptl-disable):hover,
    .wpex-tl-vertical #next, .wpex-tl-vertical #prev,
    .wpex-tl-horizontal .wpex-dates li.tl-old-item a:before,
    .wpex.horizontal-timeline .ex_s_lick-prev:hover, .wpex.horizontal-timeline .ex_s_lick-next:hover,
    .wpex.horizontal-timeline .horizontal-content .ex_s_lick-next:hover,
    .wpex.horizontal-timeline .horizontal-content .ex_s_lick-prev:hover,
    .wpex.horizontal-timeline .horizontal-nav li.ex_s_lick-current a:before,
    .wpex.horizontal-timeline .ex_s_lick-prev, .wpex.horizontal-timeline .ex_s_lick-next,
    .wpex.horizontal-timeline .timeline-pos-select,
    .wpex.horizontal-timeline .horizontal-nav li.prev_item a:before,
    .wpex.horizontal-timeline.tl-hozsteps .horizontal-nav li.ex_s_lick-current a i,
    .wpex.horizontal-timeline.tl-hozsteps .timeline-hr, .wpex.horizontal-timeline.tl-hozsteps .timeline-pos-select,
    .wpex.horizontal-timeline.tl-hozsteps .horizontal-nav li.prev_item a i,
    .wpex-timeline-list.left-tl.show-icon .wptl-feature-name,
    .wpex-timeline-list.show-icon .wptl-feature-name span,
    .wpex.horizontal-timeline.ex-multi-item .horizontal-nav li a.wpex_point i,
    .wpex.horizontal-timeline.ex-multi-item.wpex-horizontal-4 .wpextt_templates .wptl-readmore a,
    .wpex.wpex-horizontal-3.ex-multi-item .horizontal-nav .wpextt_templates .wptl-readmore a,
    .wpex-tl-vertical .wpex-dates li a.selected{border-color: <?php echo esc_html($wptl_main_color);?>;}
    .wpex-timeline > li .wpex-timeline-label:before,
    .wpex-timeline-list.show-icon .wpex-timeline.style-center > li .wpex-timeline-label:after
    {border-right-color: <?php echo esc_html($wptl_main_color);?>;}
    .wpex-filter span,
    .wpex-timeline > li .wpex-timeline-label{border-left-color: <?php echo esc_html($wptl_main_color);?>;}
    .wpex.horizontal-timeline.ex-multi-item:not(.wpex-horizontal-4) .horizontal-nav li a.wpex_point:after{border-top-color: <?php echo esc_html($wptl_main_color);?>;}
    .wpex.wpex-horizontal-3.ex-multi-item .wpex-timeline-label .timeline-details:after{border-bottom-color: <?php echo esc_html($wptl_main_color);?>;}
    @media (min-width: 768px){
        .wpex-timeline.style-center > li:nth-child(odd) .wpex-timeline-label{border-right-color: <?php echo esc_html($wptl_main_color);?>;}
        .wpex-timeline.style-center > li:nth-child(odd) .wpex-timeline-label:before,
        .wpex-timeline-list.show-icon .style-center > li:nth-child(odd) .wpex-timeline-label:after{border-left-color: <?php echo esc_html($wptl_main_color);?>;}
    }
	<?php 
    $wpex_rtl_mode = get_option('wpex_rtl_mode');
    if($wpex_rtl_mode=='yes'){?>
        .left-tl:not(.show-icon) .wpex-timeline > li .wpex-timeline-label{border-right-color: <?php echo esc_html($wptl_main_color);?>;}
        .left-tl .wpex-timeline > li .wpex-timeline-label:before{border-left-color: <?php echo esc_html($wptl_main_color);?>;}
        <?php
    }
}
$wptl_fontfamily = get_option('wptl_fontfamily');
if($wptl_fontfamily !=''){?>
	.wpex-timeline-list,
    .wpex .wptl-excerpt,
    .wpex-single-timeline,
	.wpex{font-family: "<?php echo esc_html($wptl_fontfamily);?>", sans-serif;}
<?php 
}
$wptl_fontsize = get_option('wptl_fontsize');
if($wptl_fontsize !=''){?>
    .wpex-timeline-list,
    .wpex .wptl-excerpt,
    .wpex-single-timeline,
	.wpex,
    .wpex-timeline > li .wpex-timeline-label{font-size:<?php echo esc_html($wptl_fontsize);?>;}
<?php 
}

$wpex_hfont = get_option('wpex_hfont');
if($wpex_hfont !=''){?>
	.wpex-single-timeline h1.tl-title,
	.wpex-timeline-list.show-icon li .wpex-content-left,
    .wpex-timeline-list .wptl-feature-name span,
    .wpex .wpex-dates a, .wpex h2, .wpex h2 a, .wpex .timeline-details h2,
    .wpex-timeline > li .wpex-timeline-time span:last-child,
    .wpex .timeline-details h2{font-family: "<?php echo esc_html($wpex_hfont);?>", sans-serif;}
<?php 
}

$wpex_hfontsize = get_option('wpex_hfontsize');
if($wpex_hfontsize !=''){?>
	.wpex-single-timeline h1.tl-title,
    .wpex-timeline-list .wptl-feature-name span,
    .wpex-timeline > li .wpex-timeline-time span:last-child,
	.wpex h2, .wpex h2 a, .wpex .timeline-details h2, .wpex .timeline-details h2{font-size: <?php echo esc_html($wpex_hfontsize);?>;}
<?php 
}

$wpex_metafont = get_option('wpex_metafont');
if($wpex_metafont !=''){?>
	.wptl-more-meta span a, .wptl-more-meta span,
	.wpex-endlabel.wpex-loadmore span, .wpex-tltitle.wpex-loadmore span, .wpex-loadmore .loadmore-timeline,
    .wpex-timeline > li .wpex-timeline-label,
    .wpex .timeline-details .wptl-readmore > a,
    .wpex-timeline > li .wpex-timeline-time span.info-h,
	li .wptl-readmore-center > a{font-family: "<?php echo esc_html($wpex_metafont);?>", sans-serif;}
<?php 
}
$wpex_matafontsize = get_option('wpex_matafontsize');
if($wpex_matafontsize !=''){?>
	.wptl-more-meta span a, .wptl-more-meta span,
	.wpex-endlabel.wpex-loadmore span, .wpex-tltitle.wpex-loadmore span, .wpex-loadmore .loadmore-timeline,
    .wpex-timeline > li .wpex-timeline-time span.info-h,
    .wpex .timeline-details .wptl-readmore > a,
	li .wptl-readmore-center > a{font-size: <?php echo esc_html($wpex_matafontsize);?>;}
<?php 
}
$wpex_disable_link = get_option('wpex_disable_link');
if($wpex_disable_link=='yes'){?>
	.timeline-media > a{display: inline-block; box-shadow: none;}
    .wpex-timeline > li .wpex-timeline-label h2 a,
    .wpex-timeline-icon > a,
    .wpex.horizontal-timeline .wpex-timeline-label h2 a,
    .timeline-media > a, time.wpex-timeline-time > a, .wpex-leftdate + a, a.img-left { pointer-events: none;} .wptl-readmore-center, .wptl-readmore { display: none !important;} 
    <?php
}
//.wpex.horizontal-timeline.tl-hozsteps .horizontal-nav li.prev_item:not(.ex_s_lick-current) a i {
//    border-color: #EEEEEE;
//    color: #7d7d7d;
//}

$wpex_custom_css = get_option('wpex_custom_css');
if($wpex_custom_css!=''){
	echo $wpex_custom_css;
}