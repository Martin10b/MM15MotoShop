<?php
    session_start();
    include "dbh.inc.php";
    
    if(isset($_GET['productId'])) {
        if(isset($_SESSION["cart"])) {            
            $ID;
            $ids = array_column($_SESSION["cart"], 'id');
            if(($id = array_search($_GET['productId'], $ids)) !== FALSE) {                
                $ID = $id;
            }
            
            $array = array();
            for($i = 0; $i < count($_SESSION["cart"]); $i++){
                if($_SESSION["cart"][$ID] != $_SESSION["cart"][$i]) {
                    $array = [...$array, $_SESSION["cart"][$i]];
                }
            }
            $_SESSION["cart"] = $array;            
        }        
        header("Location: cart.php");
    } else {
        header("Location: cart.php?error=NoProductId");
    }
?>  