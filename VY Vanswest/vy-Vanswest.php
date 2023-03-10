<?php
/* Plugin Name: VY Vanswest API
    Description: use the VY API to get data
    Version: 0.1.0
    Author: Huaiqing Han
*/

//Un authorised person cannot access to the file
defined('ABSPATH') or die('Unauthorised Access');
//action when login -- get the data from API
add_action('admin_init', 'getJSON');

function getJSON(){
    $url = 'https://dealers.virtualyard.com.au/api/v2/get.php?a=vehicles&key=OvtapBIat1bGjrrY2v1GesK8w4odENFJ5zyFYbX2Uoy5c8pqXXABJjvko7vrT3Y2EGbLXUtWMN37DO7NalSkzzGvI';
    $argument =array(
        'method' => 'GET'
    );
    //get the response from VY
    $response = wp_remote_get($url, $argument); 
    //list the error when get error message
    if(is_wp_error($response)){
        $error_msg = $response -> get_error_message();
        echo"something went wrong: $error_msg";
    }
    //test the outcome
    // echo '<pre>';
    // var_dump(wp_remote_retrieve_body($response));
    // echo '</pre>';
    $json_data = json_decode(wp_remote_retrieve_body($response), true);
    print_r('<pre>');
    print_r($json_data);
    print_r('</pre>');

    $files = fopen('file.csv','a');

    foreach($json_data as $row){
        fputcsv($files, $row);
    }

    fclose($files);

};

?>