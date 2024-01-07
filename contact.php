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
        <form method="POST" action="php/add-contact.php" >
            <h1 align="center">Contact</h1>
            <?php if(isset($_GET['error'])){ ?>              
               <div class="alert alert-red"><?php echo $_GET['error']; ?></div>
               <?php
               }                
            ?>
            <?php if(isset($_GET['success'])){ ?>              
               <div class="alert alert-green"><?php echo $_GET['success']; ?></div>
               <?php
               }                
            ?>           
            <label for="email">email</label><br>
            <input type="email" name="email" id="ExampleUserName"><br>
            <label for="Password">Your Message</label><br>
            <input type="text" name="message" id="ExamplePassWord"><br><br>
            <button>Send</button>
            <a href="user.php">Home</a>
        </form>
    </div>
</body>
</html>