
<?php
require_once 'includes/header.php';
require_once 'controller/user.php';
?>

<?php if(!is_admin()):
    set_message('error',"Invalid action not allowed!");
    redirect('posts.php');
endif;?>

<!-- **** -->
<!--Display Users Page -->
<!-- **** -->

<h2>Users</h2>

<a href="user.php?register=true" class="btn-register btn">Register</a>
<?php echo "<p style='color:green;'>".get_message('success')."</p>";?>
<?php echo "<p style='color:red;'>".get_message('error')."</p>";?>

<div class="users">
    <table>
        <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Username</th>
            <th>Role</th>
            <th>Email</th>
            <th>Image Path</th>
            <th>Action</th>
        </thead>
        <tbody>
            <?php foreach($users as  $user):?>
            <tr>
                <td><?php echo $user['id'];?></td>
                <td><?php echo $user['name'];?></td>
                <td><?php echo $user['age'];?></td>
                <td><?php echo $user['username'];?></td>
                <td><?php echo $user['role'];?></td>
                <td><?php echo $user['email'];?></td>
                <td>
                    <img style="width:50px; height:50px;" src="<?php 
                        if(isset($user['image_path'])  && !empty($user['image_path']) && file_exists($user['image_path'])){
                            echo $user['image_path'];
                        }else{
                            echo get_default_image();
                        } 
                    ?>" alt="Profile Picture"/>
                    <br/>
                    <?php if(!empty($user['image_path'])){ ?>
                        <a style="background:red;color:white; padding:2px 5px; border-radius:3px; text-decoration:none;" href="user.php?id=<?php echo $user['id'];?>&delete_image=true" onclick="return confirm('Are you sure to delete?')">Delete</a>
                    <?php } ?>
                </td>
                <td><a style="background:green;color:white; padding:2px 5px; border-radius:3px; text-decoration:none;" href="user.php?id=<?php echo $user['id'];?>&edit=true">Edit</a>
                <a style="background:red;color:white; padding:2px 5px; border-radius:3px; text-decoration:none;" href="user.php?id=<?php echo $user['id'];?>&delete=true" onclick="return confirm('Are you sure to delete?')">Delete</a>
                <a style="background:blue;color:white; padding:2px 5px; border-radius:3px; text-decoration:none;" href="user.php?id=<?php echo $user['id'];?>&details=true">Details</a></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<?php require_once 'includes/footer.php';?>