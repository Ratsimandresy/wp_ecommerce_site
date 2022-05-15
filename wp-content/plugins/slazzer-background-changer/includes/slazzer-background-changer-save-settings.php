<?php
add_action('wp_ajax_slazzer_save_settings', 'slazzer_save_settings');
add_action('wp_ajax_nopriv_slazzer_save_settings', 'slazzer_save_settings');
function slazzer_save_settings(){
    if (isset($_POST['slazzer_save_settings'])) {
        $result = array();
        $Slazzer_Include_Processed = sanitize_text_field($_POST['Slazzer_Include_Processed']);
        $slazzer_api_key = sanitize_text_field($_POST['slazzer_live_api_key']);
        $slazzer_products = sanitize_text_field($_POST['slazzer_products']);
        $Slazzer_products_IDs = sanitize_text_field($_POST['Slazzer_products_IDs']);
        $slazzer_main_image = sanitize_text_field($_POST['slazzer_main_image']);
        $slazzer_gallery_image = sanitize_text_field($_POST['slazzer_gallery_image']);
        $background_option = sanitize_text_field($_POST['background_option']);
        $background_color = sanitize_text_field($_POST['background_color']);
        $Slazzer_gallery_image_IDs = sanitize_text_field($_POST['product_gallery_image']);
        $Slazzer_crop_image = sanitize_text_field($_POST['Slazzer_Crop_Image']);



        //image_upload
        if (isset($_FILES['background_image'])) {
            $wordpress_upload_dir = wp_upload_dir();
            $i = 1; // number of tries when the file with the same name is already exists
            $profilepicture = $_FILES['background_image'];
            $new_file_path = $wordpress_upload_dir['path'] . '/' . $profilepicture['name'];
            $new_file_mime = mime_content_type($profilepicture['tmp_name']);

            while (file_exists($new_file_path)) {
                $i++;
                $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $profilepicture['name'];
            }

            // looks like everything is OK
            if (move_uploaded_file($profilepicture['tmp_name'], $new_file_path)) {


                $upload_id = wp_insert_attachment(array(
                    'guid' => $new_file_path,
                    'post_mime_type' => $new_file_mime,
                    'post_title' => preg_replace('/\.[^.]+$/', '', $profilepicture['name']),
                    'post_content' => '',
                    'post_status' => 'inherit'
                ), $new_file_path);

                // wp_generate_attachment_metadata() won't work if you do not include this file
                require_once(ABSPATH . 'wp-admin/includes/image.php');

                // Generate and save the attachment metas into the database
                wp_update_attachment_metadata($upload_id, wp_generate_attachment_metadata($upload_id, $new_file_path));

                // Show the uploaded file in browser
                
                $background_image = wp_get_attachment_url($upload_id);
                update_option('background_image', $background_image);
            }
        }
        //image_upload
        $Slazzer_Preserve_Resize = sanitize_text_field($_POST['Slazzer_Preserve_Resize']);

        update_option('slazzer_live_key', $slazzer_api_key);
        update_option('slazzer_products', $slazzer_products);
        update_option('Slazzer_products_IDs', $Slazzer_products_IDs);
        update_option('slazzer_main_image', $slazzer_main_image);
        update_option('slazzer_gallery_image', $slazzer_gallery_image);
        update_option('background_option', $background_option);
        update_option('background_color', $background_color);
        update_option('Slazzer_Include_Processed', $Slazzer_Include_Processed);
        update_option('Slazzer_Preserve_Resize', $Slazzer_Preserve_Resize);
        
        update_option('Slazzer_gallery_image_IDs', $Slazzer_gallery_image_IDs);
        update_option('Slazzer_crop_image', $Slazzer_crop_image);
        $response = get_remaining_credits($slazzer_api_key,API_ACCOUNT); 
        $result['error'] = 1;  
        if($response == -1){
            $result['msg'] = 'Invalid api key.';
            update_option('invalid_api_key', 'true');
        }else{   
            $remaining_credit = get_option('remaining_credits'); 
            if($remaining_credit > 0){ 
                $result['error'] = 0; 
                $result['remaining_credit'] = 'Remaining Credits: '.$remaining_credit;
                update_option('invalid_api_key', 'false');
            }else{
                $result['msg'] = 'No credit left.Please recharge your credit balance.';
            }
        }

    }
    echo json_encode($result);  
    exit;
}