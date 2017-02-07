<?php
/**************************************************************
 *
 * DB class for hair buider plugin
 *
 **************************************************************/


// check H_global is available
if(!class_exists('H_db')){

	// CREATE A PACKAGE CLASS
	class H_db{
		
		// db object
		var $db;

		/**
		 * constuct
		 *
		 * @return:	void
		 */
		function __construct(){
			global $wpdb;
			
			$this->db = $wpdb;
			return;
		}
		
		/**
		 * make error log
		 *
		 * @return:	void
		 */
		protected function logger($error = ''){
			if(WP_DEBUG_LOG){
				if(is_array($error) || is_object($error)){
					error_log(print_r($error, true));
				} else {
					error_log($error);
				}
			}
			return;
		}

		/**
		 * check current table
		 *
		 * @param:	string  $table_name - table name
		 * @return:	void
		 */
		protected function check_table($table_name = null){
			if(empty($table_name)){
				$message = sprintf(__('Table name is not specified when the method "%s" call.', CDBT), __FUNCTION__);
				$this->logger($message);
				return false;
			}

			$result = $this->db->get_var($this->db->prepare("SHOW TABLES LIKE %s", $table_name));

			return $table_name === $result;
		}
		
		/**
		 * get all datas
		 *
		 * @param:	string  $table - table name
		 * @param:	string  $s     - search MySql query
		 * @return:	object array  Returns results on success, false on failure
		 */
		public function all($table = H_DB, $s = ''){
			return $this->db->get_results('SELECT * FROM `'.$table.'` WHERE 1 AND '.($s? '('.$s.')': '1'));
		}
				
		/**
		 * get all docs info only
		 *
		 * @param:	string  $table - table name
		 * @param:	string  $s     - search MySql query
		 * @return:	int     Returns total rows number on success, false on failure
		 */
		public function total($table = H_DB, $s = ''){
			return  $this->db->get_var('SELECT COUNT(*) FROM `'.$table.'` WHERE 1 AND '.($s? '('.$s.')': '1'));
		}

		/**
		 * get one row
		 *
		 * @param:	string  $table - table name
		 * @param:	int     $id    - row ID
		 * @return:	object  Returns row object on success, false on failure
		 */
		public function row($table = H_DB, $id = -1){
			return $this->db->get_row('SELECT * FROM `'.$table.'` WHERE ID = "'.$id.'"');
		}

		/**
		 * insert data to table
		 *
		 * @param:	array   $d - insert data, 'table': table name, 'data': data array, 'format': field's type
		 * @return:	int     Returns added last row ID on success, false on failure
		 */
		public function	insert($d = array()){

			if(!empty($d) && $this->check_table($d['table'])){
				$this->db->insert( 
					$d['table'], 
					$d['data'], 
					(isset($d['format'])? $d['format']: null)
				);

				return $this->db->insert_id? $this->db->insert_id: false;
			}

			return false;
		}

		/**
		 * update data
		 *
		 * @param:	array   $d - insert data, 'table': table name, 'data': data array, 'where': where query, 'format': field's type, 'where_format': where fields type
		 * @return:	bool    Returns true on success, false on failure
		 */
		public function	update($d = array()){

			if(!empty($d) && $this->check_table($d['table'])){

				return $this->db->update( 
					$d['table'], 
					$d['data'], 
					$d['where'],
					(isset($d['format'])? $d['format']: null),
					(isset($d['where_format'])? $d['where_format']: null)
				);
			}

			return false;
		}

		/**
		 * delete data
		 *
		 * @param:	array   $d - insert data, 'table': table name, 'where': where query, 'where_format': where fields type
		 * @return:	bool    Returns true on success, false on failure
		 */
		public function	delete($d = array()){

			if(!empty($d) && $this->check_table($d['table'])){

				return $this->db->delete( 
					$d['table'], 
					$d['where'],
					(isset($d['where_format'])? $d['where_format']: null)
				);
			}

			return false;
		}
	}
}

?>