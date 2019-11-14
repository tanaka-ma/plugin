<?php

/*
Plugin Name: tkama_gtm-read-end
Plugin URI: https://tanakama.jp
Description: 記事の最後に読了のid付き画像を追加
Version: 1.0.0
Author:tanakama
Author URI: https://tanakama.jp
License: GPL2
*/


if ( !defined( 'ABSPATH' ) ) exit;

if (!class_exists('tkama_gtm_read_end')):


class tkama_gtm_read_end {

	function __construct() {
		add_filter('the_content',array($this, 'ab_class'));
	}
	
	
	//記事の最後に計測用のHTMLを挿入
	function ab_class( $content ) {
		    
		$spacer_path = plugins_url( '', __FILE__ ).'/images/tkama_gtm-spacer.gif';

		$end = '<div style="width:10px;height:1px;"><img src="'.$spacer_path.'" alt="" width="10" height="1" id="read-end" /></div>';
		
	return $path.$content.$end;

	}
	
	
}//END class
new tkama_gtm_read_end;
endif;



