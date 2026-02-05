<?php
session_start();

// header("Cache-Control: no-cache, no-store, max-age=0, must-revalidate");
// header("Pragma: no-cache");
// header("Expires: Sun, 01 Jan 1990 00:00:00 GMT");

if (!isset($_SESSION["username"])) {
    // header("Location: login.php");
    echo "<script>window.location.href='./login.php';</script>";
    exit();
}

$passwordErr = "";
include "dbconnection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // if (isset($_POST['logout'])) {
    //     // session_start();
    //     // session_unset();
    //     // session_destroy();
    //     // header("Location: login.php");
    //     // exit();
    // }

    if (isset($_POST['update'])) {
        $username = $_SESSION["username"];
        $password = $_POST["oldPassword"];
        if (empty($_POST["newPassword"]) || strlen($_POST["newPassword"]) <= 5) {
            $passwordErr = "Minimum password length is 6";
        } else {
            $stmt = $conn->prepare("SELECT username, password from user where username=?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                echo "Password Correct";
                $newPassword = $_POST["newPassword"];
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updatePassword = $conn->prepare("UPDATE user SET password=? where username=? ");
                $updatePassword->bind_param("ss", $hashedPassword, $username);
                $updatePassword->execute();
            } else {
                echo "Incorrect Current password";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<style>
    * {
        margin: 0px;
        padding: 0px;
    }

    .main-container {
        padding-top: 50px;
        padding-left: 150px;

    }
</style>

<body>
    <?php include "sideBar.php" ?>
    <?php include "navBar.php" ?>
    <div class="main-container">
        <!-- <h1>Welcome to the dashboard <?php echo $_SESSION['username'] ?></h1>
        <a href="logout.php">Logout</a>
        <button type="submit" name="logout">Logout</button>
        <h3>Update Password</h3>
        <form action="" method="POST">
            Old Password: <input type="text" name="oldPassword">
            <br>
            New Password: <input type="text" name="newPassword">
            <span><?php echo $passwordErr ?></span>
            <br>
            <button type="submit" name="update">Update</button>
        </form> -->

        <?php include "product.php" ?>
    </div>


</body>

</html>