<?php
session_start();

if(isset($_SESSION['user_id'])&&(isset($_SESSION['user_name']))){

    #databade connection
    include "db_conn.php";
    
    #contact helper function
    include "php/func-contact.php";
    $contacts = get_all_Contact($conn);

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
    <?php if($contacts == 0){?>
                no Contacts
    <?php }else{?>
    <div class="table-title">Contacts</div>
    <table class="shadow">
        <thead>
        <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Email</th>
            <th>message</th>
        </tr> 
        </thead>
        <tbody>
        <?php 
        $i = 0;
        foreach ($contacts as $contact){
            $i++;
            ?>            
            <tr>
                <td><?=$i?></td>
                <td><?=$contact['user_name'];?></td>
                <td><?=$contact['email']?></td>
                <td ><?=$contact['message']?></td>
            </tr>
            <?php  }?>                
        </tbody>     
    </table>
    <?php  }?> 
</body>
</html>

<?php }

else{
    header("Location: login.php");
    exit;
}

?>