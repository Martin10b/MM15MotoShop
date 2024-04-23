<?php 
    session_start();
    include_once 'includes/dbh.inc.php'; 

    if(isset($_SESSION['userid'])) {
        // Проверка дали потребителят е администратор
        if(isset($_SESSION['userType']) && $_SESSION['userType'] == 1) {
            $isAdmin = true;
        } else {
            $isAdmin = false;
        }
        // Стайлинг на иконата на количката в зависимост от статуса на администратора
        $cartIconStyle = $isAdmin ? 'display: none;' : ''; // Скриване на иконата за администраторите
    } else {
        $cartIconStyle = 'display: none;'; // Скриване на иконата на количката за нелогнати потребители
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MM15 Moto Shop</title>
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .small-img-group{
            display: flex;
            justify-content: space-between;
        }
        .small-img-col{
            flex-basis: 24%;
            cursor: pointer;
        }
        .product select{
            display: block;
            padding: pointer;
        }
        .product input{
            width: 50px;
            height: 35px;
            padding-left: 10px;
            font-size: 16px;
            margin-right: 10px;
            border-radius: 4px;
            border-width: 1.5px;
        }
        .product input:focus{
            outline: none;
        }
        .buy-btnn{
            height: 35px;
            background-color: #ffc800;
            opacity: 1;
            transition: 0.3s all;
            border-radius: 4px;
            border-width: 1.5px;
            font-size: 20px;
            padding-left: 5px;
            padding-right: 5px;
        }
    </style>
</head>
<body class="showCart">
    <div class="top-navbar">
        <p><a class="navbar-brand" href="index.php" id="logo">MM15 <span id="span1">Moto</span> <span>Shop</span></a></p>
        <div class="icons">
            <?php                    
                if(isset($_SESSION['useruid'])) {
                    if(isset($_SESSION['userType']) && ($_SESSION['userType'] == 1)) {
                    ?>
                        <a href="addproduct.php"><img src="" alt="">Добавяне на продукт</a>
                    <?php
                    }                      
                    ?>
                        <a href="<?php isset($_POST['menuLinks']) ? $_POST['menuLinks'] : "";?>includes/logout.inc.php"><img src="" alt="">Излизане от профила</a>  
                    <?php
                } else {
                    ?>
                        <a href="login.php"><img src="" alt="">Влезте</a>
                        <a href="signup.php"><img src="" alt="">Регистрирайте се</a>                         
                    <?php
                }
            ?>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg" id="navbar">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span><img src="images/menu (1).png" alt="" width="26px"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Начална страница</a>
                    </li>
                    <li class="dropdown-submenu">
                        <a class="nav-link dropdown-toggle" tabindex="-1" href="#"id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Категории 
                        </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color: rgb(255, 111, 26);">
                                <li><a class="dropdown-item" href="gloves.php">Ръкавици</a></li>
                                <li><a class="dropdown-item" href="helmets.php">Каски</a></li>
                                <li><a class="dropdown-item" href="goggles.php">Очила</a></li>
                                <li><a class="dropdown-item" href="jerseys.php">Джърсита</a></li>
                                <li><a class="dropdown-item" href="pants.php">Бричове</a></li>
                                <li><a class="dropdown-item" href="equipment.php">Протектори</a></li>
                                <li><a class="dropdown-item" href="plasticKits.php">Комплекти пластмаси</a></li>
                                <li><a class="dropdown-item" href="guards.php">Гардове за мотор</a></li>
                                <li><a class="dropdown-item" href="parts.php">Части за мотор</a></li>
                            </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="aboutUs.php">За нас</a>
                    </li>
                </ul>

                <div class="iconCart" style="margin-left: 20px; margin-top: 8px; margin-right: 10px; <?php echo $cartIconStyle; ?>">
                    <a href="cart.php"><li class="fa-solid fa-cart-shopping" style="font-size: 25px; color: black;"></li></a>
                </div>
            </div>
        </div>
    </nav>

</body>
</html>
