<?php 
require_once 'includes/header.php';
require_once 'helpers/functions.php';
require_once 'controller/category.php';
require_once 'controller/post.php';


// var_dump($_GET);
// die;
?>
<?php if(isset($_GET['display'])):?>

    <div class="post">
        <h2 style="text-align:center;"><?php echo $data['title'];?></h2>
        <span>Posted at:<?php echo $data['post_date'];?></span>
        <span>Author:<a href="posts.php?author_id=<?php echo $data['author_id'];?>"><?php echo $data['author'];?></a></span>
        <span>Category:<a href="posts.php?category_id=<?php echo $data['category_id'];?>"><?php echo $data['category_name'];?></a></span>
        
        <div style="display:flex;flex-direction:column;">
            <?php if(!empty($data['image_path'])):?>
                <img style="width:200px;" src="<?php echo $data['image_path'];?>"/>
            <?php else: ?>
                <img  style="width:200px;" src="assets/images/profile-demo.png"/>
            <?php endif;?>
            <p><?php echo $data['content'];?></p>
        </div>        
        <a href="posts.php">&lt;&lt;Back</a>
        <hr/>
    </div>
<?php
elseif(isset($_GET['edit_post'])):?>
<form action="#" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" id="id" value="<?php echo isset($data['id'])?$data['id']:""; ?>"/>

    <label for="title">Title:</label>
    <input class="user-input" type="text" name="title" id="title" placeholder="Post Title"
    value="<?php echo isset($data['title'])?$data['title']:""; ?>"/>
    <?php echo isset($errors['title'])?"<span class='error'>{$errors['title']}</span>":""; ?>
    <br/>
    <label for="content">Content:</label>
    <textarea name="content"><?php echo isset($data['content'])?$data['content']:""; ?></textarea>
    <?php echo isset($errors['content'])?"<span class='error'>{$errors['content']}</span>":""; ?>
    <br/>
    <label for="category_id">Category:</label>
    <select class="user-select" name="category_id" id="category_id">
        <option disabled selected>Select post category</option>
        <?php foreach($categories as $category):?>
        <option 
        
        <?php echo (isset($data['category_id']) && $data['category_id']==$category['id'])?"selected":""; ?>
        value="<?php echo $category['id'];?>"><?php echo $category['name'];?></option>      
        <?php endforeach;?>      
    </select>
    <?php echo isset($errors['category_id'])?"<span class='error'>{$errors['category_id']}</span>":""; ?>
    <br/>
    <?php if(!empty($data['image_path'])):?>
        <img style="width:200px;" src="<?php echo $data['image_path'];?>"/>
    <?php endif;?>       
    <label for="post_image">Upload Post Image (if any) </label>
    <input class="user-input" type="file" name="post_image" id="post_image" /><br/>
    <br/>
    <input type="submit" name="save_edit_post" id="save_edit_post" value="Submit"/>            
</form>

<?php elseif(isset($_GET['new_post'])):?>
    <form action="post.php" method="post" enctype="multipart/form-data">
    <label for="title">Title:</label>
    <input class="user-input" type="text" name="title" id="title" placeholder="Post Title"
    value="<?php echo isset($data['title'])?$data['title']:""; ?>"/>
    <?php echo isset($errors['title'])?"<span class='error'>{$errors['title']}</span>":""; ?>
    <br/>
    <label for="content">Content:</label>
    <textarea name="content"><?php echo isset($data['content'])?$data['content']:""; ?></textarea>
    <?php echo isset($errors['content'])?"<span class='error'>{$errors['content']}</span>":""; ?>
    <br/>
    <label for="category_id">Category:</label>
    <select class="user-select" name="category_id" id="category_id">
        <option disabled selected>Select post category</option>
        <?php foreach($categories as $category):?>
        <option 
        
        <?php echo (isset($data['category_id']) && $data['category_id']==$category['id'])?"selected":""; ?>
        value="<?php echo $category['id'];?>"><?php echo $category['name'];?></option>      
        <?php endforeach;?>      
    </select>
    <?php echo isset($errors['category_id'])?"<span class='error'>{$errors['category_id']}</span>":""; ?>
    <br/>

    <label for="post_image">Upload Post Image (if any) </label>
    <input class="user-input" type="file" name="post_image" id="post_image" /><br/>
    <br/>
    <input type="submit" name="submit_post" id="submit_post" value="Submit"/>            
</form>

    
<?php endif; ?>


<?php require_once 'includes/footer.php';?>