<?php

/*
Plugin Name: tkama_heading-add-link-id
Plugin URI: https://tanakama.jp
Description: 見出しにページ内リンク用のidを追加するプラグイン
Version: 1.0.0
Author:tanakama
Author URI: https://tanakama.jp
License: GPL2
*/

if ( !defined( 'ABSPATH' ) ) exit;

if (!class_exists('tanakama_anchor_link_id')):

class tanakama_add_heading_id {
	
	function __construct() {
		add_action('save_post', array($this, 'add_heading_id'));
	}
	
	function add_heading_id( $post_id ) {
 
		//ループ防止
		remove_action( 'save_post', array($this, 'add_heading_id'));
	
		//リビジョンの自動保存時は無効
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}
	
		//記事フィールド読み込み
		$content = get_post_field('post_content', $post_id);

		$pattern = '/<h[2-6]([^>]*)>(.*?)<\/h[2-6]>/i';
		$pattern_id = '/id="hd-id-(.*?)"/i';
		
		preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER);
		preg_match_all( $pattern_id, $content, $matches_id, PREG_SET_ORDER);
	
		
		$matches_id_array = array();
		
		foreach ($matches_id as $key1 => $value1) {
				
			$matches_id_array[] = $value1[1];
				
		}


		if(!$i = max($matches_id_array)){
			$i = 0;
		}
		
		
		foreach( $matches as $element ){
				
			if(!preg_match('/id=/',$element[1])){

					$i++;
				
					$id = 'hd-id-' . $i;
				
					$chapter = preg_replace( '/<(h[2-6])([^>]*)>(.+?)<\/(h[2-6])>/i', '<$1$2 id="'.$id.'">$3</$4>', $element[0] );
					
					$element = $element[0];
				
					$content = str_replace( $element, $chapter, $content);

				}
				
			}

		
		wp_update_post( array( 'ID' => $post_id, 'post_content' => $content ) );
	
		//アクションフックを再セット
		add_action('save_post', array($this, 'add_heading_id'));
 
	}
	
	
}//END class
new tanakama_add_heading_id;
endif;
