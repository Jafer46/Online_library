<?php
session_start();

if(isset($_SESSION['user_id'])&&(isset($_SESSION['user_name']))){

    include "../db_conn.php";

    if(isset($_GET['id'])){

        //get information form post
        $book_id = $_GET['id'];
        
        $sql = "DELETE FROM bookmark WHERE book_id=?";
        $stmt= $conn->prepare($sql);
        $res = $stmt->execute([$book_id]);       

            if($res){
                #succcess message
                $sm = "The book is successfully unmarked";
                header("location: ../bookmark.php?success=$sm");
                exit;
            }else{
                #error message
                $em = "Unknown error occured";
                header("location: ../bookmark.php?error=$em");
                exit;
            }
    }else{
        header("location: ../user.php");
        exit;
    }

}
else{
    header("location: ../login.php");
    exit;
}
?>