<?php
session_start();

if(isset($_SESSION['user_id'])&&(isset($_SESSION['user_name']))){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleSheet/styleAdmin.css?v=<?php echo time();?>">
    <title>Add Category</title>
</head>
<body>
<div class="flex-container">
    <div class="list-container">
        <a href="admin.php" class="a-big-font a-list">Admin</a>
        <a href="index.php" class="a-list">Home</a>
        <a href="add-book.php" class="a-list">Add Book</a>
        <a href="add-category.php" class="a-list">Add Category</a>
        <a href="admincontact.php" class="a-list">Contact</a>
        <a href="logout.php" class="a-list">Logout</a>
    </div>
    <form action="php/add-category.php" method="POST" class="shadow rounded-box"> 
        <h1 align="center">Add New Category</h1>
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
        <label for="category">Category name</label><br>
        <input type="text" name="category"><br>
        <button  class="btn btn-blue">Add Category</button>
    </form>

</div>
</body>
</html>
<?php }else{
    header("location: login.php");
    exit;
}
?>