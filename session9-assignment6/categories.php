
<?php
require_once 'includes/header.php';
require_once 'controller/category.php';
?>

<?php if(!is_admin()):
    set_message('error',"Invalid action not allowed!");
    redirect('posts.php');
endif;?> 

<!-- **** -->
<!--Display Categories Page -->
<!-- **** -->

<h2>Categories</h2>

<a href="category.php?register=true" class="btn-register btn">New Category</a>
<?php echo "<p style='color:green;'>".get_message('success')."</p>";?>
<?php echo "<p style='color:red;'>".get_message('error')."</p>";?>

<div class="users">
    <table>
        <thead>
            <th>ID</th>
            <th>Name</th>            
            <th>Created Date</th>           
            <th>Number of Posts</th>
            <th>Action</th>
        </thead>
        <tbody>
            <?php foreach($categories as  $category):?>
            <tr>
                <td><?php echo $category['id'];?></td>
                <td>

                    <span><a href="posts.php?category_id=<?php echo $category['id'];?>"><?php echo $category['name'];?></a></span>

                </td>
                
                <td><?php echo $category['create_date'];?></td>
                
                <td>

                </td>                                
                <td><a style="background:green;color:white; padding:2px 5px; border-radius:3px; text-decoration:none;" href="category.php?id=<?php echo $category['id'];?>&edit=true">Edit</a>
                <a style="background:red;color:white; padding:2px 5px; border-radius:3px; text-decoration:none;" href="category.php?id=<?php echo $category['id'];?>&delete=true" onclick="return confirm('Are you sure to delete?')">Delete</a>                
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<?php require_once 'includes/footer.php';?>