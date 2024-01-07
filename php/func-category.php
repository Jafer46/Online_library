<?php

#get all category function
function get_all_category($con){
    $sql = "SELECT * FROM category";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        $category = $stmt->fetchAll();
    }else{
        $category = 0;
    }
    return $category;
}
#get category by id

function get_category($con, $id){
    $sql = "SELECT * FROM category WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id]);

    if($stmt->rowCount() > 0){
        $category = $stmt->fetch();
    }else{
        $category = 0;
    }
    return $category;
}
?>