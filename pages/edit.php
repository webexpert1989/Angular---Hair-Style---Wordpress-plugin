<?php
/**************************************************************
 *
 * template to edit hair
 *
 **************************************************************/


// edit hair
function H_edit($data = null){
    
	/////////////
    if(empty($data)){
        $data = (object)[
            ID => 0,
            hair_name => '',
            hair_img => '',
            hair_top => '',
            hair_group => '',
            hair_colors => '',
            author => '',
            date => '',
            status => false,
        ];
    } else {
        $data->hair_colors = json_decode(stripslashes(base64_decode($data->hair_colors)));
        $data->hair_maingroup = json_decode(stripslashes(base64_decode($data->hair_maingroup)));
    }
    
	///////////
	global $H_conf;
    
	// enable connection to wordpress media lib    
    wp_enqueue_media();
    
	?>
		<div id="hair-admin" class="wrap">
			<h2>
				<?php empty($data->ID)? printf(__('New Hair', 'hairstyle')): printf(__('Edit Hair `%s`', 'hairstyle'), $data->hair_name); ?>
				<a id="hair-list-page" href="admin.php?page=<?php echo $H_conf['pages']['list']; ?>" class="add-new-h2">
					<?php echo __('List', 'hairstyle'); ?>
				</a>
			</h2>

			<div class="message-wrapper">
				<?php do_action('H-admin-message'); ?>
			</div>
			
			<div class="content-wrapper">
                <hr />
                
                <section>
                    <label for="hair-name"><?php echo __('Hair Name', 'hairstyle'); ?>:</label> 
                    <input type="text" id="hair-name" name="hair-name" value="<?php echo $data->hair_name; ?>"/>
                </section>
                <section>
                    <label for="hair-img"><?php echo __('Hair Image', 'hairstyle'); ?>:</label> 
                    <div class="upload">
                        <input type="text" id="hair-img" name="hair-img" value="<?php echo $data->hair_img; ?>"/>
                        <input type="button" class="button-secondary" data-upload data-preview="#hair-preview" value="<?php echo __('Upload', 'hairstyle'); ?>"/>
                    </div>
                    <div id="hair-preview" class="hair-preview">
                        <?php if($data->hair_img): ?>
                            <img src="<?php echo $data->hair_img; ?>"/>
                        <?php endif; ?>
                    </div>
                </section>
                <section>
                    <label for="hair-top"><?php echo __('Hair Top Space(px)', 'hairstyle'); ?>:</label> 
                    <input type="text" id="hair-top" name="hair-top" value="<?php echo $data->hair_top? $data->hair_top: 0; ?>"/>
                </section>
                <section id="main-group">
                    <label><?php echo __('Hair Main Group', 'hairstyle'); ?>:</label>
                    <div class="fieldset">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <colgroup>
                                <col width="30%">
                                <col width="60%">
                                <col width="10%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th><?php echo __('Main Group Name ID', 'hairstyle'); ?></th>
                                    <th><?php echo __('Main Group Name', 'hairstyle'); ?></th>
                                    <th><?php echo __('Action', 'hairstyle'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($data->hair_maingroup): ?>
                                    <?php foreach($data->hair_maingroup as $m): ?>
                                        <tr>
                                            <td data-field="id"><?php echo $m->id; ?></td>
                                            <td data-field="name"><?php echo $m->name; ?></td>
                                            <td>
                                                <a href="#" class="group-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <a href="#" class="group-del"><i class="fa fa-times" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><input type="text" data-field-add="id" placeholder="<?php echo __('Main Group ID', 'hairstyle'); ?>"/></th>
                                    <th><input type="text" data-field-add="name" placeholder="<?php echo __('Main Group Name', 'hairstyle'); ?>"/></th>
                                    <th><a href="#" class="group-add"><i class="fa fa-plus" aria-hidden="true"></i></a></th>
                                </tr>
                            </tfoot>                                            
                        </table>                   

                        <!-- templates to edit main group -->
                        <script id="maingroup-edit-tpl" type="text/template">
                            <td><input type="text" data-field="id" value="{{id}}" placeholder="<?php echo __('Main Group ID', 'hairstyle'); ?>"/></td>
                            <td><input type="text" data-field="name" value="{{name}}" placeholder="<?php echo __('Main Group Name', 'hairstyle'); ?>"/></td>
                            <td>
                                <a href="#" class="group-save"><i class="fa fa-check" aria-hidden="true"></i></a>
                                <a href="#" class="group-del"><i class="fa fa-times" aria-hidden="true"></i></a>
                            </td>
                        </script>

                        <script id="maingroup-row-tpl" type="text/template">
                            <td data-field="id">{{id}}</td>
                            <td data-field="name">{{name}}</td>
                            <td>
                                <a href="#" class="group-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <a href="#" class="group-del"><i class="fa fa-times" aria-hidden="true"></i></a>
                            </td>
                        </script>
                    </div>
                </section>
                
                <section id="color-group">
                    <label><?php echo __('Colors', 'hairstyle'); ?>:</label>
                    
                    <?php if($data->hair_colors): ?>
                        <?php foreach($data->hair_colors as $g): ?>
                            <div class="fieldset">
                                <div class="group-wrap">
                                    <div class="group-name">
                                        <label><?php echo __('Parent Main Group:', 'hairstyle'); ?></label>
                                        <select type="text" data-field="group-main" placeholder="<?php echo __('-- Select Main Group --', 'hairstyle'); ?>">
                                            <option value=""><?php echo __('-- Select Main Group --', 'hairstyle'); ?></option>
                                            <?php if($data->hair_maingroup): ?>
                                                <?php foreach($data->hair_maingroup as $m): ?>
                                                    <option value="<?php echo $m->id; ?>" <?php echo $g->main == $m->id? "selected": ""; ?>><?php echo $m->name; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <label for="group-name"><?php echo __('Color Sub Group', 'hairstyle'); ?>:</label> 
                                        <input type="text" data-field="group-name" value="<?php echo $g->group; ?>"/>
                                    </div>
                                    <div class="group-items">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <colgroup>
                                                <col width="15%">
                                                <col width="15%">
                                                <col width="21%">
                                                <col width="21%">
                                                <col width="21%">
                                                <col width="7%">
                                            </colgroup>
                                            <thead>
                                                <tr>
                                                    <th><?php echo __('Number', 'hairstyle'); ?></th>
                                                    <th><?php echo __('Name', 'hairstyle'); ?></th>
                                                    <th><?php echo __('Shop Link', 'hairstyle'); ?></th>
                                                    <th><?php echo __('Thumbnail', 'hairstyle'); ?></th>
                                                    <th><?php echo __('Hair Image', 'hairstyle'); ?></th>
                                                    <th><?php echo __('Action', 'hairstyle'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($g->items as $c): ?>
                                                    <tr>
                                                        <td data-field="num"><?php echo $c->num; ?></td>
                                                        <td data-field="name"><?php echo $c->name; ?></td>
                                                        <td data-field="shop"><a href="<?php echo $c->shop; ?>" target="_blank"><?php echo $c->shop; ?></a></td>
                                                        <td data-field="thumb"><a href="<?php echo $c->thumb; ?>" target="_blank"><?php echo $c->thumb; ?></a></td>
                                                        <td data-field="hair"><a href="<?php echo $c->hair; ?>" target="_blank"><?php echo $c->hair; ?></a></td>
                                                        <td>
                                                            <a href="#" class="color-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                            <a href="#" class="color-del"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th><input type="text" data-field-add="num" placeholder="<?php echo __('Color Number', 'hairstyle'); ?>"/></th>
                                                    <th><input type="text" data-field-add="name" placeholder="<?php echo __('Color Name', 'hairstyle'); ?>"/></th>
                                                    <th><input type="text" data-field-add="shop" placeholder="<?php echo __('Shop Link', 'hairstyle'); ?>"/></th>
                                                    <th>
                                                        <div class="upload">
                                                            <input type="text" data-field-add="thumb" placeholder="<?php echo __('Color Thumdnail URL', 'hairstyle'); ?>"/>
                                                            <input type="button" class="button-secondary" data-upload value="<?php echo __('Upload', 'hairstyle'); ?>"/>
                                                        </div>
                                                    </th>
                                                    <th>
                                                        <div class="upload">
                                                            <input type="text" data-field-add="hair" placeholder="<?php echo __('Hair Image URL', 'hairstyle'); ?>"/>
                                                            <input type="button" class="button-secondary" data-upload value="<?php echo __('Upload', 'hairstyle'); ?>"/>
                                                        </div>
                                                    </th>
                                                    <th><a href="#" class="color-add"><i class="fa fa-plus" aria-hidden="true"></i></a></th>
                                                </tr>
                                            </tfoot>                                            
                                        </table>
                                    </div>
                                    <a href="#" class="remove-group"><i class="fa fa-times" aria-hidden="true"></i> <?php echo __('Remove Color Group', 'hairstyle'); ?></a>
                                </div>
                            </div>                    
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <a href="#" id="add-new-group"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo __('Add New Color Sub Group', 'hairstyle'); ?></a>
                    
                    <!-- templates to edit colors -->
                    <script id="color-edit-tpl" type="text/template">
                        <td><input type="text" data-field="num" value="{{num}}" placeholder="<?php echo __('Color Number', 'hairstyle'); ?>"/></td>
                        <td><input type="text" data-field="name" value="{{name}}" placeholder="<?php echo __('Color Name', 'hairstyle'); ?>"/></td>
                        <td><input type="text" data-field="shop" value="{{shop}}" placeholder="<?php echo __('Shop Link', 'hairstyle'); ?>"/></td>
                        <td>
                            <div class="upload">
                                <input type="text" data-field="thumb" value="{{thumb}}" placeholder="<?php echo __('Color Thumdnail URL', 'hairstyle'); ?>"/>
                                <input type="button" class="button-secondary" data-upload value="<?php echo __('Upload', 'hairstyle'); ?>"/>
                            </div>
                        </td>                            
                        <td>
                            <div class="upload">
                                <input type="text" data-field="hair" value="{{hair}}" placeholder="<?php echo __('Hair Image URL', 'hairstyle'); ?>"/>
                                <input type="button" class="button-secondary" data-upload value="<?php echo __('Upload', 'hairstyle'); ?>"/>
                            </div>
                        </td>
                        <td>
                            <a href="#" class="color-save"><i class="fa fa-check" aria-hidden="true"></i></a>
                            <a href="#" class="color-del"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </td>
                    </script>
                    
                    <script id="color-row-tpl" type="text/template">
                        <td data-field="num">{{num}}</td>
                        <td data-field="name">{{name}}</td>
                        <td data-field="shop"><a href="{{shop}}" target="_blank">{{shop}}</a></td>
                        <td data-field="thumb"><a href="{{thumb}}" target="_blank">{{thumb}}</a></td>
                        <td data-field="hair"><a href="{{hair}}" target="_blank">{{hair}}</a></td>
                        <td>
                            <a href="#" class="color-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                            <a href="#" class="color-del"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </td>
                    </script>
                    
                    <script id="new-group-tpl" type="text/template">
                        <div class="fieldset">
                            <div class="group-wrap">
                                <div class="group-name">
                                    <label><?php echo __('Parent Main Group:', 'hairstyle'); ?></label>
                                    <select type="text" data-field="group-main" placeholder="<?php echo __('-- Select Main Group --', 'hairstyle'); ?>"><option value=""></option></select>
                                    <label for="group-name"><?php echo __('Color Sub Group', 'hairstyle'); ?>:</label> 
                                    <input type="text" data-field="group-name" value=""/>
                                </div>
                                <div class="group-items">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Number</th>
                                                <th>Name</th>
                                                <th>Shop Link</th>
                                                <th>Thumbnail</th>
                                                <th>Hair Image</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr>
                                                <th><input type="text" data-field-add="num" placeholder="<?php echo __('Color Number', 'hairstyle'); ?>"/></th>
                                                <th><input type="text" data-field-add="name" placeholder="<?php echo __('Color Name', 'hairstyle'); ?>"/></th>
                                                <th><input type="text" data-field-add="shop" placeholder="<?php echo __('Shop Link', 'hairstyle'); ?>"/></th>
                                                <th>
                                                    <div class="upload">
                                                        <input type="text" data-field-add="thumb" placeholder="<?php echo __('Color Thumdnail URL', 'hairstyle'); ?>"/>
                                                        <input type="button" class="button-secondary" data-upload value="<?php echo __('Upload', 'hairstyle'); ?>"/>
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="upload">
                                                        <input type="text" data-field-add="hair" placeholder="<?php echo __('Hair Image URL', 'hairstyle'); ?>"/>
                                                        <input type="button" class="button-secondary" data-upload value="<?php echo __('Upload', 'hairstyle'); ?>"/>
                                                    </div>
                                                </th>
                                                <th><a href="#" class="color-add"><i class="fa fa-plus" aria-hidden="true"></i></a></th>
                                            </tr>
                                        </tfoot>                                            
                                    </table>
                                </div>
                                <a href="#" class="remove-group"><i class="fa fa-times" aria-hidden="true"></i> <?php echo __('Remove Color Group', 'hairstyle'); ?></a>
                            </div>
                        </div>
                    </script>
                </section>
                
                <div class="action-wrap">
                    <hr />
                    <input type="button" id="hair-save" class="button-primary" data-id="<?php echo $data->ID; ?>" value="<?php echo __('Save Hair', 'hairstyle'); ?>"/>
                    <?php if(!empty($data->ID)): ?>
                        <input type="button" id="hair-del" class="button-secondary" onclick="javascript: removeHair('<?php echo __('Do you remove this documentation really?', 'hairstyle'); ?>', '<?php echo $data->ID; ?>');" value="<?php echo __('Delete Hair', 'hairstyle'); ?>"/>
                    <?php endif; ?>
                </div>
			</div>

			<input type="hidden" id="hair-id" value="<?php echo $data->ID; ?>"/>
		</div>
	<?php
}
?>