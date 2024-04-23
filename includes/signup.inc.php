<?php

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $username = $_POST['uid'];
    $phone = $_POST['phone'];
    $pwd = $_POST['pwd'];
    $pwdRepeat = $_POST['pwdrepeat'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputSignup($name, $surname, $email, $username, $phone, $pwd, $pwdRepeat) !== false) {
        header("Location: ../signup.php?error=emptyInput" . PassInformation($name, $surname, $email, $username, $phone));
        exit();
    }

    if(invalidUid($name) !== false) {
        header("Location: ../signup.php?error=invalidName&surname=$surname&email=$email&username=$username&phone=$phone");
        exit();
    }

    if(invalidUid($surname) !== false) {
        header("Location: ../signup.php?error=invalidUid&name=$name&email=$email&phone=$phone");
        exit();
    }

    if(invalidUid($username) !== false) {
        header("Location: ../signup.php?error=invalidUid&name=$name&surname=$surname&email=$email&phone=$phone");
        exit();
    }

    if(invalidEmail($email) !== false) {
        header("Location: ../signup.php?error=invalidEmail&name=$name&surname=$surname&username=$username&phone=$phone");
        exit();
    }
    
    if(invalidPhone($phone) !== false) {
        header("Location: ../signup.php?error=invalidPhone&name=$name&surname=$surname&email=$email&username=$username");
        exit();
    }

    if(phoneExist($conn, $phone) === true) {
        header("Location: ../signup.php?error=phoneTaken&name=$name&surname=$surname&email=$email&username=$username");
        exit();
    }

    if(pwdChar($pwd) !== false) {
        header("Location: ../signup.php?error=passwordLenght" . PassInformation($name, $surname, $email, $username, $phone));
        exit();
    }

    if(pwdMatch($pwd, $pwdRepeat) !== false) {
        header("Location: ../signup.php?error=passwordDontMatch" . PassInformation($name, $surname, $email, $username, $phone));
        exit();
    }    

    if(uidExists($conn, $username, $email) !== false) {
        $userInfo = uidExists($conn, $username, $email);

        if ($userInfo['usersUid'] === $username) {
            header("Location: ../signup.php?error=usernameTaken&name=$name&email=$email");
            exit();
        } else if($userInfo['usersEmail'] === $email) {
            header("Location: ../signup.php?error=emailTaken&name=$name&username=$username");
            exit();
        }
    }
    
    createUser($conn, $name, $surname, $email, $username, $phone, $pwd);


} else {
    header("Location: ../signup.php");
    exit();
}