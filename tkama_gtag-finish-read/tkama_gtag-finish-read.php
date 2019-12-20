<?php

/*
Plugin Name: tkama_gtag-finish-read
Plugin URI: https://tanakama.jp/wordpress/plugin/gtag-finish-read-plugin.html
Description: 読了率のイベントをGoogleアナリティクスに送信
Version: 1.0.0
Author:tanakama
Author URI: https://tanakama.jp
License: GPL2
*/


if ( !defined( 'ABSPATH' ) ) exit;


if (!class_exists('tkama_gtag_finish_read')):

class tkama_gtag_finish_read {

	
	function __construct() {
		add_filter('the_content',array($this, 'ab_class'));
		add_filter('wp_footer',array($this, 'gtag_finish_read'),9999);
	}
	
	
	//記事の最後に計測用のHTMLを挿入
	function ab_class( $content ) {
		    
		$spacer_path = plugins_url( '', __FILE__ ).'/images/tkama_gtm-spacer.gif';

		$end = '<div style="width:10px;height:1px;"><img src="'.$spacer_path.'" alt="" width="10" height="1" id="read-end" /></div>';
		
		return $path.$content.$end;

	}
	
	
	//wp_footerに読了計測のgtagを挿入
	function gtag_finish_read() {
		
		if ( is_singular() ) {
			
		$gtag = <<<EOM
<script>
(function(){gtag("event",location.href,{event_category:"読了",event_label:"読了数",non_interaction:true,value:"0"});var c=document.getElementById("read-end");var b=c.getBoundingClientRect();var a=b.y;var e;function d(){if(!window.flag){if(e){return}e=setTimeout(function(){e=0;var i=document.documentElement||document.body.parentNode||document.body;var g=i.clientHeight;var h=window.pageYOffset||document.documentElement.scrollTop;var f=g+h;if(f>a){gtag("event",location.href,{event_category:"読了",event_label:"読了数",non_interaction:true,value:"1"});window.flag=true}else{}},1000)}}window.addEventListener("scroll",d,false)}());
</script>
EOM;

		echo $gtag;
			
		}
	}
	
	
}//END class
new tkama_gtag_finish_read;
endif;


