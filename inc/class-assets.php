<?php
/**************************************************************
 *
 * load assets class for hair list admin/front page 
 *
 **************************************************************/


// check H_assets is available
if(!class_exists('H_assets')){

	// CREATE A PACKAGE CLASS
	class H_assets{
				
		/**
		 * constuct
		 * @return:	void
		 */
		function __construct(){
			return;
		}
				
		/**
		 * add javascript & css files to wordpress
		 *
		 * @return:	void
		 */
		public function add_assets(){
			
			$this->add_js();
			$this->add_css();

			return;
		}
				
		/**
		 * add javascript & css files to wordpress admin page
		 *
		 * @return:	void
		 */
		public function add_admin_assets(){
			
			$this->add_admin_js();
			$this->add_admin_css();

			return;
		}
				
		/**
		 * register & active javascript files
		 *
		 * @return:	void
		 */
		protected function add_js(){

			//wp_register_script('H_js_lib_jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.min.js');
			//wp_enqueue_script('H_js_lib_jquery');
			
            wp_register_script('H_js_lib_angular', 'https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.5/angular.min.js');
			wp_enqueue_script('H_js_lib_angular');
			wp_register_script('H_js_lib_angular_route', 'https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.5/angular-route.min.js');
			wp_enqueue_script('H_js_lib_angular_route');
            
			wp_register_script('H_js_lib_slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js');
			wp_enqueue_script('H_js_lib_slick');
			wp_register_script('H_js_lib_angular_slick', H_ASSETS.'lib/angular-slick.min.js');
			wp_enqueue_script('H_js_lib_angular_slick');

			wp_register_script('H_js_lib_angular_slick', H_ASSETS.'lib/angular-slick.min.js');
			wp_enqueue_script('H_js_lib_angular_slick');
            
			wp_register_script('H_js_app', H_ASSETS.'js/app.js');
			wp_enqueue_script('H_js_app', false, array(), false, true);
            
			return;
		}
		
		/**
		 * register & active css files
		 *
		 * @return:	void
		 */
		protected function add_css(){

			wp_register_style('H_css_lib_slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css'); 
			wp_enqueue_style('H_css_lib_slick');
			wp_register_style('H_css_lib_slick_theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css'); 
			wp_enqueue_style('H_css_lib_slick_theme');

			wp_register_style('H_css_fonts', H_ASSETS.'fonts/AvenirLTStd.css'); 
			wp_enqueue_style('H_css_fonts');
			wp_register_style('H_css', H_ASSETS.'css/app.css'); 
			wp_enqueue_style('H_css');

			return;

		}
        
        /**
		 * register & active javascript files for admin page
		 *
		 * @return:	void
		 */
		protected function add_admin_js(){
            
			wp_register_script('H_admin_js', H_ASSETS.'js/admin.js');
			wp_enqueue_script('H_admin_js');
			
			wp_localize_script('H_admin_js', 'global_var', 
				array(
					//To use this variable in javascript use "youruniquejs_vars.ajaxurl"
					'ajaxurl' => admin_url('admin-ajax.php'),
					//To use this variable in javascript use "youruniquejs_vars.the_issue_key"
					'the_issue_key' => $the_issue_key,
				) 
			); 

			return;
		}
		
		/**
		 * register & active css files for admin page
		 *
		 * @return:	void
		 */
		protected function add_admin_css(){
            
			wp_register_style('awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css');
			wp_enqueue_style('awesome');

			wp_register_style('H_admin_css', H_ASSETS.'css/admin.css'); 
			wp_enqueue_style('H_admin_css');

			return;

		}
	}
}

?>