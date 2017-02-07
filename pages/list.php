<?php
/**************************************************************
 *
 * template for Hair list
 *
 **************************************************************/

// documentation list
function H_list($items = array(), $total = 0){
/////////////
	global $H_conf;
    
    foreach($items as $i){
        $i->hair_shortcode = H_shortcode::get_shortcode($i->ID);
    }
	$list_table = new H_admin_list($items, $total);
	$list_table->prepare_items();
    
	?>
		<div id="hair-admin" class = "wrap">
			<h2>
				<?php echo __('Hairs', 'hairstyle'); ?>
				<a href = "admin.php?page=<?php echo $H_conf['pages']['list'].'&action=new'; ?>" class = "add-new-h2">
					<?php echo __('Add New a Hair', 'hairstyle'); ?>
				</a>
			</h2>

			<form id = "hair-list" method = "get">
				<input type = "hidden" name = "page" value = "<?php echo esc_attr($_REQUEST['page']); ?>" />

				<!-- display table -->
				<?php $list_table->display(); ?>

			</form>
		</div>
	<?php
}
?>