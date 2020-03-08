<?php

$user = $_SESSION["username"];
$pass = $_SESSION['password'];
if (isset($_SESSION["username"]) && isset($_SESSION["password"]) && check_user($conn, $user, $pass)) {
    //$user_id= user_id($conn, $user, $pass);
    require 'check_periority_user.php';
} else {
    //echo 'not found';
    session_destroy();
    $redirectURL = "market_login_page.php";
    header("Location:" . $redirectURL);
}
