<?php
	
	
	add_action('admin_menu', 'hw_uploadDirLimit_add_submenu_page');
	
	function hw_uploadDirLimit_add_submenu_page(){
		register_setting( 'general', 'hw_upload_dir_limit' );
		
		add_settings_field(
			'hw_upload_dir_limit',
			'Upload Dir Limit',
			'hw_uploadDirLimit_options',
			'general',
			'default'
		);
	}
	
	function hw_uploadDirLimit_options(){
		$option_name = 'hw_upload_dir_limit';
		echo '<input type="number" name="'.$option_name.'" id="hw_upload_dir_limit" value="'.esc_attr( get_option($option_name) ).'" /> Mb<br>Current Upload Dir Size: <b>'.hw_uploadDirLimit_formatSize(hw_uploadDirLimit_getUploadSize()).'</b>';
	}
	
	
	add_filter('wp_handle_upload_prefilter', 'custom_upload_filter' );
	
	function custom_upload_filter( $file ){
		$limit = intval(get_option('hw_upload_dir_limit')) * 1024 * 1024;
		$size = hw_uploadDirLimit_getUploadSize();
		if($limit > 1 && $limit <= $size) die;
		return $file;
	}