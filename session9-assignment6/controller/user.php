<?php

require_once 'model/Model.php';
require_once 'model/User.php';
require_once 'helpers/functions.php';

$user_model = new User();
$users = $user_model->select();
$auth_user = auth_user();


if(isset($_POST['register_user'])){
    
    $input_names =['name','age','email','username','role','password','confirm_password'];
    $required_inputs =['name','age','email','username','role','password','confirm_password'];
    $data = get_post_data($input_names,$required_inputs);
    $errors = $data['errors'];
    
    if(isset($data['confirm_password'])){        
        $c_password = $data['confirm_password'];
        unset($data['confirm_password']);
    }
    unset($data['errors']);

    if(isset($data['password']) && $data['password'] !==$c_password){
        $errors['confirm_password'] = 'Password and Confirm Password fields do not match!';
    }
    if(isset($data['password'])){
        $data['password']=md5($data['password']);
    }

    if(empty($errors)){        
        if($temp_path = get_image_path($_FILES['profile_image'])){
            $data['image_path'] =$temp_path;            
        }
        if($user_model->insert($data)){
            set_message('success',"Record added successfully!");
        }else{
            set_message('error',"Something went wrong!");
        }
        redirect('users.php');
    }
    
    set_message('errors',$errors);
    set_message('data',$data);
    redirect('user.php?register=true');

    
}elseif(isset($_GET['details'])){
    $id = (int)$_GET['id'];
    $where = ['id'=>$id];
    $join = '';
    $order_by = '';
    $single = true;
    $user = $user_model->select('*',$where,$join,$order_by,$single);
}elseif(isset($_GET['edit'])){
    $id = (int)$_GET['id'];
    $where = ['id'=>$id];
    $join = '';
    $order_by = '';
    $single = true;
    $user = $user_model->select('*',$where,$join,$order_by,$single);
}elseif(isset($_POST['save_edit'])){
    
    $input_names =['id','name','age','email','username','role'];
    $required_inputs =['id','name','age','email','username','role'];
    $data = get_post_data($input_names,$required_inputs);
    $errors = $data['errors'];

    // $data['updated_date'] = date("Y-m-d h:i:sa");
      
    unset($data['errors']);
 

    if(empty($errors)){
        if($temp_path = get_image_path($_FILES['profile_image'])){
            $data['image_path'] =$temp_path;            
        }
       
        if($user_model->update($data, $data['id'])){
            set_message('success',"Record update successfully!");
        }else{
            set_message('error',"Something went wrong!");
        }
        redirect('users.php');
    }
    set_message('errors',$errors);
    set_message('data',$data);
    redirect('user.php?id='.$data['id'].'&edit=true');

}elseif(isset($_GET['delete'])){  
    
    $id = (int)$_GET['id'];
    $where = ['id'=>$id];
    $join = '';
    $order_by = '';
    $single = true;
    $user = $user_model->select('*',$where,$join,$order_by,$single);
    if($user){
        
        if(file_exists($user['image_path'])){
            unlink($user['image_path']);
        }
        
        if($user_model->delete($id)){
            set_message('success',"Record deleted successfully!");
        }else{
            set_message('error',"Something went wrong!");
        }
    }else{
        set_message('error',"Invalid action!");
    }
    
    redirect('users.php');
}elseif(isset($_GET['delete_image'])){  
    $id = (int)$_GET['id'];
    $where = ['id'=>$id];
    $join = '';
    $order_by = '';
    $single = true;
    $user = $user_model->select('*',$where,$join,$order_by,$single);
    if($user){        
        if(file_exists($user['image_path'])){
            unlink($user['image_path']);
        }
        $data['image_path'] = '';
        if($user_model->update($data,$id)){
            set_message('success',"Record deleted successfully!");
        }else{
            set_message('error',"Something went wrong!");
        }
    }else{
        set_message('error',"Invalid action!");
    }
    
    redirect('users.php');
}elseif(isset($_GET['profile'])){   
        
    $where = ['id'=>2];
    $join = '';
    $order_by = '';
    $single = true;
    $user = $user_model->select('*',$where,$join,$order_by,$single);


}elseif(isset($_POST['upload_profile_image'])){
    
    $input_names =['id'];
    $required_inputs =['id'];
    $data = get_post_data($input_names,$required_inputs);
    $errors = $data['errors'];
      
    unset($data['errors']);
    
    if(empty($errors)){
        if($temp_path = get_image_path($_FILES['profile_image'])){
            $data['image_path'] =$temp_path;            
        }
       
        if($user_model->update($data, $data['id'])){
            set_message('success',"Record update successfully!");
        }else{
            set_message('error',"Something went wrong!");
        }
        redirect('users.php');
    }
    set_message('errors',$errors);
    set_message('data',$data);
    redirect('user.php?profile=true');



}elseif(isset($_POST['submit_reset_password'])){ 
    
        $input_names =['old_password','new_password','confirm_password'];
        $required_inputs =['old_password','new_password','confirm_password'];
        $data = get_post_data($input_names,$required_inputs);
        $errors = $data['errors'];
        $data['id'] = $auth_user['id'];
    
        
        if(isset($data['new_password']) && isset($data['confirm_password']) && $data['new_password'] !==$data['confirm_password']){
            $errors['confirm_password'] = 'Password and Confirm Password fields do not match!';
        }
        if(empty($errors)){
            $where = ['id'=>$data['id'],'password'=>md5($data['old_password'])];
            $join = '';
            $order_by = '';
            $single = true;
            $user = $user_model->select('*',$where,$join,$order_by,$single);
            if($user){
                if($user_model->update(['password'=>md5($data['new_password'])], $data['id'])){
                    set_message('success',"Password reset successfully!");
                    redirect('user.php?logout=true');
                }else{
                    set_message('error',"Something went wrong!");
                }
            }else{
                set_message('error',"Invalid attempt!");
            } 
        }
        
        set_message('errors',$errors);
        set_message('data',$data);
        redirect('user.php?reset_password=true');
}