<?php
session_start();

if(isset($_SESSION['user_id'])&&(isset($_SESSION['user_name']))){

    include "../db_conn.php";

    if(isset($_GET['id'])){

        //get information form post
        $book_id = $_GET['id'];
        $username = $_SESSION['user_name'];
        
        $sql = "SELECT * FROM bookmark WHERE user_name=? AND book_id=?";
        $stmt= $conn->prepare($sql);
        $stmt->execute([$username, $book_id]);

        if($stmt->rowCount() > 0){
            $em = "The book is already bookmarked";
            header("location: ../user.php?error=$em");
            exit;
        }else{
            $sql = "INSERT INTO bookmark(user_name, book_id) VALUES (?,?)";
            $stmt = $conn->prepare($sql);
            $res = $stmt->execute([$username, $book_id]);

            if($res){
                #succcess message
                $sm = "The is successfully book marked";
                header("location: ../user.php?success=$sm");
                exit;
            }else{
                #error message
                $em = "Unknown error occured";
                header("location: ../user.php?error=$em");
                exit;
            }
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