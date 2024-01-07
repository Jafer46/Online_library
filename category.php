<?php
   session_start();
   
   #if category id is not set
   if(!isset($_GET['id'])){
        header("location: index.php");
        exit;
   }
   #get id information
   $id = $_GET['id'];

   #databade connection
   include "db_conn.php";

   #book helper function
   include "php/func_book.php";
   $books = get_books_by_category($conn, $id);

   #category helper function
   include "php/func-category.php";
   $categories = get_all_category($conn);
   $curr_category = get_category($conn, $id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleSheet/stylemain.css?v=<?php echo time();?>">
    <title>CS genral library</title>
</head>
<body>
    <div class="nav-container">
        <div class="left-top">
            CS
        </div>
        <div class="left-bottom">
            <div class="text-white">Browse</div>
            <nav class="list-container">
                <a href="index.php" class="active">Library</a>
                <?php if(isset($_SESSION['user_id'])){?>
                    <a href="admin.php" class="">admin</a>
                <?php }else{?>
                <a href="login.php" class="">login</a>
                <?php }?>
            </nav>
        </div>
        
    </div>
    <div class="book-container">
        
        <div class="middle-top">
            
            <h1>Library</h1>
            <div class="grow"></div>
            <form action="search.php" method="get">
            <div class="input-container">
                <input type="text" placeholder="search books" class="input grow" name="key">
                <button class="search-btn">
                <img src="images/icon/icons8-search-30.png" alt="" width="20px">
                </button>
            </div>
            </form>
        </div>
        <div><?php echo $curr_category['name']?></div>
        <div class="middle-bottom">
            
            <?php if($books == 0){?>
                no results
            <?php }else{?>
            <?php foreach($books as $book){ ?>                        
                <div class="card">
                    <div class="card-image" style="background-image: url(uploads/cover/<?=$book['cover']?>);">
                        <a href="uploads/files/<?=$book['file']?>"
                            class="btn btn-blue" 
                            download="<?=$book['title']?>">
                            <img src="images/icons8-download-64.png" alt="" width="20px" download="flase">
                        </a>
                    </div>                            
                    <div class="card-body">
                        <a href="uploads/files/<?=$book['file']?>" style="color: black;margin:0;padding:0;"><h5><?=$book['title']?></h5></a>                            
                        <p class="card-text">
                            <i>By:<?=$book['author']?></i>
                            <i>Category:
                            <?php foreach($categories as $category){
                                if($category['id']==$book['category_id']){
                                    echo $category['name'];
                                    break;
                                }
                            }?></i>                                    
                        </p>                                                          
                    </div> 
                    <div class="overlay">
                        <?=$book['description']?>
                    </div>                       
                </div>
                    <?php }?>
            <?php }?>
        </div>
    </div>
    <div class="search-opt-container">
        <div class="right-top">
            Other Search Options
        </div>
        <div class="right-middle">
            <div>Category    search</div><hr>
            <div class="category-list-container">
                <?php if($categories == 0){
                    echo "no category to choose from"; 
                }else{
                    foreach($categories as $category){?>                    
                       <a href="category.php?id=<?=$category['id']?>" 
                       class="category-list"><?=$category['name']?></a>
                      
                <?php } }?>
            </div>
        </div>
        <div class="right-bottom"></div>
    </div>

</body>
</html>