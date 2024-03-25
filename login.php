<?php
    require_once("db.php");
    session_start();
    if(isset($_POST["btn"])&&$_SERVER["REQUEST_METHOD"] == "POST" &&!empty($_POST["id"]) && !empty($_POST["pass"]))
    {
        $id=$_POST["id"];
        $password=$_POST["pass"];
        $sql="SELECT * FROM users where username='$id'";
        $result=mysqli_query($joint,$sql);
        $row=mysqli_num_rows($result);
        $result = mysqli_fetch_assoc($result);
        if($row==0)
        {
            echo'<strong>Alert! No such username exists</strong>';
        }
        elseif(password_verify($password,$result["password"]))
        {
            $_SESSION["username"]=$id;
            header('Location:profile.php');
        }
        else
        {
            echo"'<p>Passwords dont match, try again</p>'";
        }        
    }
    else if(isset($_POST["btn"]))
    {
        echo"fill the details correctly";
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="icon" href="fav.webp">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post" action="login.php">

        <fieldset class="border border-solid border-black p-4 flex flex-col gap-3 w-10/12">
            <legend>Login here</legend>
            <label for="id">username: </label>
            <input class="border border-black rounded-sm w-10/12" type="text" name="id"><br>
            <label for="pass">Password: </label>
            <input class="border border-black rounded-sm w-10/12"type="password" name="pass" id="pass"><br>
            <button class="bg-blue" name="btn">submit</button>
        </fieldset>

    </form>
</body>
</html>