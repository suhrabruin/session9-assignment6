<?php 
require_once 'includes/header.php';
require_once 'controller/post.php';
?>
<h2>Posts</h2>

<?php if(is_login()):?>
    <a href="post.php?new_post=true" class="btn-register btn">Add Post</a>
<?php endif;?> 
<br/>
<?php echo "<p style='color:green;'>".get_message('success')."</p>";?>
<?php echo "<p style='color:red;'>".get_message('error')."</p>";?>

<?php foreach($data as $post):?>
    <div class="post">
        <h2 style="text-align:center;"><?php echo $post['title'];?></h2>        
        <p>
            <span>Posted at:<?php echo $post['post_date'];?></span>            
            <span>Author:<a href="posts.php?author_id=<?php echo $post['author_id'];?>"><?php echo ucwords($post['author']);?></a></span>
            <span>Category:<a href="posts.php?category_id=<?php echo $post['category_id'];?>"><?php echo $post['category_name'];?></a></span>

    <?php if(is_admin() || (isset($auth_user['id']) && $auth_user['id'] == $post['author_id'])):?>
            <a href="post.php?id=<?php echo $post['id'];?>&edit_post=true">Edit</a>
            <a href="post.php?id=<?php echo $post['id'];?>&delete_post=true" onclick="return confirm('Are you sure to delete?')">Delete</a>                
    <?php endif;?>

        </p>
        <div style="display:flex;">
            <?php if(!empty($post['image_path'])):?>
                <img style="width:100px;" src="<?php echo $post['image_path'];?>"/>
            <?php else: ?>
                <img  style="width:100px;" src="assets/images/profile-demo.png"/>
            <?php endif;?>
            <p><?php echo substr($post['content'],0,300);?></p>
        </div>        
        <a href="post.php?id=<?php echo $post['id'];?>&display=true">read more...</a>
        
        <hr/>
    </div>
<?php endforeach;?>

<?php require_once 'includes/footer.php';?>