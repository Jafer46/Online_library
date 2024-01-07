<?php

#et all books function
function get_all_books($con){
    $sql = "SELECT * FROM books ORDER by id DESC";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        $books = $stmt->fetchAll();
    }else{
        $books = 0;
    }
    return $books;
}

function get_book($con, $id){
    $sql = "SELECT * FROM books WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    if($stmt->rowCount() > 0){
        $book = $stmt->fetch();
    }else{
        $book = 0;
    }
    return $book;
}

function search_books($con, $key){

    $key = "%{$key}%";

    $sql = "SELECT * FROM books WHERE title LIKE ? OR description LIKE ?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$key, $key]);

    if($stmt->rowCount() > 0){
        $book = $stmt->fetchAll();
    }else{
        $book = 0;
    }
    return $book;
}

function get_books_by_category($con, $id){
    $sql = "SELECT * FROM books WHERE category_id=? ORDER by id DESC  ";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    if($stmt->rowCount() > 0){
        $books = $stmt->fetchAll();
    }else{
        $books = 0;
    }
    return $books;
}
function get_all_bookmarked_books($con, $username){
    $sql = "SELECT * FROM books,bookmark WHERE user_name = ? AND id = book_id ORDER by id DESC  ";
    $stmt = $con->prepare($sql);
    $stmt->execute([$username]);

    if($stmt->rowCount() > 0){
        $books = $stmt->fetchAll();
    }else{
        $books = 0;
    }
    return $books;
}
?>