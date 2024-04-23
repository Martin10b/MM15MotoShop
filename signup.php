<?php
  include_once "header1.php";
?>
<section class="p-5">
    <div class="container text-center">
        <h1 class="signUpTitle">Регистрирайте се</h1>
        <form id="reg-form" action="includes/signup.inc.php" method="POST" class="form w-75 w-lg-50 m-auto pt-4">          
                    <?php
                    //Name
                    if(isset($_GET['error']) && $_GET['error'] === 'invalidName') {
                        echo '<input type="name" class="form-control my-4 regInput error"  name="name" placeholder="Непозволени символи">';                        
                    } else if(isset($_GET["name"]) && !empty($_GET["name"])) {
                        echo '<input type="name" class="form-control my-4 regInput error"  name="name" placeholder="Име" value="' . $_GET["name"] . '">';
                    } else if(isset($_GET["name"])) {
                        echo '<input type="name" class="form-control my-4 regInput error"  name="name" placeholder="Име">';
                    } else {
                        echo '<input class="form-control my-4 regInput" type="name"  name="name" placeholder="Име">';
                    }

                    //Last Name
                    if(isset($_GET['error']) && $_GET['error'] === 'invalidName') {
                        echo '<input type="surname" class="form-control my-4 regInput error" name="surname" placeholder="Непозволени символи">';                        
                    } else if(isset($_GET["name"]) && !empty($_GET["name"])) {
                        echo '<input type="surname" class="form-control my-4 regInput error" name="surname" placeholder="Име" value="' . $_GET["name"] . '">';
                    } else if(isset($_GET["name"])) {
                        echo '<input type="surname" class="form-control my-4 regInput error" name="surname" placeholder="Име">';
                    } else {
                        echo '<input class="form-control my-4 regInput" type="surname" name="surname" placeholder="Фамилия">';
                    }

                    //Last Name
                    if(isset($_GET['error']) && $_GET['error'] === 'invalidUid') {
                        echo '<input type="text" class="form-control my-4 regInput error" name="uid" placeholder="Непозволени символи">';                        
                    } else if(isset($_GET["uid"]) && !empty($_GET["uid"])) {
                        echo '<input type="text" class="form-control my-4 regInput error" name="uid" placeholder="Потребителско име" value="' . $_GET["uid"] . '">';
                    } else if(isset($_GET["uid"])) {
                        echo '<input type="text" class="form-control my-4 regInput error" name="uid" placeholder="Потребителско име">';
                    } else {
                        echo '<input class="form-control my-4 regInput" type="text" name="uid" placeholder="Потребителско име">';
                    }

                    //Email
                    if(isset($_GET['error']) && $_GET['error'] === 'invalidEmail') {
                        echo '<input type="email" class="form-control my-4 regInput error" name="email" placeholder="Невалиден имейл">';
                    } else if(isset($_GET['error']) && $_GET['error'] === 'emailTaken') {
                        echo '<input type="email" class="form-control my-4 regInput error" name="email"  placeholder="Имейлът е зает">';
                    } else if(isset($_GET["email"]) && !empty($_GET["email"])) {
                        echo '<input type="email" class="form-control my-4 regInput error" name="email"  placeholder="Имейл" value="' . $_GET['email'] .  '">';
                    } else if(isset($_GET["email"])) {
                        echo '<input type="email" class="form-control my-4 regInput error" name="email"  placeholder="Имейл">';
                    } else {
                        echo '<input class="form-control my-4 regInput" type="email" name="email" placeholder="Имейл">';
                    }

                    //Phone
                    if(isset($_GET['error']) && $_GET['error'] === 'invalidPhone') {
                        echo '<input type="number" class="form-control my-4 regInput error" name="phone" placeholder="Невалиден телефонен номер">';
                    } else if(isset($_GET['error']) && $_GET['error'] === 'phoneTaken') {
                        echo '<input type="number" class="form-control my-4 regInput error" name="phone" placeholder="Телефонният номер е зает">';
                    } else if(isset($_GET["phone"]) && !empty($_GET["phone"])) {
                        echo '<input type="number" class="form-control my-4 regInput error" name="phone"  placeholder="Телефонен номер" value="' . $_GET['phone'] .  '">';
                    } else if(isset($_GET["phone"])) {
                        echo '<input type="number" class="form-control my-4 regInput error" name="phone"  placeholder="Телефонен номер">';
                    } else {
                        echo '<input class="form-control my-4 regInput" type="number" name="phone" placeholder="Телефон за връзка"> ';
                    }

                    //Password                    
                    if(isset($_GET['error']) && $_GET['error'] === 'passwordDontMatch') {
                        echo '<input type="password" class="form-control my-4 regInput error" name="pwd" placeholder="Паролите не съвпадат">';
                        echo '<input type="password" class="form-control my-4 regInput error" name="pwdrepeat" placeholder="Паролите не съвпадат">';
                    } else if(isset($_GET['error']) && $_GET['error'] === 'passwordLenght') {
                        echo '<input type="password" class="form-control my-4 regInput error" name="pwd" placeholder="Паролата е къса">';
                        echo '<input type="password" class="form-control my-4 regInput error" name="pwdrepeat" placeholder="Потвърди паролата">';
                    } else if(isset($_GET['error']) && $_GET['error'] === 'emptyInput') {
                        echo '<input type="password" class="form-control my-4 regInput error" name="pwd" placeholder="Парола">';
                        echo '<input type="password" class="form-control my-4 regInput error" name="pwdrepeat" placeholder="Потвърди паролата">';
                    } else {
                        echo '<input class="form-control my-4 regInput" type="password" name="pwd" placeholder="Парола">';
                        echo '<input class="form-control my-4 regInput" type="password" name="pwdrepeat" placeholder="Потвърди паролата">';
                    }
                    ?>
                
                <button class="btn submitBtn btn-lg px-sm-5" style=" font-size: 25px;" type="submit" name="submit">Регистриране</button>
        </form>
        <button class="btn" style="background-color: #ffc800; color: black; font-weight: bold;" onclick="window.location.href='login.php'">Вече имате профил?</button>
    </div>

</section>
<?php
  include_once "footer.php";
?>
