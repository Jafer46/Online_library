<?php
session_start();

if(isset($_SESSION['user_id'])&&(isset($_SESSION['user_name']))){

    #databade connection
    include "db_conn.php";

    #book helper function
    include "php/func_book.php";
    $books = get_all_books($conn);

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
    <title>Admin Page</title>
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

        <form action="searchAdmin.php" style="width:90%;" method="get">
            <div class="input-container">
                <input type="text" placeholder="search book ..." class="ininput" name="key">
                <button class="btn btn-blue">search</button>
            </div>
        </form>

        <?php if(isset($_GET['error'])){ ?>              
               <div class="alert alert-red"><?php echo $_GET['error']; ?></div>
               <?php
               }                
        ?>
        <?php if(isset($_GET['success'])){ ?>              
               <div class="alert alert-green" id="alert"><?php echo $_GET['success']; ?></div>
               <?php
               }                
        ?>
    <?php if ($books == 0){?>
        <div class="alert alert-yellow text-center">
            The is no book in the database
        </div>
    <?php }else{?>
    <div class="table-title">All Books</div>
    <table class="shadow">
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Author</th>
            <th class="collapse">Description</th>
            <th>Catagory</th>
            <th>Action</th>
        </tr> 
        </thead>
        <tbody>
        <?php 
        $i = 0;
        foreach ($books as $book){
            $i++;
            ?>            
            <tr>
                <td><?=$i?></td>
                <td>
                    <a href="uploads/files/<?=$book['file']?>">
                    <img width ="100" style="display:block;"
                    src="uploads/cover/<?=$book['cover']?>" alt="book cover">
                    <?=$book['title']?></a>
                </td>
                <td><?=$book['author']?></td>
                <td class="collapse"><?=$book['description']?></td>
                <td>
                    <?php if($categories == 0){
                        echo "undefined";
                        }else{
                            foreach($categories as $category){
                                if ($category['id'] == $book['category_id']){
                                    echo $category['name'];
                                }
                            }
                        }
                    ?>
                </td>
                <td>                
                    <a href="edit-book.php?id=<?=$book['id']?>" class="btn btn-yellow a-list">Edit</a>
                    <a href="php/delete-book.php?id=<?=$book['id']?>" class="btn btn-red a-list">Delete</a>
                </td>
                </tr>
            <?php  }?>                
        <?php }?>
        </tbody>     
    </table>
    <?php if ($categories == 0){?>
        <div class="alert alert-yellow text-center">
            The is no category in the database
        </div>
    <?php }else{?>
    <div class="table-title">All category</div>
    <table class="shadow">
        <thead>
            <tr>
                <th>id</th>
                <th>Catagory name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $j = 0;
            foreach($categories as $category){
                $j++;
                ?>
                <tr>
                    <td><?=$j?></td>
                    <td><?=$category['name']?></td>
                    <td>
                        <a href="edit-category.php?id=<?=$category['id']?>" class="btn btn-yellow a-list">Edit</a>
                        <a href="php/delete-category.php?id=<?=$category['id']?>" class="btn btn-red a-list">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php }?>
    </div>  
    
</body>
</html>

<?php }

else{
    header("Location: login.php");
    exit;
}

?>