<?php

session_start();

if(isset($_SESSION['user_id'])&&(isset($_SESSION['user_name']))){

    include "../db_conn.php";

    if(isset($_POST['category_id'])&&isset($_POST['category_name'])){

        //get information form post
        $name = $_POST['category_name'];
        $id = $_POST['category_id'];
        
        if(empty($name)){
            $em = "The category name is required";
            header("location: ../edit-category.php?error=$em&id=$id");
            exit;
        }else{
            #update the database
            $sql = "UPDATE category SET name=? WHERE id=?";
            $stmt= $conn->prepare($sql);
            $res = $stmt->execute([$name, $id]);

            if($res){
                #succcess message
                $sm = "The category is successfuly updated";
                header("location: ../edit-category.php?success=$sm&id=$id");
                exit;
            }else{
                #error message
                $em = "Unknown error occured";
                header("location: ../edit-category.php?error=$em&id=$id");
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