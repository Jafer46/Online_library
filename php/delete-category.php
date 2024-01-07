<?php

session_start();
echo"hello";
if(isset($_SESSION['user_id'])&&(isset($_SESSION['user_name']))){

    include "../db_conn.php";

    if(isset($_GET['id'])){

        //get information form post
        $id = $_GET['id'];
        
        if(empty($id)){
            $em = "There is no category to delete!";
            header("location: ../admin.php?error=$em&id=$id");
            exit;
        }else{
                #delete book from the database
                $sql = "DELETE FROM category WHERE id=?";
                $stmt= $conn->prepare($sql);
                $res = $stmt->execute([$id]);

                if($res){
                    
                    #succcess message
                    $sm = "The category is successfuly removed";
                    header("location: ../admin.php?success=$sm&id=$id");
                    exit;
                }else{
                    #error message
                    $em = "Unknown error occured";
                    header("location: ../admin.php?error=$em&id=$id");
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