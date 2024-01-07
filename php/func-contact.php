<?php
function get_all_Contact($con){
    $sql = "SELECT * FROM contact ORDER by id DESC";
    $stmt = $con->prepare($sql);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        $contacts = $stmt->fetchAll();
    }else{
        $contacts = 0;
    }
    return $contacts;
}
?>