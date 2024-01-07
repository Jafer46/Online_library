<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleSheet/style.css?v=<?php echo time();?>">
    <title>Login</title>
</head>
<body>
    
    <div class="login-box shadow">
        <form method="POST" action="php/signin.php">
            <h1 align="center">Sign In</h1>
            <?php if(isset($_GET['error'])){ ?>              
               <div class="alert alert-red"><?php echo $_GET['error']; ?></div>
               <?php
               }                
            ?>
            <label for="fname">Full name</label><br>
            <input type="text" name="fullname" id="ExampleUserFName"><br>        
            <label for="Uname">User name</label><br>
            <input type="text" name="username" id="ExampleUserName"><br>
            <label for="Password">Password</label><br>
            <input type="password" name="password" id="ExamplePassWord"><br><br>
            <button>sign in</button>
            <a href="login.php">login</a><br>
        </form>
    </div>
</body>
</html>