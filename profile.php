<?php
require_once("db.php");
session_start();
function encryptPassword($password, $key)
{
    return openssl_encrypt($password, 'AES-256-CBC', $key, 0,substr($key, 0, 16));
}
function decryptPassword($encryptedPassword, $key) 
{
    return openssl_decrypt($encryptedPassword, 'AES-256-CBC', $key, 0,substr($key, 0, 16) );
}
    
if(isset($_SESSION["username"])) 
{
    echo '
        <table class="text-center  border-black border-2 w-full">
            <caption class="my-20">All your passwords are here for '.$_SESSION["username"].'</caption><br><br>
            <tr class="border-spacing-1">
                <th class="border-2 border-black">Website</th>
                <th  class="border-2 border-black">UserID</th>
                <th  class="border-2 border-black">Password</th>
            </tr>';

    $username = $_SESSION["username"];
    $sql = "SELECT * FROM password WHERE username='$username'";
    $result = mysqli_query($joint, $sql);
    
    while($row = mysqli_fetch_assoc($result)) 
    {
        echo '
            <tr class="border-spacing-2">
                <td >'.$row["website"].'</td>
                <td >'.$row["userid"].'</td>
                <td >'.decryptPassword($row["password"],$row["father"]).'</td>
            </tr>';
    }
    echo '</table>';
}

// Process form submission to add new password
if(isset($_POST["btn"]) && $_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["web"]) && !empty($_POST["pass"]) && !empty($_POST["user"])) 
{
    
    function generateRandomkey()
    {

        $keyLength = 17;
        $key = "";

        $charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-+=<>?";

        // Generation of password
        for ($i = 0; $i < $keyLength; $i++) 
        {
            $randomIndex = rand(0,strlen($charset));
            $key=$key.$charset[$randomIndex];
        }
        return $key;
    }
    
    if(isset($_SESSION["username"])) 
    {
        $username = $_SESSION["username"];
        $link = $_POST["web"];
        $userid = $_POST["user"];
        $key=generateRandomkey();
        $password =encryptPassword($_POST["pass"],$key);
        
        $sql = "INSERT INTO `password` (`username`,`website`,`userid`,`password`,`father`) VALUES ('$username','$link','$userid','$password','$key')";
        mysqli_query($joint, $sql);

        // Redirect to prevent duplicate form submission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Display error message if form is submitted incorrectly
elseif(isset($_POST["btn"])) {
    echo "Fill the details correctly";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="icon" href="fav.webp">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <br><br>
    <form class="flex flex-col gap-2 " method="post" action="profile.php">

        <label for="web">Website: </label>
        <input class="border border-black rounded-sm w-10/12" type="url" name="web" id="web">
        <label for="user">username: </label>
        <input class="border border-black rounded-sm w-10/12"type="text" name="user" id="user">
        <label for="pass">Password: </label>
        <input class="border border-black rounded-sm w-10/12"type="password" name="pass" id="pass">
        <br>
        <button class="bg-blue-200" name="btn">Add password</button>
    </form>
    <br>
    <div id="suggest" class="text-center">
                <h1 class="font-bold text-center">Suggest a difficult password</h1>
                <p class="h3 mb-3 fw-normal ">Choose number of characters for password with min value 4 : </h1>
                <input class="m-auto " type="number" id="passwordLength" min="2" max="25" value="8">
                <input class="form-check-input" type="checkbox" id="includeSpecialChars"> Include special characters
                <br><br>
                <button class="text-center" type="button" id="generateBtn">Generate Password</button><br>
                <p id="password"></p>

                <input type="hidden" name="generatedPassword" id="generatedPassword">
    </div>
    <script src="profile.js" ></script>
</body>
</html>