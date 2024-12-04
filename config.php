<?php

class UserConfig{

    private $localhost = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "user";
    private $table = "sign";
    private $create;

    public function __construct(){
        $this->create = mysqli_connect($this->localhost, $this->username, $this->password, $this->database);
    }

    function signUp($name, $email, $password)
    {
        $pwd = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO $this->table (name,email,password) VALUES ('$name','$email','$pwd')";
        $insertData = mysqli_query($this->create, $query);
        return $insertData;
    }

    public function signIn($email,$password)
    {
        $query = "SELECT * FROM $this->table WHERE email='$email'"; 
        
        $selectData = mysqli_query($this->create, $query);
        $data =mysqli_fetch_assoc($selectData);
        $defaultPassword = $data['password'];


        $res = password_verify($password, $defaultPassword);

        echo $res;
        
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

}