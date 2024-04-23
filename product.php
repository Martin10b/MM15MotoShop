<?php
include_once "header2.php";

if(isset($_GET["productId"])) {
  $productId = $_GET["productId"];

  $sql = "SELECT * from products WHERE id = ".$_GET['productId']."";
  $result = mysqli_query($conn, $sql);
  
  if($row = mysqli_fetch_assoc($result)) {
    echo ' <section class="container product my-5 pt-5">
    <div class="row mt-5">
    <div class="col-lg-5 col-md-12 col-12">';
    
    $image = "";
    if(explode(" ", $row["images"])[0] == "none") {
      $image = "none";
    } else {
      
      $sql2 = "SELECT * FROM images WHERE id IN (".implode(',', explode(" ",$row["images"])).")";
      $result2 = mysqli_query($conn, $sql2);
      
      if(mysqli_num_rows($result2) >= 1) {
        $images = array();
        while($row2 = mysqli_fetch_assoc($result2)) {
          array_push($images, $row2);
        }
        
        echo '<img class="img-fluid w-100 pb-1" src="includes/'.$images[0]['img_dir'].'" id="MainImg">';
        echo '<div class="small-img-group">';
        $counter = count($images);
        foreach($images as $postImage) {
          echo '<div class="small-img-col">
          <img src="includes/'.$postImage['img_dir'].'" width="100%" class="small-img" alt="">
          </div>';
        }
        
        while($counter < 3) {
          echo '<div class="small-img-col">
            <img src="" width="100%" class="small-img" alt="">
          </div>';
          $counter++;
        }
        echo '</div></div>';
        
      }
    }
    echo '<div class="col-lg-5 col-md-12 col-12"><h3 class="my-3">'.$row['productName'].'</h3><h2>'.$row['price'].' лв.</h2>';
    
    if($row["size"] != ".") {
      
      echo '<select class="my-3" name="productSize" onchange="changeTheSize(this)">
      <option>Изберете размер</option>';
      
      foreach(explode(" ", $row["size"]) as $option) {
        echo '<option>'.$option.'</option>';        
      }
      
      echo '</select>';
    } else {
      echo '<input style="display: none;" name="productSize" value="NoSize" />';
    }
    
    // Проверка за вкаран профил
    if(isset($_SESSION['userid'])) {
      // Проверка за администратор
      if(isset($_SESSION['userType']) && $_SESSION['userType'] == 1) {
          // Ако е администратор, не показвай бутона "Добави в количката"
          echo '<p style: background-color="lightblue;"><h3>Продуктът е наличен</h3></p>';
      } else {
          // Ако не е администратор, показвай бутона "Добави в количката"
          echo '<button class="buy-btnn"><a href="includes/addToCart.php?productId='.$row["id"].'&productSize=NoSize" id="kolichka"  style="border: none; color:black; text-decoration: none; font-weight: bold;">Добави в количката</a></button>';
      }
    } else {
      // Ако профилът не е вкаран, препращане към страницата за регистрация
      echo '<button class="buy-btnn"><a href="signup.php" style="border: none; color:black; text-decoration: none; font-weight: bold;">Регистрирайте се, за да поръчате</a></button>';
    }
    
    echo '<h4 class="mt-5  mb-1">Описание:</h4>
    <span><h5>'.$row["description"].'</h5></span>
</div>
</div>
</section>';
  }
  
}
include_once "footer.php";
?>

<script>
  function changeTheSize(e) {
    const linkElement = document.getElementById('kolichka');

    // Проверка дали елементът е намерен
    if (linkElement) {
        // Извличане на текущия href атрибут
        let hrefValue = linkElement.getAttribute('href');

        // Промяна на стойността на параметъра productSize
        const newProductSize = e.value; // Новата стойност на productSize, която искате да зададете

        // Заместване на текущата стойност на productSize с новата стойност
        hrefValue = hrefValue.replace(/(\bproductSize=)[^&]*/, '$1' + encodeURIComponent(newProductSize));

        // Задаване на новата стойност на href атрибута на елемента <a>
        linkElement.setAttribute('href', hrefValue);

        // Пример за извеждане на новия URL адрес в конзолата
        console.log('Нов URL адрес:', hrefValue);
    } else {
        console.log('Елементът <a> не е намерен.');
    }
  }
</script>
