<?php
session_start();
require_once "dbh.inc.php";

if(isset($_SESSION['useruid'])) {
    if(isset($_SESSION['userType']) && ($_SESSION['userType'] == 1 && isset($_GET["productId"]))) {
        $sql = 'DELETE FROM products WHERE id = '.$_GET["productId"].'';
        mysqli_query($conn, $sql);
        header("Location: ../index.php");
    }
}