<?php





function get_remaining_credits($slazzer_api_key, $api_url): int

{

    $postRequest = array('api_key' => $slazzer_api_key);

    $args = array(

        'body' => $postRequest,

        'timeout' => '2000',

        'redirection' => '5',

        'httpversion' => '1.0',

        'blocking' => true,

        'headers' => array(),

        'cookies' => array(),

    );



    $apiResponse = wp_remote_post($api_url, $args);

    $jsonArrayResponse = json_decode($apiResponse['body']);

    //if (array_key_exists("status", $jsonArrayResponse)) {

    if (isset($jsonArrayResponse->status)) {

        return -1;

    } else {

        $remaining_credits = $jsonArrayResponse->total_credits;
        update_option('remaining_credits', $remaining_credits);

        return $remaining_credits;

    }





}



function remove_image_background($arr_request_body, $slazzer_api_key){

    $args = array(

        'body' => $arr_request_body['request_body'],

        'timeout' => '2000',

        'redirection' => '5',

        'httpversion' => '1.0',

        'blocking' => true,

        'headers' => array("API-KEY" => $slazzer_api_key,'preview' => true),

        'cookies' => array(),

    );

    $apiResponse = wp_remote_post(API_SLAZZER_BACKGROUND_REMOVER, $args);


    $response_code = (int)$apiResponse['response']['code'];


    return array("status" => $response_code == 200 ? true : false, "api_response" => $apiResponse['body']);

}



