<?php

session_start();

if(isset($_POST['username'])&&isset($_POST['password'])){
    include "../db_conn.php";
    include "func-validation.php";

    $fname    = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    

    $text = "Full name";
    $location = "../signin.php";
    $ms = "error";
    is_empty($fname, $text, $location, $ms, "");

    $text = "username";
    is_empty($username, $text, $location, $ms, "");

    $text = "password";
    is_empty($password, $text, $location, $ms, "");
    #search for user name

    $sql = "SELECT * FROM admin where user_name=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);

    #if user name exist
    if($stmt->rowcount() > 0){
        $em = "User name already exists";
        header("location: ../signin.php?error=$em");   
    }else{
        $sql = "SELECT * FROM user where user_name=?";
    
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);

        #if user name exist
        if($stmt->rowcount() > 0){
            $em = "User name already exists";
            header("location: ../signin.php?error=$em");        
        }else{
            $hpassword = password_hash($password,PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (Full_Name, User_Name, password) VALUES (?,?,?)";
    
            $stmt = $conn->prepare($sql);
            $res  = $stmt->execute([$fname, $username, $hpassword]);

            if($res){
                #succcess message
                header("location: ../user.php");
                exit;
            }else{
                #error message
                $em = "Unknown error occured";
                header("location: ../signin.php?error=$em");
                exit;
            }
        }
    }

}
else{
    header("Location: ../signin.php");
}


?>