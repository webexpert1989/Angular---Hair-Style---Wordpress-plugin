<?php 
/**************************************************************
 *
 * Configuration Plugin
 *
 **************************************************************/

/***
 * Plugin DB settings
 */
global $wpdb;

define('H_DB', $wpdb->prefix.'hairstyle');

define('H_DB_VERSION', '1.0.1');


/***
 * alias & download root url
 */
$uploadInfo = wp_upload_dir();
define('H_ALIAS', $uploadInfo['basedir'].'/hair/');
define('H_DOWNLOAD', $uploadInfo['baseurl'].'/hair/');


/***
 * plugin directories
 */

// plugin root dir
define('H_URL', dirname(__FILE__).'/');

// include dir
define('H_INCLUDE', H_URL.'inc/');

// include pages
define('H_PAGES', H_URL.'pages/');

// load assets dir
define('H_PLUGIN_URL', plugin_dir_url(__FILE__));
define('H_ASSETS', H_PLUGIN_URL.'assets/');


/***
 * plugin settings
 */

global $H_conf;
$H_conf = array(

	// system conf
	'remove_data'   => true,		// if this is true, remove all datas of database table until uninstalling plugin	

	// default value for custom settings
	'rows_per_page'			=> 20,	// max rows number of list table page
    
    // admin pages
    'pages' => array(
        'list'      => 'H-admin-list',
		'edit'		=> 'H-admin-edit',
    )
);

/***
 * shortcode prefix
 */

define('H_SHORTCODE', 'HairStyleApp');

?>