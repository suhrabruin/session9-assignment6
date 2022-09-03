<?php
require_once 'session.php';

function get_post_data($input_names,$required_inputs){
    $data = null;
    $errors = [];
    foreach($input_names as $name){
        if(in_array($name,$required_inputs) && empty($_POST[$name])){
            $temp = ucwords(str_replace("_"," ",$name));
            $errors[$name] = "{$temp} value must be filled!";            
        }else{
            $data[$name] = isset($_POST[$name]) ? $_POST[$name]:null;
        }
        
    }
   $data['errors'] = $errors;
    return $data;
}


function get_image_path($file){
    $image_path = null;
    if(isset($file['tmp_name']) && !empty($file['tmp_name'])){        
        $image_path = get_default_path()."/".date("Ymdhis")."_".$file['name'];

        if(!upload($file,$image_path)){
            $image_path = '';
        }        
    }
    return $image_path;
}

function get_default_path(){
    return 'assets/images/';
}

function get_default_image(){
    return get_default_path().'profile-demo.png';
}

function redirect($redirect_to){      
    header('Location: '.$redirect_to);
    exit;
}

function upload($file,$path){
    $file_name = $file['name'];
    $file_type = $file['type'];
    $file_temp_name = $file['tmp_name'];
    $file_error = $file['error'];
    $file_size = $file['size'];
 
     if($file_type!='image/jpeg' && $file_type!='image/jpg' && $file_type!='image/png'){        
        //  set_message("error","ONLY JPEG/PNG Images are allowed");
         echo "ONLY JPEG/PNG Images are allowed";
         return false;
     }else{           
         return move_uploaded_file($file_temp_name,$path);
     }
}

function set_message($name,$message){
    Session::set_session($name,$message);
}

function get_message($name){
    $msg =  Session::get_session($name);
    Session::set_session($name,null);    
    return $msg;
}

function is_login(){
    return Session::get_session('login');
}

function is_admin(){
    $auth_user = Session::get_session('auth_user');
    return (isset($auth_user['role']) && $auth_user['role']=="Admin");
}

function is_author(){
    $auth_user = Session::get_session('auth_user');
    return (isset($auth_user['role']) && $auth_user['role']=="Author");
}

function logout(){    
    Session::set_session('login',false);
    Session::set_session('auth_user',null);
    session_destroy();
    redirect('posts.php');
}

function auth_user(){
    return Session::get_session('auth_user');

}