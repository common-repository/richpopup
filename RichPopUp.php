<?php
/*
Plugin Name: RichPopUp
Plugin URI: http://rich-blogger.com/
Description: RichPopUp
Author: Kamil Kwiecień
Version: 0.3
Author URI: http://rich-blogger.com/
*/


add_action('init', 'register_richpopup');

function register_richpopup()
{
    add_filter('wp_footer', 'add_post_content');

}


function add_post_content($content) {
	if(!is_feed() && !is_home()) {
		$content = '
		<style type="text/css">
		#popup_box { 
		display:none; 
		position:fixed; 
		_position:absolute; 
		height:220px;
		width:600px; 
		background:#FFF; 
		left: 50% ;
        margin-right: auto ;
		top:150px; 
		z-index:9999;
		margin-left:-310px;
		border:3px solid red; 
		font-size:18px;
		-moz-box-shadow:0 0 6px red; 
		-webkit-box-shadow:0 0 6px red; 
		box-shadow:0 0 6px red; 
		padding:15px; 
		}
		#popupBoxClose { 
		font-size:20px; 
		line-height:16px;
		right:5px; 
		top:5px; 
		position:absolute; 
		color:#6fa5e2; 
		font-weight:bold;
		}
		.rpu_link {
             line-height:22px;
		}
		</style>
		
		<script type="text/javascript">
			$(document).ready(function(){var keepClosed=false;addEvent(document,"mouseout",function(evt){if(evt.toElement==null&&evt.relatedTarget==null){loadPopupBox();}});function addEvent(obj,evt,fn){if(obj.addEventListener){obj.addEventListener(evt,fn,false);}else if(obj.attachEvent){obj.attachEvent("on"+evt,fn);}}$("#popupBoxClose").click(function(){keepClosed=true;unloadPopupBox();});$("#wrap").click(function(){keepClosed=true;unloadPopupBox();});function unloadPopupBox(){$("#popup_box").fadeOut("slow");$("#wrap").css({"opacity":"1"});}function loadPopupBox(){if(keepClosed==false){$("#wrap").css({"opacity":"0.3"});$("#popup_box").fadeIn("slow");}}});
		</script>	
			
		<div id="popup_box">
     		<a id="popupBoxClose"> Close </a>
			<h2>Take A Look At Those Recent Posts You May Have Missed</h2><br />';

		$args = array( 'numberposts' => '6' );
		$recent_posts = wp_get_recent_posts( $args );
		foreach( $recent_posts as $recent ){
			$content .= '- <a class="rpu_link" target="_new" href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a><br />';
		}

		$content .= '</div>';
		
	}
	echo $content;
}
