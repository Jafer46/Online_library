<?php
session_start();

if(isset($_SESSION['user_id'])&&(isset($_SESSION['user_name']))){

    include"db_conn.php";

    #category helper function
    include "php/func-category.php";
    $categories = get_all_category($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleSheet/styleAdmin.css?v=<?php echo time();?>">
    <title>Add Book</title>
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
    <form action="php/add-book.php" method="POST" enctype="multipart/form-data" class="shadow rounded-box"> 
        <h1 align="center">Add New Book</h1>
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
        <label for="btitle">Book Title</label><br>
        <input type="text" name="btitle"><br>
        <label for="bauthor">Book Author</label><br>
        <input type="text" name="bauthor"><br>
        <label for="bdescription">Book description</label><br>
        <input type="text" name="bdescription"><br>
        <label for="bcategory">Book category</label><br>
        <select name="bcategory" id="" class="input">
            <option value="0">
                select category
            </option>
            <?php
            if($categories == 0){

            }else{
            foreach($categories as $category){?>
                <option value="<?=$category['id']?>">
                    <?=$category['name']?>
                </option>
            <?php } }
            ?>
        </select><br>
        <label for="bcover">Book cover</label><br>
        <input type="file" name="bcover"><br>
        <label for="bfile">PDF File</label><br>
        <input type="file" name="bfile"><br>
        <button  class="btn btn-blue">Add Book</button>
    </form>

</div>
</body>
</html>

<?php }else{
    header("location: login.php");
    exit;
}
?>