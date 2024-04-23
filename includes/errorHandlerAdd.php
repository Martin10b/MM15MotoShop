<?php
    
    include_once 'dbh.inc.php';
    
    if(empty($CategoryID) || empty($productName) || empty($price) || empty($size) || empty($description)) {
        header("Location: ../addPost.php?error=empty&name=$productName&description=$description&price=$price");
        exit();
    }
    

?>