<?php
/*
Plugin Name: iSpam
Description: iSpam Plugin ist a WordPress Spamming system for Control your Spams.
Version: 1.0
Author: Keyvan Hardani / iAppi.de Softwareentwicklung
Author URI: http://www.iappi.de
*/

//options initialization
add_option('dc_sp_database_version', "0");//database version
add_option('dc_sp_time_delay', "15" );//Time delay
add_option('dc_sp_time_max', "1200" );//Time delay
add_option('dc_sp_custom_message',"Please wait few seconds or refresh the page.");


//embedding external files
require_once('clouds/api.php');
require_once('clouds/set_ini.php');
require_once('clouds/logs.php');
require_once('clouds/parse_class.php');
require_once('clouds/ispam_spams.php');
require_once('clouds/ispam_options.php');

//create the Spam Protection menu
add_action( 'admin_menu', 'dc_sp_admin_menu' );
function dc_sp_admin_menu() {
	
	$form_name='iSpam';
	
	//main menu
	add_menu_page($form_name, $form_name, 'manage_options', 'ispam_spams','ispam_blocked');
	
	//SPAM - Child of menu_spam - Visible
	add_submenu_page('ispam_spams', $form_name.' - Spam', 'Spam Folder', 'manage_options', 'ispam_spams', 'ispam_blocked');
	
	//OPTIONS - Child of MENU_SPAM - Visible
	add_submenu_page('ispam_spams', $form_name.' - Options', 'Properties', 'manage_options', 'ispam_properties', 'ispam_properties');	
	
}

//delete options when the plugin is uninstalled
register_uninstall_hook( __FILE__, 'dc_sp_uninstall' );
function dc_sp_uninstall(){
	
	//deleting tables
	global $wpdb;
	
	$table_name=$wpdb->prefix . "dc_sp_log";
	$sql = "DROP TABLE $table_name";
	mysql_query($sql);
	
	$table_name=$wpdb->prefix . "dc_sp_spam";
	$sql = "DROP TABLE $table_name";
	mysql_query($sql);
	
	//deleting options
	delete_option('dc_sp_database_version');
	delete_option('dc_sp_time_delay');
	delete_option('dc_sp_custom_message');
	delete_option('dc_sp_time_max');
	
}

?>