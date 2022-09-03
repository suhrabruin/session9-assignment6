<?php

require_once 'model/Model.php';
require_once 'model/Category.php';
require_once 'helpers/functions.php';

$category_model = new Category();
$categories = $category_model->select();

if(isset($_POST['register_category'])){
    
    $input_names =['name'];
    $required_inputs =['name'];
    $data = get_post_data($input_names,$required_inputs);
    $errors = $data['errors'];
    unset($data['errors']);
    
    $data['created_by'] = 1; ///get current user id
    $data['create_date'] = date("Y-m-d h:i:s");

    if(empty($errors)){        
        if($category_model->insert($data)){
            set_message('success',"Record added successfully!");
        }else{
            set_message('error',"Something went wrong!");
        }
        redirect('categories.php');
    }

    set_message('errors',$errors);
    set_message('data',$data);
    redirect('category.php?register=true');


}elseif(isset($_GET['edit'])){
    $id = (int)$_GET['id'];
    $where = ['id'=>$id];
    $join = '';
    $order_by = '';
    $single = true;
    $category = $category_model->select('*',$where,$join,$order_by,$single);
}elseif(isset($_POST['save_edit'])){
    
    $input_names =['id','name'];
    $required_inputs =['id','name'];
    $data = get_post_data($input_names,$required_inputs);
    
    $data['update_date'] = date("Y-m-d h:i:s");
    $data['updated_by'] = 2; ///get current user id
    
    $errors = $data['errors'];
    unset($data['errors']);
 
    if(empty($errors)){        
        if($category_model->update($data, $data['id'])){
            set_message('success',"Record update successfully!");
        }else{
            set_message('error',"Something went wrong!");
        }
        redirect('categories.php');
    }
    set_message('errors',$errors);
    set_message('data',$data);
    redirect('category.php?id='.$data['id'].'&edit=true');
}elseif(isset($_GET['delete'])){  
    
    $id = (int)$_GET['id'];
    $where = ['id'=>$id];
    $join = '';
    $order_by = '';
    $single = true;
    $category = $category_model->select('*',$where,$join,$order_by,$single);
    if($category){
        if($category_model->delete($id)){
            set_message('success',"Record deleted successfully!");
        }else{
            set_message('error',"Something went wrong!");
        }
    }else{
        set_message('error',"Invalid action!");
    }
    
    redirect('categories.php');
}