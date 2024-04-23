<?php
include "includes/dbh.inc.php";

$_POST['menuLinks'] = "";
include ''.$_POST['menuLinks'].'header1.php';

$sum = 0;

function processOrderAndClearCart($conn, $phone, $email, $paymentMethod) {
  $sum = 0;

  if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
      $products = '';

      foreach ($_SESSION['cart'] as $item) {
          $productId = $item['id'];
          $count = $item['count'];
          $productSize = $item['size'];

          // Заявка за извличане на информация за продукта
          $sql = "SELECT price, size, productName FROM products WHERE id = $productId";
          $result = mysqli_query($conn, $sql);

          if ($result && mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_assoc($result);
              $productPrice = $row['price'];
              $productName = $row['productName'];

              $totalPrice = $productPrice * $count;
              $sum += $totalPrice;

              // Добавяне на информация за продукта към поръчката
              $products .= "Продукт: $productName, Брой: $count, Размер: $productSize;\n";
          }
      }
      // Вмъкване на поръчката в базата данни в зависимост от метода на плащане
      $date = date('D-m-y H:i:s');
      $products = mysqli_real_escape_string($conn, $products);

      if ($paymentMethod == 'cash_on_delivery') {
          $sql = "INSERT INTO orders (products, total_price, phone, email, created_at) VALUES ('$products', $sum, '$phone', '$email', '$date')";
      } else if ($paymentMethod == 'card_payment') {
          $sql = "INSERT INTO orderwithcard (products, total_price, email, created_at) VALUES ('$products', $sum, '$email', '$date')";
      }

      if (mysqli_query($conn, $sql)) {
          unset($_SESSION['cart']); // Изчистване на количката след успешна поръчка
      } else {
          echo "Възникна грешка при запазване на поръчката.";
      }
  }
}

// Проверка за изпратената форма за плащане
if (isset($_POST['pay'])) {
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $paymentMethod = $_POST['payment_method'];
  processOrderAndClearCart($conn, $phone, $email, $paymentMethod);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
  /* Стилове за формата */
form {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #f9f9f9;
}

/* Стилове за полетата за въвеждане */
input[type="text"],
input[type="email"],
input[type="password"],
select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 4px;
}

/* Стилове за бутона за потвърждение */
button[type="submit"] {
  background-color: #4CAF50;
  color: white;
  padding: 15px 32px;
  text-align: center;
  display: inline-block;
  font-size: 16px;
  margin-top: 20px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition-duration: 0.4s;
}

button[type="submit"]:hover {
  background-color: #46a049;
}
.empty-cart-message {
  text-align: center;
  vertical-align: middle; 
  font-size: 40px; 
} 
</style>
</head>
<body>

<section class="section">
  <div class="container">
    <table class="cart">
      <tr class="cart-header">
        <th>Име на продукта</th>
        <th>Снимка на продукта</th>
        <th>Цена</th>
        <th>Размер</th>
        <th>Количество</th>
        <th>Премахни от кошницата</th>
      </tr>
      
      <?php
      if(isset($_SESSION['cart']) && !empty($_SESSION["cart"])) {
        foreach($_SESSION["cart"] as $item) {                   
          $productId = $item["id"];
          $count = $item["count"];
          $productSize = $item["size"];
          //echo $productId;
          $sql = "SELECT * FROM products WHERE id = $productId";
          $result = mysqli_query($conn, $sql);
          if(mysqli_num_rows($result) > 0) {
            if($row = mysqli_fetch_assoc($result)) {
              //print_r($row["images"]);
              $sql2 = "SELECT * FROM images WHERE id = ".explode(" ", $row["images"])[0]."";
              $image;
              if($row["images"] != "none") {
                $result2 = mysqli_query($conn, $sql2);
                if($row2 = mysqli_fetch_assoc($result2)) {
                  $image = $row2["img_dir"];
                }
              } else {
                $image = "none";
              }
              //$productSize = $row["size"]; // Извличане на размера на продукта
              echo '<tr class="cart-item">
                      <td>'.$row["productName"].'</td>
                      <td><img src="includes/'.$image.'" alt="'.$row["productName"].'" /></td>
                      <td>'.$row["price"].' лв.</td>';

              if($productSize == "NoSize") {
                echo '<td>Продуктът няма размер</td> <!-- Извеждане на размера на продукта -->';
              } else {
                echo '<td>'.$productSize.'</td> <!-- Извеждане на размера на продукта -->';
              }

              echo '<td><input class="cart_count" type="number" min="1" value="'.$count.'" onchange="updateCounter('.$productId.', this)"/></td>
                      <td><a href="deleteFromCart.php?productId='.$productId.' " style="color: red; text-decoration: none; font-weight: bold;">Delete</a></td>
                    </tr>';
              $sum += $row["price"] * $count;
            }
          }
        }
      } else {
        echo "<tr><td colspan='6' class='empty-cart-message'>Количката е празна</td></tr>";
      }
      ?>  
    </table>
  </div>
