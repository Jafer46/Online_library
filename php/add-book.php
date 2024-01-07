<?php
session_start();

if(isset($_SESSION['user_id'])&&(isset($_SESSION['user_name']))){
    //database connection
    include "../db_conn.php";
    
    //simple validation helper function
    include "func-validation.php";

    //file upload helper function
    include "func-file-upload.php";

    if(isset($_POST['btitle'])&&isset($_POST['bauthor'])&&isset($_POST['bdescription'])&&isset($_POST['bcategory'])&&isset($_FILES['bcover'])&&isset($_FILES['bfile'])){

         //get information form post
        $btitle       = $_POST['btitle'];
        $bauthor      = $_POST['bauthor'];
        $bdescription = $_POST['bdescription'];
        $bcategory    = $_POST['bcategory'];
        
        //making data format
        $user_input = 'title='.$btitle.'&category='.$bcategory.'&desc='.$bdescription;
        //simple validation
        $text     = "Book Title";
        $location = "../add-book.php";
        $ms       = "error";
        is_empty($btitle, $text, $location, $ms, $user_input);

        $text     = "Book Author";
        is_empty($bauthor, $text, $location, $ms, $user_input);

        $text     = "Book description";
        is_empty($bdescription, $text, $location, $ms, $user_input);

        $text     = "Book category";
        is_empty($bcategory, $text, $location, $ms, $user_input);

        #book cover uploader
        $allowed_image_exs = array("jpg", "jpeg", "png");
        $path = "cover";
        $book_cover  = upload_file($_FILES['bcover'], $allowed_image_exs, $path);

        if($book_cover['status'] == "error"){
            $em = $book_cover['data'];

            header("location: ../add-book.php?error=$em&$user_input");
            exit;
        }

        $allowed_file_exs = array("pdf", "docx", "pptx");
        $path = "files";
        $file  = upload_file($_FILES['bfile'], $allowed_file_exs, $path);

        if($file['status'] == "error"){
            $em = $file['data'];

            header("location: ../add-book.php?error=$em&$user_input");
            exit;
        }

        $file_URL = $file['data'];
        $book_cover_URL = $book_cover['data'];

        $sql = "INSERT INTO books(title, author, description, category_id, cover, file) VALUES (?,?,?,?,?,?)";
        $stmt= $conn->prepare($sql);
            $res = $stmt->execute([$btitle, $bauthor, $bdescription, $bcategory, $book_cover_URL, $file_URL]);

            if($res){
                #succcess message
                $sm = "The book is successfuly added";
                header("location: ../add-book.php?success=$sm");
                exit;
            }else{
                #error message
                $em = "Unknown error occured";
                header("location: ../add-book.php?error=$em");
                exit;
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