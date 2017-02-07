<?php 
/**************************************************************
 *
 * Uninstall Plugin
 *
 **************************************************************/

require_once(dirname(__FILE__).'/settings.php');
require_once(H_INCLUDE.'global.php');

//---------
if (!defined('WP_UNINSTALL_PLUGIN'))
{
	exit();

}

// Hook for uninstall
H_delete_plugin();
function H_delete_plugin(){
    // unremove if remove_data field is false
    if(!$H_conf['remove_data']){
        return;
    }
    
	// remove directory
	H_global::delTree(H_ALIAS);

	// remove tables in DB
	global $wpdb;
	$wpdb->query('DROP TABLE `'.H_DB.'`;');
	
	delete_option('H_DB_VERSION');
}
?>