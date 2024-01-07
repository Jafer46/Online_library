<?php
session_start();

if(isset($_SESSION['user_id'])&&(isset($_SESSION['user_name']))){

    include "../db_conn.php";

    if(isset($_POST['category'])){

        //get information form post
        $name = $_POST['category'];
        
        if(empty($name)){
            $em = "The category name is required";
            header("location: ../add-category.php?error=$em");
            exit;
        }else{
            #insert into the database
            $sql = "INSERT INTO category (name) VALUES (?)";
            $stmt= $conn->prepare($sql);
            $res = $stmt->execute([$name]);

            if($res){
                #succcess message
                $sm = "The category is successfuly added";
                header("location: ../add-category.php?success=$sm");
                exit;
            }else{
                #error message
                $em = "Unknown error occured";
                header("location: ../add-category.php?error=$em");
                exit;
            }
        }
    }else{
        header("location: ../admin.php");
        exit;
    }

}
else{
    header("location: ../login.php");
    exit;
}
?>