<?php
session_start();

if(isset($_SESSION['user_id'])&&(isset($_SESSION['user_name']))){

    include "../db_conn.php";
    include "func-validation.php";

    if(isset($_POST['email'])&&isset($_POST['message'])){

        //get information form post
        $user_name = $_SESSION['user_name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        
        $text = "eamil adress";
        $location = "../contact.php";
        $ms = "error";
        is_empty($email, $text, $location, $ms, "");

        $text = "message";
        is_empty($message, $text, $location, $ms, "");
        
        
            #insert into the database
            $sql = "INSERT INTO contact (user_name, email, message) VALUES (?,?,?)";
            $stmt= $conn->prepare($sql);
            $res = $stmt->execute([$user_name, $email,$message]);

            if($res){
                #succcess message
                $sm = "The message is successfully send";
                header("location: ../contact.php?success=$sm");
                exit;
            }else{
                #error message
                $em = "Unknown error occured";
                header("location: ../contact.php?error=$em");
                exit;
            }
    }else{
        header("location: ../contact.php");
        exit;
    }

}
else{
    header("location: ../login.php");
    exit;
}
?>