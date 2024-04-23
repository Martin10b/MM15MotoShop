<?php

$ServerName = "localhost";
$dbUserName = "root";
$dbPassword = "";
$dbName = "d42";

$conn = mysqli_connect($ServerName, $dbUserName, $dbPassword, $dbName);


if (!$conn) {
    die("Connection failed: " . mysql_connect_eror());
}