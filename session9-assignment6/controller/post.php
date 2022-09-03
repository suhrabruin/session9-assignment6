<?php
require_once 'model/Model.php';
require_once 'model/Post.php';
require_once 'helpers/functions.php';


$post_model = new Post();
$auth_user = auth_user();

// var_dump($_GET);

if(isset($_POST['submit_post'])){

    $input_names =['title','content','category_id'];
    $required_inputs =['title','content','category_id'];
    $data = get_post_data($input_names,$required_inputs);
    
    $data['author_id'] = $auth_user['id'];
    $data['post_date'] = date("Y-m-d H:i:s");
    $errors = $data['errors'];
    unset($data['errors']);

    
    if(empty($errors)){        
        if($temp_path = get_image_path($_FILES['post_image'])){
            $data['image_path'] =$temp_path;            
        }             
        if($post_model->insert($data)){
            set_message('success',"Record added successfully!");
        }
        redirect('posts.php');
    }
    

    set_message('errors',$errors);
    set_message('data',$data);
    redirect('add_post.php');

}elseif(isset($_POST['save_edit_post'])){  
    $input_names =['id','title','content','category_id'];
    $required_inputs =['id','title','content','category_id'];
    $data = get_post_data($input_names,$required_inputs);
    
    $data['updated_by'] = $auth_user['id'];
    $data['updated_date'] = date("Y-m-d H:i:s");
    $errors = $data['errors'];
    unset($data['errors']);
    $post_id = $data['id'];
    unset($data['id']);
    
    if(empty($errors)){
        if($temp_path = get_image_path($_FILES['post_image'])){
            $data['image_path'] =$temp_path;            
        }

        if($post_model->update($data, $post_id)){
            set_message('success',"Record update successfully!");
        }else{
            set_message('error',"Something went wrong!");
        }
        redirect('posts.php');
    }
    set_message('errors',$errors);
    set_message('data',$data);
    redirect('add_post.php');

}elseif(isset($_GET['id']) && isset($_GET['delete_post'])){
    if($post_model->delete((int)$_GET['id'])){
        set_message('success',"Record deleted successfully!");
    }else{
        set_message('error',"Something went wrong!");
    }
    redirect('posts.php');
  
    
}elseif(isset($_GET['category_id'])){
    $select = "posts.id, posts.title, posts.content, posts.image_path, posts.post_date,
    users.name as `author`, categories.name as `category_name`,
    categories.id as `category_id`,users.id as `author_id`";
    $join = " INNER JOIN `users` ON posts.author_id = users.id ";
    $join .= " INNER JOIN `categories` ON posts.category_id = categories.id ";
    $order_by = ' ORDER By posts.post_date DESC';
    $where = ["category_id"=>$_GET['category_id']];

    $data = $post_model->select($select,$where,$join,$order_by,false);
   

}elseif(isset($_GET['author_id'])){
    $select = "posts.id, posts.title, posts.content, posts.image_path, posts.post_date,
    users.name as `author`, categories.name as `category_name`,
    categories.id as `category_id`,users.id as `author_id`";
    $join = " INNER JOIN `users` ON posts.author_id = users.id ";
    $join .= " INNER JOIN `categories` ON posts.category_id = categories.id ";
    $order_by = ' ORDER By posts.post_date DESC';
    $where = ["author_id"=>$_GET['author_id']];

    $data = $post_model->select($select,$where,$join,$order_by,false);
    
}elseif(isset($_GET['id'])){
    
    $select = "posts.id, posts.title, posts.content, posts.image_path, posts.post_date,
    users.name as `author`, categories.name as `category_name`,
    categories.id as `category_id`,users.id as `author_id`";
    $join = " INNER JOIN `users` ON posts.author_id = users.id ";
    $join .= " INNER JOIN `categories` ON posts.category_id = categories.id ";
    $order_by = ' ORDER By posts.post_date DESC';
    $where = ["posts.id"=>$_GET['id']];
    

    $data = $post_model->select($select,$where,$join,$order_by,true);


}else{
    $select = "posts.id, posts.title, posts.content, posts.image_path, posts.post_date,
    users.name as `author`, categories.name as `category_name`,
    categories.id as `category_id`,users.id as `author_id`";
    $join = " INNER JOIN `users` ON posts.author_id = users.id ";
    $join .= " INNER JOIN `categories` ON posts.category_id = categories.id ";
    $order_by = ' ORDER By posts.post_date DESC';
    $data = $post_model->select($select,[],$join,$order_by,false);    
}