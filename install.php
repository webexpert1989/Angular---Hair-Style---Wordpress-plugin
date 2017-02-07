<?php 
/**************************************************************
 *
 * Install Plugin
 *
 **************************************************************/

require_once(dirname(__FILE__).'/settings.php');

// install database for Order Contact
register_activation_hook(__FILE__, 'H_install');


function H_install(){
	//////
	global $wpdb;
	
	require_once(ABSPATH.'wp-admin/includes/upgrade.php');

    $sql = '		
		CREATE TABLE IF NOT EXISTS `'.H_DB.'` (
		  `ID` int(11) NOT NULL AUTO_INCREMENT,
		  `hair_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
		  `hair_img` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
		  `hair_top` int(11) NOT NULL,
		  `hair_maingroup` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
		  `hair_colors` LONGBLOB NOT NULL,
		  `author` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
		  `date` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
		  `status` int(11) NOT NULL,
		  PRIMARY KEY (`ID`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;
	';
	dbDelta($sql);
	
	/////
	add_option('H_DB_VERSION', H_DB_VERSION);

	// make contents folders
	if(!is_dir(H_ALIAS)) mkdir(H_ALIAS, 0755);

	chmod(H_ALIAS, 0755);
}

// install start
function H_update_db_check(){
    if (get_site_option('H_DB_VERSION') != H_DB_VERSION){
        H_install();
    }
}
add_action('plugins_loaded', 'H_update_db_check');
?>