<?php
//Uninstall.php needs to be protected – 
//you don’t want someone viewing that file directly 
//and triggering an uninstall maliciously.

//Checking for WP_UNINSTALL_PLUGIN is enough for security
//WordPress defines this constant WP_UNINSTALL_PLUGIN just prior to loading 
//your un-install file.

if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) 
	exit();
	
    //delete any NEW tables that were created for example
    
	//global $wpdb;
    //$table_xyz = $wpdb->prefix . 'wcs_xyz';
    //$wpdb->query("DROP TABLE IF EXISTS $table_xyz");
 
    // delete various options that were added to the OPTIONS table
?>