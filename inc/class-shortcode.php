<?php
/**************************************************************
 *
 * shortcode class for hair app 
 *
 **************************************************************/


// check H_shortcode is available
if(!class_exists('H_shortcode')){

	// CREATE A PACKAGE CLASS
	class H_shortcode{
		
		/**
		 * constuct
		 *
		 * @return:	void
		 */
		function __construct(){
			return;
		}

		/**
		 * make shortcode by row ID
		 *
		 * @param:	int  $id - row id of table
		 * @return:	string  Returns shortcode string on success, false on failure 
		 */
		public function get_shortcode($id = -1){
			if($id){
				return '['.H_SHORTCODE.' id='.$id.']';
			} else {
				return '';
			}
		}

		/**
		 * put app form to display in the page from entered shortcode
		 *
		 * @param:	array   $attr - shortcode attributes
		 * @param:	string  $content - shortcode contents
		 * @return:	string  Returns html on success, false on failure 
		 */
		public function shortcode($attr, $content = null){
			if(empty($attr['id'])){
				H_global::admin_notice(array('error' => __('Sorry, could`t get Hair ID!', 'hairstyle')));
				return false;
			}

			// get doc info
			$get_db = new H_db();
			$data = $get_db->row(H_DB, $attr['id']);
            
			if(empty($data)){
				H_global::admin_notice(array('error' => __('Sorry, could`t find detail info to get hair form!', 'hairstyle')));
				return false;
			} else {
				return H_app($data);
			}
		}
	}
}

?>