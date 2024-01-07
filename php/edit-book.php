<?php

session_start();

echo "hello";

if(isset($_SESSION['user_id'])&&(isset($_SESSION['user_name']))){

    include "../db_conn.php";

    //simple validation helper function
    include "func-validation.php";

    //file upload helper function
    include "func-file-upload.php";

    if(isset($_POST['bid'])&&isset($_POST['btitle'])&&isset($_POST['bauthor'])&&isset($_POST['bdescription'])&&isset($_POST['bcategory'])&&isset($_FILES['bcover'])&&isset($_FILES['bfile'])&&isset($_POST['current_cover'])&&isset($_POST['current_file'])){

         //get information form post
        $bid          = $_POST['bid'];
        $btitle       = $_POST['btitle'];
        $bauthor      = $_POST['bauthor'];
        $bdescription = $_POST['bdescription'];
        $bcategory    = $_POST['bcategory'];

         //get current cover and file

        $current_cover = $_POST['current_cover'];
        $current_file = $_POST['current_file'];

         //simple validation
        $text     = "Book Title";
        $location = "../edit-book.php";
        $ms       = "id=$bid&error";
        is_empty($btitle, $text, $location, $ms, $user_input);

        $text     = "Book Author";
        is_empty($bauthor, $text, $location, $ms, $user_input);

        $text     = "Book description";
        is_empty($bdescription, $text, $location, $ms, $user_input);

        $text     = "Book category";
        is_empty($bcategory, $text, $location, $ms, $user_input);
        

        if(!empty($_FILES['bcover']['name'])){

            if(!empty($_FILES['bfile']['name'])){
                #update both cover and file

                $allowed_image_exs = array("jpg", "jpeg", "png");
                $path = "cover";
                $book_cover  = upload_file($_FILES['bcover'], $allowed_image_exs, $path);

                $allowed_file_exs = array("pdf", "docx", "pptx");
                $path = "files";
                $file  = upload_file($_FILES['bfile'], $allowed_file_exs, $path);  
                
                if($book_cover['status'] == "error"|| $file['status'] == "error"){
                    $em = $book_cover['data'];
        
                    header("location: ../edit-book.php?error=$em&id=$bid");
                    exit;
                }
                #current book cover path
                $c_p_book_cover = "../uploads/cover/$current_cover";

                #current book file path
                $c_p_file = "../uploads/files/$current_file";
                
                #delete from server
                unlink($c_p_book_cover);
                unlink($c_p_file);

                $file_URL = $file['data'];
                $book_cover_URL = $book_cover['data'];
                
                #update the db with new fields
                $sql = "UPDATE books SET title=?,
                                     author=?,
                                     description=?,
                                     category_id=?,
                                     cover=?,
                                     file=?
                                     WHERE id=?";
                $stmt= $conn->prepare($sql);
                $res = $stmt->execute([$btitle, $bauthor, $bdescription, $bcategory,$book_cover_URL,$file_URL,$bid]);
                if($res){
                    #succcess message
                    $sm = "The book is successfuly updated";
                    header("location: ../edit-book.php?success=$sm&id=$bid");
                    exit;
                }else{
                    #error message
                    $em = "Unknown error occured";
                    header("location: ../add-book.php?error=$em&id=$bid");
                    exit;
                }

            }else{
                #update cover only
                $allowed_image_exs = array("jpg", "jpeg", "png");
                $path = "cover";
                $book_cover  = upload_file($_FILES['bcover'], $allowed_image_exs, $path);
 
                
                if($book_cover['status'] == "error"){
                    $em = $book_cover['data'];
        
                    header("location: ../edit-book.php?error=$em&id=$bid");
                    exit;
                }
                #current book cover path
                $c_p_book_cover = "../uploads/cover/$current_cover";

                #current book file path
                $c_p_file = "../uploads/files/$current_file";
                
                #delete from server
                unlink($c_p_book_cover);

                $book_cover_URL = $book_cover['data'];
                
                #update the db with new fields
                $sql = "UPDATE books SET title=?,
                                     author=?,
                                     description=?,
                                     category_id=?,
                                     cover=?
                                     WHERE id=?";
                $stmt= $conn->prepare($sql);
                $res = $stmt->execute([$btitle, $bauthor, $bdescription, $bcategory,$book_cover_URL,$bid]);
                if($res){
                    #succcess message
                    $sm = "The book is successfuly updated";
                    header("location: ../edit-book.php?success=$sm&id=$bid");
                    exit;
                }else{
                    #error message
                    $em = "Unknown error occured";
                    header("location: ../add-book.php?error=$em&id=$bid");
                    exit;
                }


            }

        }

        elseif(!empty($_FILES['bfile']['name'])&&empty($_FILES['bcover']['name'])){

                $allowed_file_exs = array("pdf", "docx", "pptx");
                $path = "files";
                $file  = upload_file($_FILES['bfile'], $allowed_file_exs, $path);  
                
                if($file['status'] == "error"){
                    $em = $file['data'];        
                    header("location: ../edit-book.php?error=$em&id=$bid");
                    exit;
                }

                #current book file path
                $c_p_file = "../uploads/files/$current_file";
                
                #delete from server
                unlink($c_p_file);

                $file_URL = $file['data'];
                
                #update the db with new fields
                $sql = "UPDATE books SET title=?,
                                     author=?,
                                     description=?,
                                     category_id=?,
                                     file=?
                                     WHERE id=?";
                $stmt= $conn->prepare($sql);
                $res = $stmt->execute([$btitle, $bauthor, $bdescription, $bcategory,$file_URL,$bid]);
                if($res){
                    #succcess message
                    $sm = "The book is successfuly updated";
                    header("location: ../edit-book.php?success=$sm&id=$bid");
                    exit;
                }else{
                    #error message
                    $em = "Unknown error occured";
                    header("location: ../add-book.php?error=$em&id=$bid");
                    exit;
                }

        }else{

            $sql = "UPDATE books SET title=?,
                                     author=?,
                                     description=?,category_id=?
                                     WHERE id=?";
            $stmt= $conn->prepare($sql);
            $res = $stmt->execute([$btitle, $bauthor, $bdescription, $bcategory,$bid]);
            if($res){
                #succcess message
                $sm = "The book is successfuly updated";
                header("location: ../edit-book.php?success=$sm&id=$bid");
                exit;
            }else{
                #error message
                $em = "Unknown error occured";
                header("location: ../add-book.php?error=$em&id=$bid");
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