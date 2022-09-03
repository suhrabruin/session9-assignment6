<?php

require_once 'model/Model.php';
require_once 'model/Login.php';
require_once 'helpers/functions.php';

$login_model = new Login();

if(isset($_POST['login'])){
    
    $input_names =['username','password'];
    $required_inputs =['username','password'];
    $data = get_post_data($input_names,$required_inputs);
    $errors = $data['errors'];
    unset($data['errors']);

    if(empty($errors)){
        if($user = $login_model->login_to($data)){
            set_message('auth_user',$user);
            set_message('login',true);
            redirect('posts.php');
        }else{
            set_message('error',"Login failed!");            
        }
    }
    set_message('errors',$errors);
    set_message('data',$data);
    redirect('login.php');
}