<?php

session_start();
echo"hello";
if(isset($_SESSION['user_id'])&&(isset($_SESSION['user_name']))){

    include "../db_conn.php";

    if(isset($_GET['id'])){

        //get information form post
        $id = $_GET['id'];
        
        if(empty($id)){
            $em = "There is no book to delete!";
            header("location: ../admin.php?error=$em&id=$id");
            exit;
        }else{
            #delete book from the database
            $sql      = "SELECT * FROM books WHERE id=?";
            $stmt     = $conn->prepare($sql);
            $stmt->execute([$id]);
            $the_book = $stmt->fetch();

            if($stmt->rowCount()>0){
                #delete book from the database
                $sql = "DELETE FROM books WHERE id=?";
                $stmt= $conn->prepare($sql);
                $res = $stmt->execute([$id]);

                if($res){
                    #delete the current file and cover from server
                    $cover = $the_book['cover'];
                    $file  = $the_book['file'];
                    $c_cover_path = "../uploads/cover/$cover";
                    $c_file_path  = "../uploads/files/$file";

                    unlink($c_cover_path);
                    unlink($c_file_path);

                    #succcess message
                    $sm = "The book is successfuly removed";
                    header("location: ../admin.php?success=$sm&id=$id");
                    exit;
                }else{
                    #error message
                    $em = "Unknown error occured";
                    header("location: ../admin.php?error=$em&id=$id");
                    exit;
                }
            }else{

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