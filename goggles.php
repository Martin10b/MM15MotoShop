<?php 
include_once "header.php";
?>

            <section class="home">
            <div class="content">
              <h1>
                <br>
                <p>Ние Имаме Всичко,</p><p> <span id="span2">От Което Се Нуждае <p> </span>Вашият Мотор</p></p>
            </h1>
          </div>
          
        </section>
        
        <div class="container" id="product-cards">
            <h1 class="text-center">Очила</h1>
            <div class="row" style="margin-top: 30px;">
            <?php
            $sql = "SELECT * FROM products WHERE category=4";
        
            $result = mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($result)) {
              $image = "";
              if(explode(" ", $row["images"])[0] == "none") {
                $image = "none";
              } else {
                $sql2 = "SELECT * FROM images WHERE id = ".explode(" ",$row["images"])[0]."";
                $result2 = mysqli_query($conn, $sql2);
                
                if($row2 = mysqli_fetch_assoc($result2)) {
                  $image = $row2['img_dir'];
                }
              }

              echo '<div class="col-md-3 py-3 py-md-0 my-3" style="margin-bottom: 30px;">
              <div class="card h-100">
                <a href="product.php?productId='.$row['id'].'"><img class="image" src="includes/'.$image.'" alt=""></a>
                <div class="card-body d-flex flex-column justify-content-end">
                  <h3 class="text-center">'.$row['productName'].'</h3>
                  <!-- <p class="text-center">Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p> -->
                  <div class="star">
                    <i class="fa-solid fa-star checked"></i>
                    <i class="fa-solid fa-star checked" ></i>
                    <i class="fa-solid fa-star checked" ></i>
                    <i class="fa-solid fa-star checked" ></i>
                    <i class="fa-solid fa-star checked" ></i>
                  </div>';
                  if(isset($_SESSION['useruid']) && isset($_SESSION['userType']) && ($_SESSION['userType'] == 1)) {                    
                    echo '<h2 class="price">'.$row['price'].' лв. </h2><button onclick="deleteProduct('.$row["id"].');" style="background-color: red; color: white; border-radius: 10px;">Delete</button>';
                  } else {
                    echo '<h2 class="price">'.$row['price'].' лв. </h2>';
                  }
                  echo '
                </div>
              </div>
            </div>';
            }
            ?>
          </div>
        </div>
        
    <div class="container" id="offer">
      <div class="row">
        <div class="col-md-3 py-3 py-md-0 my-3">
          <i class="fa-solid fa-cart-shopping">
            <h3>Безплатна Доставка</h3>
            <p>На Поръчка Над 550 лв.</p>
          </i>
        </div>
        <div class="col-md-3 py-3 py-md-0 my-3">
          <i class="fa-solid fa-rotate-left">
            <h3>Безплатно Връщане</h3>
            <p>До 30 Дни</p>
          </i>
        </div>
        <div class="col-md-3 py-3 py-md-0 my-3">
          <i class="fa-solid fa-truck">
            <h3>Бърза Доставка</h3>
            <p>По Цял Свят</p>
          </i>
        </div>
        <div class="col-md-3 py-3 py-md-0 my-3">
          <i class="fa-solid fa-thumbs-up">
            <h3>Голямо Разнообразие</h3>
            <p>От Продукти</p>
          </i>
        </div>
      </div>
    </div>
    <script>
      function deleteProduct(id) {
        if(confirm("Наистина ли искате да изтриете продукта?")) {
          window.location.href = `includes/deleteProduct.php?productId=${id}`;
        }
      }
    </script>

    <?php
    include_once "footer.php";
    ?>