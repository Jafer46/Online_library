<?php
session_start();

if(isset($_SESSION['user_id'])&&(isset($_SESSION['user_name']))){

    if(!isset($_GET['id'])){
        header("location: admin.php");
        exit;
    }

    $id = $_GET['id'];

    #databade connection
    include "db_conn.php";

    #category helper function
    include "php/func-category.php";
    $category = get_category($conn, $id);

    if($category == 0){
        header("location: admin.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleSheet/styleAdmin.css?v=<?php echo time();?>">
    <title>Edit Category</title>
</head>
<body>
<div class="flex-container">
    <div class="list-container">
        <a href="admin.php" class="a-big-font a-list">Admin</a>
        <a href="index.php" class="a-list">Library</a>
        <a href="add-book.php" class="a-list">Add Book</a>
        <a href="add-category.php" class="a-list">Add Category</a>
        <a href="admincontact.php" class="a-list">Contact</a>
        <a href="logout.php" class="a-list">Logout</a>
    </div>
    <form action="php/edit-category.php" method="POST" class="shadow rounded-box"> 
        <h1 align="center">Edit Category</h1>
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
        <label for="category_name">Category name</label><br>
        <input type="text" hidden name="category_id" value="<?=$category['id']?> "><br>
        <input type="text" name="category_name" value="<?=$category['name']?>"><br>
        <button  class="btn btn-blue">Update</button>
    </form>

</div>
</body>
</html>
<?php }else{
    header("location: login.php");
    exit;
}
?>