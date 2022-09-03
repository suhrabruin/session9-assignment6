<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/login-styles.css">
</head>
<body>
    <?php      
    require_once 'controller/login.php';        
    ?>
    <?php
$errors = get_message('errors');
$data = get_message('data');
?>    

<?php echo "<p style='color:green;'>".get_message('success')."</p>";?>
<?php echo "<p style='color:red;'>".get_message('error')."</p>";?>
    <div class="login">
        <h3>Login</h3>
        <p>
            username: suhrab
            password: 1
        </p>
        <form action="login.php" method="post" id="login-form">
            <label for="username">Username:</label>
            <input class="login-input" type="text" name="username" placeholder="Username"/><br/>
            <span class="error"><?php echo isset($errors['username'])?$errors['username']:"";?></span><br/>

            <label for="username">Password:</label>
            <input class="login-input" type="password" name="password" placeholder="Password"/><br/>
            <span class="error"><?php echo isset($errors['password'])?$errors['password']:"";?></span><br/>

            <input type="submit" name="login" id="login" value="Login"/>
            <p class="links">
                <a href="signup.php">Signup</a>
                <a href="forgot_password.php" style="margin-left:50px;">Forgot Password</a>
            </p>
        </form>
        <p class="error"><?php echo get_message('error');?></p>
        <p class="success"><?php echo get_message('success');?></p>
    </div>
</body>
</html>