<?php

header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

include("config.php");

$c1 = new UserConfig();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $res = $c1->signUp($name, $email, $password);
    if ($res) {
        $arr['msg'] = "Signup successfully";
    } else {
        $arr['msg'] = "Signup failed";
    }
} else {
    $arr['err'] = "Only POST method is allowed";
}

echo json_encode($arr);
