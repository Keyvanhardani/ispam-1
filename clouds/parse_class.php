<?php

add_action('pre_comment_on_post','dc_sp_pre_comment_check');

function dc_sp_pre_comment_check(){
	
	//get the current data
	$dc_sp_post_id = $_POST['comment_post_ID'];
	$dc_sp_user_ip = substr(trim($_SERVER['REMOTE_ADDR']),0,39);
	$dc_sp_time = time();	
	$dc_sp_time_max = time() - abs( intval( get_option('dc_sp_time_max') ) );;
	$dc_sp_time_delay = time() - abs( intval( get_option('dc_sp_time_delay') ) );
	$dc_sp_comment_date = current_time('mysql');
	$dc_sp_comment_date_gmt = current_time('mysql', True );
	$dc_sp_comment_content = $_POST['comment'];	
		
	//delete all the log older than time_max
	global $wpdb;
	$table_name=$wpdb->prefix."dc_sp_log";
	$safe_sql = $wpdb->prepare("DELETE FROM $table_name WHERE time < %d ", $dc_sp_time_max);
	$wpdb->query($safe_sql);	
	
	//compare this data with the saved data in the database
	//if the user has visited this specific page or post using the same ip for at least 10 seconds go on
	$table_name=$wpdb->prefix."dc_sp_log";
	$safe_sql = $wpdb->prepare("SELECT id FROM $table_name WHERE post_id = %d AND user_ip = %s AND time < %d ", $dc_sp_post_id , $dc_sp_user_ip, $dc_sp_time_delay );
	$results = $wpdb->get_results($safe_sql, ARRAY_A);	
	
	if( count($results) == 0 ){
	
		//save spam into the database
		$table_name=$wpdb->prefix."dc_sp_spam";
		$safe_sql = $wpdb->prepare("INSERT INTO $table_name SET post_id= %d , user_ip= %s , date= %s , date_gmt= %s , content = %s ", $dc_sp_post_id, $dc_sp_user_ip, $dc_sp_comment_date, $dc_sp_comment_date_gmt, $dc_sp_comment_content);
		$wpdb->query($safe_sql);	
		
		//die and echo this message
		wp_die( esc_attr( stripslashes ( get_option('dc_sp_custom_message') ) ) );
		
	}
		
}

?>