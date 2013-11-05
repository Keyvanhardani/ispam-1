<?php

//save some user info with the wp_head hook
add_action('wp_head','dc_sp_save_log');

function dc_sp_save_log(){
	
	if( is_single() or is_page() ){
	
		$dc_sp_post_id = get_the_ID();
		$dc_sp_user_ip = substr(trim($_SERVER['REMOTE_ADDR']),0,39);
		$dc_sp_time = time();	
		
		global $wpdb;
		$table_name=$wpdb->prefix."dc_sp_log";
		$safe_sql = $wpdb->prepare("INSERT INTO $table_name SET post_id= %d , user_ip= %s , time= %d ", $dc_sp_post_id, $dc_sp_user_ip, $dc_sp_time);
		$wpdb->query($safe_sql);
	
	}	
	
}

?>