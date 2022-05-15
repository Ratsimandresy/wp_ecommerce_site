<?php

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

add_filter('big_image_size_threshold', '__return_false');



add_action('admin_menu', 'slazzer_admin_menu');



function slazzer_admin_menu(){

    add_menu_page('Slazzer - Auto Background Remover',

        'Slazzer - Auto Background Remover',

        'edit_posts',

        'slazzer-background-changer',

        'slazzer_page_callback_function',

        'dashicons-format-gallery'

    );

}



function slazzer_page_callback_function(){

    include('slazzer-background-changer_plugin_ui.php');

}


add_action( 'woocommerce_product_options_inventory_product_data', 'misha_option_group' );
 
function misha_option_group() {
	$gallery_images = get_post_meta($_GET['post'],'_product_image_gallery',true);
	if($gallery_images){
		echo '<div class="options_group"><p class="form-field _gallery_field"><label>Gallery Images:</label>'.$gallery_images.'</p></div>';
	}
}






include('class-slazzer-background-changer-service.php');

include('class-slazzer-background-changer-utility.php');

include('slazzer-background-changer-save-settings.php');

include('slazzer-background-changer-get_all_image_ids.php');

include('slazzer-background-changer-single_image_process.php');

include('slazzer-background-changer-delete_backup.php');

include('slazzer-background-changer-restore_backup.php');



