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
        `no` int AUTO_INCREMENT PRIMARY KEY,
        `userid` varchar(25),
        `username` varchar(25) ,
        `password` varchar(255),
        `website` varchar(1000),
        `father` varchar(21)
        -- father is actually encryption key
    );";
    try
    {
        mysqli_query($joint,$sql);
    }
    catch(Exception $e)
    {

    }
?>