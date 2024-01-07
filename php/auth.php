<?php

session_start();

if(isset($_POST['username'])&&isset($_POST['password'])){
    include "../db_conn.php";
    include "func-validation.php";

    
    $username = $_POST['username'];
    $password = $_POST['password'];
    

    $text = "username";
    $location = "../login.php";
    $ms = "error";
    is_empty($username, $text, $location, $ms, "");

    $text = "password";
    $location = "../login.php";
    $ms = "error";
    is_empty($password, $text, $location, $ms, "");
    #search for user name

    $sql = "SELECT * FROM admin where user_name=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);

    #if user name exist
    if($stmt->rowcount() === 1){
        $user = $stmt->fetch();

        $check_user_id = $user['id'];
        $check_user_name = $user['User_Name'];
        $check_user_password = $user['Password'];        
        
        if(password_verify($password, $check_user_password)){
             $_SESSION['user_id'] = $check_user_id;
             $_SESSION['user_name'] = $check_user_name;
             header("Location: ../admin.php");                
        }        
    }else{
        $sql = "SELECT * FROM user where user_name=?";
    
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);

        #if user name exist
        if($stmt->rowcount() === 1){
            $user = $stmt->fetch();

            $check_user_id = $user['id'];
            $check_user_name = $user['User_Name'];
            $check_user_password = $user['Password'];        
        
            if(password_verify($password, $check_user_password)){
                $_SESSION['user_id'] = $check_user_id;
                $_SESSION['user_name'] = $check_user_name;
                header("Location: ../user.php");                
            }else{
                $em = "Incorrect User name or password!";
                header("location: ../login.php?error=$em");
            }
        
        }else{
            $em = "Incorrect User name or password!";
            header("location: ../login.php?error=$em");
        }
    }

}
else{
    header("Location: ../login.php");
}


?>