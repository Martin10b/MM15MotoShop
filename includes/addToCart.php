<?php
    session_start();
    
    if (isset($_GET['productId'])) {
        $productId = $_GET['productId'];
        $productSize = $_GET['productSize']; // Предполагаме, че размерът на продукта също се подава през GET
        print_r($_SESSION);
        // Инициализираме количката, ако тя не съществува
        if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
            $_SESSION["cart"] = [];
        }
    
        $cart = $_SESSION["cart"];
    
        // Проверяваме дали в количката вече има продукт с даден productId и productSize
        $found = false;
        foreach ($cart as $key => $item) {
            if ($item['id'] == $productId && $item['size'] == $productSize) {
                // Увеличаваме количеството на съществуващия продукт
                $_SESSION["cart"][$key]["count"] += 1;
                $found = true;
                break;
            }
        }
    
        // Ако не е намерен такъв продукт, добавяме го в количката
        if (!$found) {
            array_push($_SESSION["cart"], [
                'id' => $productId,
                'size' => $productSize,
                'count' => 1
            ]);
        }
    
        header("Location: ../cart.php");
    } else {
        // Ако не е предоставен productId, пренасочваме към страницата за количка с грешка
        header("Location: ../cart.php?error=NoProductId");
    }

    /*

    if(isset($_GET['productId'])) {
        if(isset($_SESSION["cart"]) || !empty($_SESSION["cart"])) { 
            $ids = array_column($_SESSION["cart"], 'id');
            if(($id = array_search($_GET['productId'], $ids)) !== FALSE) {                
                $_SESSION["cart"][$id]["count"] += 1;
            } else {
                array_push($_SESSION["cart"], array("id" => $_GET['productId'], "count" => 1));
            }
        } else {
            $_SESSION["cart"] = array();
            array_push($_SESSION["cart"], array("id" => $_GET['productId'], "count" => 1));
        }        
        header("Location: ../cart.php");
    } else {
        header("Location: ../cart.php?error=NoProductId");
    }
    */
?>

<?php
/*
    session_start();
    $productId = $_GET["productId"];
    $size = $_GET["size"];
    $count = $_GET["count"];
    if(isset($productId) && ($size != "Default" && $size != "NoSizeForThisProduct")) {
        if(isset($_SESSION["cart"]) || !empty($_SESSION["cart"])) {
            $ids = array_column($_SESSION["cart"], 'id');
            if(($id = array_search($productId, $ids)) !== FALSE) {
                if(($sizeId = array_search($size, array_column($_SESSION["cart"][$id], 'size'))) !== FALSE) {
                    $_SESSION["cart"][$id][$sizeId]["count"] += intval($count);
                } else {
                    array_push($_SESSION["cart"][$id], array("size" => $size, "count" => intval($count)));
                }
            } else {
                array_push($_SESSION["cart"][$id], array("id" => $productId, array("size" => $size, "count" => intval($count))));
            }
        } else {
            $_SESSION["cart"] = array();
            array_push($_SESSION["cart"], array("id" => $productId, array("size" => $size, "count" => intval($count))));
        }
        header("Location: ../cart.php");
    } else if(isset($productId) && $size == "NoSizeForThisProduct") {

    } else {
        header("Location: ../cart.php?error=NoProductId");
    }
    */