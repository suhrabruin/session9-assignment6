<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <!-- CSS only -->
</head>
<body>
    <?php
    require_once 'helpers/functions.php';
    ?>
    <div class="main-wrapper">
        <header class="header-menu">
            <ul>
                <!-- <li class="btn-home"><a href="index.php">Home</a></li> -->
                <li class="btn-post"><a href="posts.php">Posts</a></li>
                <?php if(is_login() && is_admin()):?>
                <li class="btn-user"><a href="users.php">Users</a></li>
                <li class="btn-logout"><a href="categories.php">Categories</a></li>
                <?php endif;?>
                    <li id="left-nav"></li>
                <?php if(is_login()):?>
                    <li class="btn-profile"><a href="user.php?profile=true">Profile</a></li>
                    <li class="btn-reset-password"><a href="user.php?reset_password=true">Reset Password</a></li>
                    <li class="btn-logout"><a href="user.php?logout=true.php">Logout</a></li>
                <?php else:?>
                    <li class="btn-logout"><a href="login.php">Login</a></li>
                <?php endif;?>
                
            </ul>
        </header>
        <?php 
            $auth = auth_user();
            if(isset($auth['name'])){
                echo '<p style="text-align:right;">Dear '.$auth['name'] .'</p>';
            }
        ?> 