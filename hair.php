<?php
/*
Plugin Name: Hair Style
Description: wordpress plugin to build hair style
Version: 1.0.1
*/

if(!defined('ABSPATH')){
	exit;
}

// Let's go!
if(class_exists('H_init')){
	new H_init();
}

// manula builder class
class H_init{
	
	/**
	 * Our plugin version
	 *
	 * @var string
	 */
	public static $version = '1.0.1';

	/**
	 * Our plugin file
	 *
	 * @var string
	 */
	public static $plugin_file = __FILE__;

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct(){
		
		// load settings & install function 
		require_once(dirname(__FILE__).'/settings.php');
		require_once(dirname(__FILE__).'/install.php');

		// Activation and uninstall hooks
		register_activation_hook(__FILE__, array(__CLASS__, 'do_activation'));
		register_uninstall_hook( __FILE__, array(__CLASS__, 'do_uninstall'));

		// Load dependancies
		$this->load_dependancies();

		// Load templates
		$this->load_templates();

		// Setup localization
		$this->set_locale();

		// Define hooks
		$this->define_hooks();

		// Define Ajax
		$this->define_ajax();

		// Define Shortcode
		$this->define_shortcode();

	}

	/**
	 * Activation
	 *
	 * @return void
	 */
	public static function do_activation(){

		global $wp_version;

		// Deactivate the plugin if the WordPress version is below the minimum required.
		if (version_compare($wp_version, '4.0', '<')){
			deactivate_plugins(plugin_basename(__FILE__));
			wp_die(__(sprintf('Sorry, but your version of WordPress, <strong>%s</strong>, is not supported. The plugin has been deactivated. <a href="%s">Return to the Dashboard.</a>', $wp_version, admin_url()), 'hairstyle'));
			return false;
		}

		// Add options
		add_option('H_version', self::$version);

		// Trigger hooks
		do_action('H_activate');

	}

	/**
	 * Uninstall
	 *
	 * @return void
	 */
	public static function do_uninstall(){

		// Get the settings
		global $H_conf;

		// If enabled, remove the plugin data
		if ($H_conf['remove_data']){

			// Delete all of the datas
			foreach (H_db::all() as $md){
				H_db::delete($md->ID);
			}

			// Delete options
			delete_option('H_version');

			// Remove data hook
			do_action('H_remove_data');

		}
			
		// Trigger hooks
		do_action('H_uninstall');

	}

	/**
	 * Load dependancies
	 *
	 * @return void
	 */
	protected function load_dependancies(){
		
		require_once(H_INCLUDE.'class-global.php');
		require_once(H_INCLUDE.'class-db.php');
		require_once(H_INCLUDE.'class-ajax.php');
		require_once(H_INCLUDE.'class-shortcode.php');
		require_once(H_INCLUDE.'class-menu.php');
		require_once(H_INCLUDE.'class-assets.php');
		require_once(H_INCLUDE.'class-list.php');
		require_once(H_INCLUDE.'class-page.php');

	}

	/**
	 * Load templates
	 *
	 * @return void
	 */
	protected function load_templates(){
		
		require_once(H_PAGES.'edit.php');
		require_once(H_PAGES.'list.php');
		require_once(H_PAGES.'app.php');

	}

	/**
	 * Set locale
	 *
	 * @return void
	 */
	protected function set_locale(){

		// Load plugin textdomain
		load_plugin_textdomain('hairstyle', false, H_LANGUAGE);

	}

	/**
	 * Define menu hooks
	 *
	 * @return void
	 */
	protected function define_hooks(){

		// Initiate components
		$menu = new H_admin_menu();
		$assets = new H_assets();

		/**
		 * Hook everything, "connect all the dots"!
		 *
		 * All of these actions connect the various parts of our plugin together.
		 * The idea behind this is to keep each "component" as separate as possible, decoupled from other components.
		 *
		 * These hooks bridge the gaps.
		 */
		add_action('admin_menu', array($menu, 'add_toplevel_menu'));
		add_action('admin_enqueue_scripts', array($assets, 'add_admin_assets'));
        
        ///
		add_action('wp_enqueue_scripts', array($assets, 'add_assets'));

	}

	/**
	 * Define ajax hooks
	 *
	 * @return void
	 */
	protected function define_ajax(){

		// Initiate components
		$ajax = new H_ajax();
		
		add_action('wp_ajax_hair_edit', array($ajax, 'hair_edit'));
		add_action('wp_ajax_nopriv_hair_edit', array($ajax, 'hair_edit'));

		add_action('wp_ajax_hair_new', array($ajax, 'hair_new'));
		add_action('wp_ajax_nopriv_hair_new', array($ajax, 'hair_new'));

		add_action('wp_ajax_hair_del', array($ajax, 'hair_del'));
		add_action('wp_ajax_nopriv_hair_del', array($ajax, 'hair_del'));

	}

	/**
	 * Define shortcode hooks
	 *
	 * @return void
	 */
	protected function define_shortcode(){

		// Initiate components
		$shortcode = new H_shortcode();
		
		add_shortcode(H_SHORTCODE, array($shortcode, 'shortcode'));
	}
}
?>