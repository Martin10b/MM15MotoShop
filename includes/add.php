<?php
    session_start();
    include_once 'dbh.inc.php';
    
    if(!isset($_POST["submit"])) {
        header("Location: ../addPost.php?error=post");
    } else {        
        $ID = $_SESSION['userid'];           
        $CategoryID = $_POST['ID'];
        $productName = $_POST['productName'];
        $price = $_POST['price'];

        $size = $_POST['size'];
        $description = $_POST['description'];
        
            
        include "errorHandlerAdd.php";
        include 'upload.php';
        
        if(empty($imgId)) {
            $imgIds = "none";
        } else {
            $imgIds = implode(" ", $imgId);
        }        
    
        $sql = "INSERT IGNORE INTO products (category, productName, price, size, description, images) VALUES(?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL statement failed";
        } else {         
            mysqli_stmt_bind_param($stmt, "ssssss", $CategoryID, $productName, $price, $size, $description, $imgIds);           
            mysqli_stmt_execute($stmt);           
        }

        header("Location: ../addproduct.php?error=success");
        
    }
?>