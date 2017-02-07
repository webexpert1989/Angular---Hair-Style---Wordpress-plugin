<?php
/**************************************************************
 *
 * global class for Hair buider plugin
 *
 **************************************************************/


// check H_global is available
if(!class_exists('H_global')){

	// CREATE A PACKAGE CLASS
	class H_global{
		
		// constuct
		function __construct(){
			return;
		}
		
		/**
		 * display notice in admin section
		 *
		 * @param:	array  $n - notice array
		 * @return:	void
		 */
		public function admin_notice($n = array()){
			if(empty($n)){
				return false;
			}
			
			$msg = '';

			// notice type: update-nag, updated, error
			foreach($n as $k => $v){
				$msg .= '
					<div class = "'.$k.' notice is-dismissible">
						<p>'.$v.'</p>

						<button type = "button" class = "notice-dismiss">
							<span class = "screen-reader-text">Dismiss this notice.</span>
						</button>
					</div>
				';
			}
				
			// print messagaes
			echo $msg;

			return;
		}
		

		/**
		 * redirect to another url
		 *
		 * @param:	string  $url - redirect url
		 * @return:	void
		 */
		public function redirect($url = ''){
			echo '<script>window.location.href = "'.$url.'"</script>';

			return;
		}

	}
}

?>