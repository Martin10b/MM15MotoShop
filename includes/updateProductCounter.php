<?php

    session_start();
    include "dbh.inc.php"; // Включете файла с връзката към базата данни

    // Проверка дали сесията на количката съществува и не е празна
    if (isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
        // Проверка дали са предоставени параметрите id и counter чрез GET и counter е поне 1
        if (isset($_GET["id"]) && isset($_GET["counter"]) && $_GET["counter"] >= 1) {
            // Откриване на продукта в количката по id и обновяване на количеството (counter)
            foreach ($_SESSION["cart"] as &$item) {
                if ($item['id'] === $_GET["id"]) {
                    $item['count'] = $_GET["counter"];
                    break;
                }
            }
        }

        $sum = 0;

        // Изчисляване на общата сума за продуктите в количката
        foreach ($_SESSION["cart"] as $cartItem) {
            $productId = $cartItem['id'];
            $productCount = $cartItem['count'];

            // Заявка към базата данни за извличане на информация за продукта
            $sql = "SELECT * FROM products WHERE id = $productId";
            $result = mysqli_query($conn, $sql);

            // Проверка за успешно извличане на резултата от заявката
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $productPrice = $row["price"];

                // Изчисляване на общата цена за дадения продукт (цена * количество)
                $sum += $productPrice * $productCount;
            }
        }

        // Извеждане на общата сума
        echo 'Обща сума: ' . $sum . ' лв.';
    }


    /*
    session_start();
    include "dbh.inc.php";

    if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"])) {
        if(isset($_GET["id"]) && isset($_GET["counter"]) && $_GET["counter"] >= 1) {
            foreach ($_SESSION["cart"] as &$item) {
                if ($item['id'] === $_GET["id"]) {
                    if($_GET["counter"] >= 1) {
                        $item['count'] = $_GET["counter"];
                    }
                    break;
                }
            }
        }

        $sum = 0;
        for($i = 0; $i < count($_SESSION["cart"]); $i++) {                  
            $sql = "SELECT * FROM products WHERE id = ".$_SESSION['cart'][$i]['id']."";
        
            $result = mysqli_query($conn, $sql);
        
            if(mysqli_num_rows($result) > 0) {
                if($row = mysqli_fetch_assoc($result)) {
                    $sum += $row["price"] * $_SESSION['cart'][$i]["count"];
                }
            }
        }
        echo 'Обща сума:'. $sum. 'лв.';
    }
    */