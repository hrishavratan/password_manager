<?php
session_start();
require_once("db.php");
$already = false;
$error = false;
$alert = false;

if (
    isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["user"]) && !empty($_POST["pass"])
    && !empty($_POST["cpass"])
) {
    $username = $_POST["user"];
    $password = $_POST["pass"];
    $cpassword = $_POST["cpass"];
    if ($already == false && $password === $cpassword) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "SELECT * FROM users WHERE username='$username'";
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
        $result = mysqli_query($joint, $sql);
        $row = mysqli_num_rows($result);
        if ($row > 0) {
            $already = "This username is unavailable, try new one";
        } else {
            $sql = "INSERT into `users` (`username`,`password`) Values ('$username','$password')";
            mysqli_query($joint, $sql);
            $alert = "Your account is created, You can ";
        }
    }
} 
elseif (isset($_POST["submit"])) 
{
    $error = "Inputs are not properly filled";
}


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Manager</title>
    <link rel="icon" href="fav.webp">
    <link rel="stylesheet" href="style.css">
</head>

<body class="p-7">

    <?php
    if ($already) {
        echo '<strong>Alert!</strong>' . $already;
    }
    if ($error) {
        echo '<strong>Alert!</strong>' . $error;
    }
    if ($alert) {
        echo '<strong>Alert!</strong>' . $alert . '<a class="border-b-2 border-solid color border-green-600 text-green-600" 
        href="login.php">Login </a>."here" ';
    }
    ?>

<div id="description">
        <h1 class="text-center font-extrabold text-3xl mb-3">Password Manager</h1>
        <p class="mb-7">
            SecureKey Vault is the ultimate solution for safeguarding your digital credentials and sensitive
            information. With its robust encryption algorithms and user-friendly interface, SecureKey Vault offers
            unparalleled security and convenience in managing your passwords. Gone are the days of remembering multiple
            passwords or using insecure methods to store them. SecureKey Vault employs state-of-the-art encryption
            techniques to ensure that your passwords and personal data remain secure from prying eyes and malicious
            attacks.
        </p>
    </div>
    <div id="registeration " class="flex justify-center">

        <form method="post" action="index.php" class="w-5/12 text-left ">
            <fieldset class="border border-solid border-black p-4 flex flex-col gap-3">
                <legend>Signup here</legend>
                <label for="user">Username : </label>
                <input class="border border-black rounded-sm" id="user" type="text" name="user">
                <label for="pass">Password : </label>
                <div id="first">
                    <input class="border border-black rounded-sm w-10/12" type="password" id="pass" name="pass"
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" autocomplete="on"
                        title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
                        required>
                    <input type="checkbox" class="showpass">Show
                </div>
                <label class="ml--4" for="cpass">Confirm Password : </label>
                <div id="se">
                    <input class="border border-black rounded-sm w-10/12" type="password" name="cpass" id="cpass"
                    autocomplete="on" placeholder="Write the same password again">
                    <input type="checkbox" class="showpass">Show
                </div>
                <div class="w-100% flex items-center justify-center">
                    <button class="bg-blue-600 w-2/5 rounded-md  text-white text-center" name="submit">submit</button>
                </div>
            </fieldset>
        </form>
        <div id="message">
            <h3>Password must contain the following:</h3>
            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
            <p id="number" class="invalid">A <b>number</b></p>
            <p id="length" class="invalid">Minimum <b>8 characters</b></p>
        </div>
    </div>
    <p>Already have an id? <a class="border-b-2 border-solid color border-green-600 text-green-600"
            href="login.php">Login now </p>
    <style>
        #message {
            display: none;
            background: #f1f1f1;
            color: #000;
            position: relative;
        }

        #message p {
            padding: 10px 35px;
            font-size: 18px;
        }

        .valid {
            color: green;
        }

        .valid:before {
            position: relative;
            left: -35px;
            content: "✔";
        }

        .invalid:before {
            position: relative;
            left: -35px;
            content: "✖";
        }

        .invalid {
            color: red;
        }
    </style>
    <script src="script.js"></script>
</body>

</html>