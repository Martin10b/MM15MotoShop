<?php

function emptyInputSignup($name, $surname, $email, $username, $phone, $pwd, $pwdRepeat) {
    $result;
    if(empty($name) || empty($surname) || empty($email) || empty($username) || empty($phone) || empty($pwd) || empty($pwdRepeat)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidUid($username) {
    $result;
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidPhone($phone)
{
    $result;
    if(strlen($phone) != 10 || !preg_match("/^\\d+$/", $phone)) {
        $result = true;
    } else {
        $result = false;
    }        
    return $result;
}

function phoneExist($conn, $phone)
{
    $sql = "SELECT * FROM users WHERE phone = ?;";    
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../signup.php?error=stmtFailed");
        exit();
    }
       
    mysqli_stmt_bind_param($stmt, "i", $phone);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    
    if(empty(mysqli_fetch_assoc($resultData))) {
        $result = false;
        return $result;
    } else {
        $result = true;        
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

function invalidEmail($email) {
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdChar($pwd) {
    $result;
    if(strlen($pwd) < 8) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
    $result;
    if($pwd !== $pwdRepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";

    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../signup.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
    
    mysqli_stmt_close($stmt);
}

function PassInformation($name, $surname, $email, $phone) {
    return "&name=$name&surname=$surname&email=$email&phone=$phone";
}

function createUser($conn, $name, $surname, $email, $username, $phone, $pwd) {
    $sql = "INSERT INTO users (usersName, usersLastName, usersEmail, usersUid, phone, usersPwd) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../signup.php?error=stmtFailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssssis", $name, $surname, $email, $username, $phone, $hashedPwd);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    //Auto Log In
    $uidExists = uidExists($conn, $username, $username);

    if($uidExists === false) {
        header("Location: ../login.php?error=autoLogIn");
        exit();
    }

    session_start();
    $_SESSION['userid'] = $uidExists["usersId"];
    $_SESSION['useruid'] = $uidExists["usersUid"];
    header("Location: ../index.php");
    exit();
}

function emptyInputLogin($username, $pwd) {
    $result;
    if(empty($username) || empty($pwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username, $username);
    
    if($uidExists === false) {
        header("Location: ../login.php?error=wrongloginUid");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);
    
    if($checkPwd === false) {
        header("Location: ../login.php?error=wrongloginPwd&username=$username");
        exit();
    } else if($checkPwd === true) {
        session_start();
        $_SESSION['userid'] = $uidExists["usersId"];
        $_SESSION['useruid'] = $uidExists["usersUid"];
        $_SESSION['userType'] = $uidExists["admins"];
                
        header("Location: ../index.php");
        exit();
    }
}