</section>

<section class="section">
  <div class="container">
    <?php echo"<h1 id='sum' class='cart-total'>Обща сума:".$sum." лв.</h1>"; ?>
    <form action="" method="POST" onsubmit="return confirm('Потвърдете поръчката си')">
  <label for="payment_method">Изберете метод на плащане:</label>
  <select name="payment_method" id="payment_method" onchange="selectPaymentMethod()">
    <option class="dropdown-item" value="cash_on_delivery" selected>Плащане с наложен платеж</option>
    <option class="dropdown-item" value="card_payment">Плащане с карта</option>
  </select>
  <div id="cash_on_delivery_fields">
    <label for="phone">Телефон за връзка:</label>
    <input type="text" name="phone" id="phone" placeholder="Телефон за връзка">
    <label for="email">Имейл:</label>
    <input type="email" name="email" id="email" placeholder="Имейл">
  </div>
  <div id="card_payment_fields" style="display:none;">
    <label for="paypal_email">Имейл за PayPal:</label>
    <input type="email" name="email" id="paypal_email" placeholder="Имейл за PayPal">
    <label for="paypal_password">Парола за PayPal:</label>
    <input type="password" name="paypal_password" id="paypal_password" placeholder="Парола за PayPal">
  </div>
  <button style="display: flex; justify-content: center; align-items: center;" type="submit" name="pay">Потвърди поръчката</button>
</form>

<script>
  function selectPaymentMethod() {
    var paymentMethod = document.getElementById("payment_method").value;
    if (paymentMethod === 'cash_on_delivery') {
      document.getElementById("cash_on_delivery_fields").style.display = "block";
      document.getElementById("card_payment_fields").style.display = "none";
    } else if (paymentMethod === 'card_payment') {
      document.getElementById("cash_on_delivery_fields").style.display = "none";
      document.getElementById("card_payment_fields").style.display = "block";
    }
  }
</script>
  </div>
</section>

<?php
include ''.$_POST['menuLinks'].'footer.php';
?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
  function updateCounter(id, element) {
    $.ajax({
      url: "includes/updateProductCounter.php",
      type: "GET",
      data:  {
        "id": id,
        "counter": element.value,
      },    
      success: function(data){            
        document.getElementById("sum").innerHTML = data;
        console.log(data);
      },
      error: function() 
      {}       
    });
  }

  function showPaymentFields() {
    var paymentMethod = document.getElementById("payment_method").value;
    if (paymentMethod == "cash_on_delivery") {
      document.getElementById("cash_on_delivery_fields").style.display = "block";
      document.getElementById("card_payment_fields").style.display = "none";
    } else if (paymentMethod == "card_payment") {
      document.getElementById("cash_on_delivery_fields").style.display = "none";
      document.getElementById("card_payment_fields").style.display = "block";
    }
  }
</script>

</body>
</html>
