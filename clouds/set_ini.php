<?php

//hook
register_activation_hook(WP_PLUGIN_DIR.'/ispam/ispam.php','dc_sp_create_update_table');

//create or update tables
function dc_sp_create_update_table(){
	
	//check database version and create the database
	if( intval(get_option('dc_sp_database_version')) < 1 ){
	
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
		//create *prefix*_dc_sp_log
		global $wpdb;$table_name=$wpdb->prefix . "dc_sp_log";
		$sql = "CREATE TABLE $table_name (
		  id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  post_id BIGINT(20) DEFAULT 0,
		  user_ip VARCHAR(39) DEFAULT '',
		  time BIGINT(20) DEFAULT 0
		)
		COLLATE = utf8_general_ci
		";
		
		dbDelta($sql);
		
		//create *prefix*_dc_sp_spam
		global $wpdb;$table_name=$wpdb->prefix . "dc_sp_spam";
		$sql = "CREATE TABLE $table_name (
		  id BIGINT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  post_id BIGINT(20) DEFAULT 0,
		  user_ip VARCHAR(39) DEFAULT '',
		  content TEXT DEFAULT '',
		  date DATETIME,
		  date_gmt DATETIME
		)
		COLLATE = utf8_general_ci
		";
		
		dbDelta($sql);
		
		//Update database version
		update_option('dc_sp_database_version',"1");
	
	}
	
}

?>
