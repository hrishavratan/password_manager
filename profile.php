<?php
require_once("db.php");
session_start();

// Display the passwords table if the user is logged in
if(isset($_SESSION["username"])) {
    echo '
        <table>
            <caption>All your passwords are here '.$_SESSION["username"].'</caption>
            <tr>
                <th>no</th>
                <th>Website</th>
                <th>UserID</th>
                <th>Password</th>
            </tr>';

    // Retrieve passwords for the logged-in user
    $username = $_SESSION["username"];
    $sql = "SELECT * FROM password WHERE username='$username'";
    $result = mysqli_query($joint, $sql);
    
    // Print each password row
    while($row = mysqli_fetch_assoc($result)) {
        echo '
            <tr>
                <td>'.$row["no"].'</td>
                <td>'.$row["website"].'</td>
                <td>'.$row["userid"].'</td>
                <td>'.$row["password"].'</td>
            </tr>';
    }
    echo '</table>';
}

// Process form submission to add new password
if(isset($_POST["btn"]) && $_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["web"]) && !empty($_POST["pass"]) && !empty($_POST["user"])) {
    if(isset($_SESSION["username"])) {
        $username = $_SESSION["username"];
        $link = $_POST["web"];
        $userid = $_POST["user"];
        $password = $_POST["pass"];
        
        $sql = "INSERT INTO `password` (`username`,`website`,`userid`,`password`) VALUES ('$username','$link','$userid','$password')";
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
</head>
<body>
    
    <form method="post" action="profile.php">

        <label for="web">Website: </label>
        <input type="url" name="web" id="web">
        <label for="user">username: </label>
        <input type="text" name="user" id="user">
        <label for="pass">Password: </label>
        <input type="password" name="pass" id="pass">
        <button name="btn">Add password</button>
    </div>
</body>
</html>