<?php
    $server="localhost";
    $username="root";
    $pass="";
    $database="manager";
    $joint=mysqli_connect($server,$username,$pass,$database);
    
    $sql=
    "CREATE TABLE IF NOT EXISTS users
    (
        `username` varchar(25) PRIMARY KEY,
        `password` varchar(255) 
    );
    ";
    mysqli_query($joint,$sql);
    $sql=
    "CREATE TABLE IF NOT EXISTS password
    (
        `no` INT  PRIMARY KEY AUTO_INCREMENT,
        `userid` varchar(25),
        `username` varchar(25) ,
        `password` varchar(255),
        `website` varchar(1000),
        FOREIGN KEY(username) REFERENCES users(username)
    );";
    try
    {
        mysqli_query($joint,$sql);
    }
    catch(Exception $e)
    {

    }
?>