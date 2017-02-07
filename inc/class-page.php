<?php
/**************************************************************
 *
 * page driving class for admin page 
 *
 **************************************************************/


// check H_page is available
if(!class_exists('H_page')){

	// CREATE A PACKAGE CLASS
	class H_page{
		
		// custom database class object
		var $get_db;
		
		// global page settings class object
		var $get_pages;

		
		/**
		 * constuct
		 *
		 * @return:	void
		 */
		function __construct(){
			$this->get_db = new H_db();
			
			global $H_conf;
			$this->get_pages = $H_conf['pages'];

			return;
		}
		
		/**
		 * list page
		 *
		 * @return:	void
		 */
		public function pages(){
			switch($_REQUEST['action']){
				case 'new':
					$this->page_new();
					break;
                    
				case 'edit':
					$this->page_edit();
					break;

				case 'del':
					$this->page_list_del();
					break;

				default:
					$this->page_list();
					break;
			}
			
			return;
		}
		
		/**
		 * list page - list view items
		 *
		 * @return:	void
		 */
		protected function page_list(){
			// print list table
			H_list($this->get_db->all(), $this->get_db->total());

			return;
		}
				
		/**
		 * list page - edit
		 *
		 * @return:	void
		 */
		protected function page_edit(){
			// doc ID to edit doc
			$hair_id = isset($_REQUEST['hair'])? $_REQUEST['hair']: -1;
			
			// get form datas
			$data = $this->get_db->row(H_DB, $hair_id);
			
			if(empty($data)){
				H_global::admin_notice(array('error' => __('Sorry, could`t find detail info to edit hair!', 'hairstyle')));
				
				// display list table after deleted doc
				$this->page_list();

			} else {
				// print form
				H_edit($data);
			}
			
			return;
		}
				
		/**
		 * list page - new
		 *
		 * @return:	void
		 */
		protected function page_new(){
            // print form
            H_edit();
			
			return;
		}
		
		/**
		 * list page - delete items
		 *
		 * @return:	void
		 */
		protected function page_list_del(){
			// doc ID to delete doc
			$hair_ids = isset($_REQUEST['hair'])? $_REQUEST['hair']: -1;

			if(is_array($hair_ids)){
				foreach($hair_ids as $id){
					$this->del_list_item($id);
				}
			} else {
				$this->del_list_item($hair_ids);
			}

			// display list table after deleted doc
			$this->page_list();

			return;
		}

		/**
		 * delete one item & row from database
		 *
		 * @param:	int  $hair_id - row ID
		 * @return:	void
		 */
		protected function del_list_item($hair_id){
			$data = $this->get_db->row(null, $hair_id);

			if($data){
				// delete row
				if($this->get_db->delete(array(
					'table' => H_DB,
					'where' => array('ID' => $data->ID)
				))){
					H_global::admin_notice(array('updated' => __('Hair `'.$data->hair_name.'` is deleted successfully!', 'hairstyle')));
				} else {				
					H_global::admin_notice(array('error' => __('Sorry, couldn`t delete selected hair correctly, Try again later!', 'hairstyle')));
				}
			} else {
				H_global::admin_notice(array('error' => __('no hair!', 'hairstyle')));
			}

			return;
		}
	}
}

?>