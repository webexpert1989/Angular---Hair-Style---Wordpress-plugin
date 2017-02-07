<?php
/**************************************************************
 *
 * ajax response class for hair buider plugin
 *
 * @info: error code - 100x: GET & POST errors, no fields
 *                     200x: UPDATE faild errors
 *                     300x: INSERT faild errors
 *                     400x: DELETE faild errors
 *                     900x: SELECT faild errors
 *
 **************************************************************/


// check H_ajax is available
if(!class_exists('H_ajax')){

	// CREATE A PACKAGE CLASS
	class H_ajax{

		// Hair database object
		var $db_obj = '';
		
		/**
		 * constuct
		 *
		 * @return:	void
		 */
		function __construct(){
			$this->db_obj = new H_db;

			return;
		}
					
		/**
		 * update data 
		 *
		 * @return:	void
		 */
		public function hair_edit(){ 

			// check POST fields
			if(empty($_POST)){
				// succss
				echo json_encode(array(
					'error' => 1002,
					'error_txt' => __('no POST fields!', 'hairstyle'),
				));
				exit;
			}
			$post = $_POST;

			/////////////
			$the_issue_key = $post['the_issue_key'];

			// get editor info
			global $current_user;
			get_currentuserinfo();
            
			// insert data to DB
			if($this->db_obj->update(array(
				'table' => H_DB,
				'data' => array(
					'hair_name' =>		$post['name'],
					'hair_img' =>		$post['img'],
					'hair_top' =>		$post['top'],
					'hair_maingroup' =>	base64_encode($post['mainGroup']),
					'hair_colors' =>	base64_encode($post['colors']),
					'author' =>			$current_user->user_login,
					'date' =>			date('Y-m-d H:i:s'),
					'status' =>			true
				),
				'where' => array(
					'ID' => $post['id']
				)
			))){
				// succss
				echo json_encode(array(
					'success' => true,
					'success_txt' => __('Hair is updated successfully!', 'hairstyle')
				));
			} else {
				// not udpated
				echo json_encode(array(
					'error' => 2001,
					'error_txt' => __('Sorry, couldn`t update Hair correctly, Try again later!', 'hairstyle')	
				));			}
			
			exit;
		}
				
		/**
		 * add new data 
		 *
		 * @return:	void
		 */
		public function hair_new(){

			// check POST fields
			if(empty($_POST)){
				// succss
				echo json_encode(array(
					'error' => 1003,
					'error_txt' => __('no POST fields!', 'hairstyle'),
				));
				exit;
			}
			$post = $_POST;
			
			/////////////
			$the_issue_key = $post['the_issue_key'];

			// get editor info
			global $current_user;
			get_currentuserinfo();

			// insert new doc data to table
			if($this->db_obj->insert(array(
				'table' => H_DB,
				'data' => array(
					'hair_name' =>		$post['name'],
					'hair_img' =>		$post['img'],
					'hair_top' =>		$post['top'],
					'hair_maingroup' =>	base64_encode($post['mainGroup']),
					'hair_colors' =>	base64_encode($post['colors']),
					'author' =>			$current_user->user_login,
					'date' =>			date('Y-m-d H:i:s'),
					'status' =>			true
				),
			))){
				// succss
				echo json_encode(array(
					'success' => true,
					'success_txt' => __('New Hair is saved successfully!', 'hairstyle')
				));
			} else {
				echo json_encode(array(
					'error' => 3001,	
					'error_txt' => __('Sorry, couldn`t save new Hair correctly, Try again later!', 'hairstyle')	
				));
			}

			//////////
			exit;
		}
		
		/**
		 * delete hair 
		 *
		 * @return:	void
		 */
		public function hair_del(){ 

			// check POST fields
			if(empty($_POST)){
				// succss
				echo json_encode(array(
					'error' => 1004,
					'error_txt' => __('no POST fields!', 'hairstyle'),
				));
				exit;
			}
			$post = $_POST;
			
			/////////////
			$the_issue_key = $post['the_issue_key'];

			// delete doc
			if($this->db_obj->delete(array(
				'table' => H_DB,
				'where' => array(
					'ID' => $post['id']
				)
			))){
				// succss
				echo json_encode(array(
					'success' => true,
					'success_txt' => __('Hair is deleted successfully!', 'hairstyle'),
				));
			} else {
				// not deleted
				echo json_encode(array(
					'error' => 4002,	
					'error_txt' => __('Sorry, couldn`t delete Hair correctly, Try again later!', 'hairstyle')	
				));
			}
			exit;
		}
	}
}

?>