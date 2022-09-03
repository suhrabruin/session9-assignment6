<?php
require_once 'includes/header.php';
require_once 'controller/category.php';

$errors = get_message('errors');
$data = get_message('data');

?>    
<?php echo "<p style='color:green;'>".get_message('success')."</p>";?>
<?php echo "<p style='color:red;'>".get_message('error')."</p>";?>

<!-- **** -->
<!-- Add a Category -->
<!-- **** -->
<?php if(isset($_GET['register'])){  ?>
    <div id="register-div">
        <h3>Add New Category</h3>
        <form action="category.php" method="post" id="register_form" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input class="user-input" type="text" name="name" id="name" placeholder="Name" value="<?php echo isset($data['name'])?$data['name']:"";?>"/>
            <span class="error"><?php echo isset($errors['name'])?$errors['name']:"";?></span><br/>
            <input type="submit" name="register_category" id="btn-register" value="Submit"/>
        </form>
    </div>

<!-- **** -->
<!-- Edit a Category -->
<!-- **** -->
<?php }elseif(isset($_GET['edit'])){ ?>
        <h2>Edit</h2>
        <div id="register-div">
            <form action="category.php" method="post" id="register_form" enctype="multipart/form-data">
                <input class="user-input" type="hidden" name="id" id="id" value="<?php echo isset($category['id'])?$category['id']:"";?>"/>
                <label for="name">Name:</label>
                <input class="user-input" type="text" name="name" id="name" placeholder="Name" value="<?php echo isset($category['name'])?$category['name']:"";?>"/>
                <span class="error"><?php echo isset($errors['name'])?$errors['name']:"";?></span><br/>
                <input type="submit" name="save_edit" id="btn-register" value="Edit"/>            
            </form>
        </div>

<!-- **** -->
<!-- Delete User Profile Image Process -->
<!-- **** -->
<?php }elseif(isset($_GET['delete_image'])){  ?>


<!-- **** -->
<!-- Display User details page-->
<!-- **** -->
<?php }elseif(isset($_GET['details'])){ ?>
    <h2>User Details</h2>
    <span class="error"><?php echo get_message('error');?></span><br/>
    <div class="profile">
        <div class="profile-img-div">
            <img class="profile-img" src="<?php 
            if(isset($user['image_path'])  && !empty($user['image_path']) && file_exists($user['image_path'])){
                echo $user['image_path'];
            }else{
                echo get_default_image();
            } 
            ?>" alt="Profile Picture"/>
            <br/>
            <?php if(!empty($user['image_path'])){ ?>
                <a style="background:red;color:white; padding:2px 5px; border-radius:3px; text-decoration:none; text-align:center;" href="user.php?id=<?php echo $user['id'];?>&delete_image=true" onclick="return confirm('Are you sure to delete?')">Delete Image</a>
            <?php } ?>
        </div>
        <div>
            <p class="profile-id"><span>ID:</span><?php echo $user['id'];?></p>
            <p class="profile-name"><span>Name:</span><?php echo $user['name'];?></p>
            <p class="profile-age"><span>Age:</span><?php echo $user['age'];?></p>
            <p class="profile-username"><span>Username:</span><?php echo $user['username'];?></p>
            <p class="profile-email"><span>Email:</span><?php echo $user['email'];?></p>
            <p class="profile-email"><span>Role:</span><?php echo $user['role'];?></p>
            <p>

            <a style="background:green;color:white; padding:2px 5px; border-radius:3px; text-decoration:none;" href="user.php?id=<?php echo $user['id'];?>&edit=true">Edit</a>
            <a style="background:red;color:white; padding:2px 5px; border-radius:3px; text-decoration:none;" href="user.php?id=<?php echo $user['id'];?>&delete=true" onclick="return confirm('Are you sure to delete?')">Delete</a>
            </p>
        </div>
    </div>

<!-- **** -->
<!-- Display User Profile Page -->
<!-- **** -->
<?php }elseif(isset($_GET['profile'])){ ?>
<h2>My Profile</h2>
<span class="error"><?php echo get_message('error');?></span><br/>
<div class="profile">
    <div class="profile-img-div">
        <img class="profile-img" src="<?php
        
        if(isset($user['image_path'])  && !empty($user['image_path']) && file_exists($user['image_path'])){
            echo $user['image_path'];
        }else{
            echo get_default_image();
        }         
        ?>" alt="Profile Picture"/>
        <form action="user.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $user['id'];?>">            
            <input type="file" name="profile_image">
            <input class="btn" type="submit" name="upload_profile_image" value="Upload"/>
        </form>
    </div>
    <div>
        <p class="profile-id"><span>ID:</span><?php echo $user['id'];?></p>
        <p class="profile-name"><span>Name:</span><?php echo $user['name'];?></p>
        <p class="profile-age"><span>Age:</span><?php echo $user['age'];?></p>
        <p class="profile-username"><span>Username:</span><?php echo $user['username'];?></p>
        <p class="profile-email"><span>Email:</span><?php echo $user['email'];?></p>
        <p class="profile-email"><span>Role:</span><?php echo $user['role'];?></p>
    </div>
</div>

<!-- **** -->
<!-- Display Password Reset Page -->
<!-- **** -->
<?php }elseif(isset($_GET['reset_password'])){  ?>
    <h2>Password Reset</h2>
<div style="width:300px; box-shadow: 0 0 1px black; padding:15px;">
    <form action="user.php" method="post" id="register_form">
        <label for="old_password">Current Password:</label>            
        <input class="user-input" type="password" name="old_password" placeholder="Current Password" 
        value="<?php echo isset($data['old_password'])?$data['old_password']:'';?>" />
        <span class="error"><?php echo isset($errors['old_password'])?$errors['old_password']:"";?></span><br/>
        
        <label for="new_password">New Password:</label>            
        <input class="user-input" type="password" name="new_password" placeholder="New Password"
        value="<?php echo isset($data['new_password'])?$data['new_password']:'';?>"/>
        <span class="error"><?php echo isset($errors['new_password'])?$errors['new_password']:"";?></span><br/>
        
        <label for="confirm_password">Confirm New Password:</label>
        <input class="user-input" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm your new password"
        value="<?php echo isset($data['confirm_password'])?$data['confirm_password']:'';?>"/>
        <span class="error"><?php echo isset($errors['confirm_password'])?$errors['confirm_password']:"";?></span><br/>
        
        <input class="btn" type="submit" name="submit_reset_password" id="btn-register" value="Reset"/>
    </form>
</div>
<?php }elseif(isset($_GET['logout'])){  ?>
    <h2>logout operation here</h2>

<?php } ?>




<?php require_once 'includes/footer.php';?>