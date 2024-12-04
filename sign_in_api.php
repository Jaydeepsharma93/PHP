<?php

header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

include("config.php");

$c1 = new UserConfig();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $res = $c1->signIn($email, $password);
    if ($res) {
        $arr['status'] = "Login successfully";
    } else {
        $arr['error'] = "Login failed";
    }
} else {
    $arr['err'] = "Only POST method is allowed";
}

echo json_encode($arr);
?>