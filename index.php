<?php
include "dbconnection.php";

$name = $nameErr = $email = $emailErr = $username = $usernameErr = $password = $passwordErr = "";
session_start();
if(isset($_SESSION["username"])){
    header("Location: dashboard.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } elseif (!preg_match("/^[a-z]+$/", $_POST["username"])) {
        $usernameErr = "Invalid Character in username";
    } else {
        $data = $conn->prepare("SELECT username from user where username = ?");
        $data->bind_param("s", $_POST["username"]);
        $data->execute();
        $result = $data->get_result();

        if ($result->num_rows > 0) {
            $usernameErr = "Username already taken";
        } else {
            $username = $_POST["username"];
        }
    }
if(empty($_POST["name"])){
    $nameErr = "Name field is required";
    }
    elseif (!preg_match("/^[a-zA-Z ]+$/", $_POST["name"])){
    $nameErr = "Invalid character in name";
}
else{

    $name = $_POST["name"];
}
if(empty($_POST["email"])){
    $emailErr = "Email field is required";
    }
    elseif(!filter_var($_POST["email"], FILTER_SANITIZE_EMAIL) ){
    $emailErr = "Invalid Email";
    
}
    elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ){
    $emailErr = "Invalid Email";
    
}elseif(!preg_match("/^[a-zA-Z0-9._-]+@(gmail\.com|outlook.com)$/i",$_POST["email"])){
    $emailErr = "Email is not valid";
}
else{
    $email = $_POST["email"];

}
if(empty($_POST["password"]) || strlen($_POST["password"]) <=5){
    $passwordErr = "Minimum password length is 6";
}else{
    $password = $_POST["password"];
    $hadhedPassword = password_hash($password, PASSWORD_DEFAULT);

}

    if (!empty($username) && !empty($name) && !empty($email) && !empty($password)) {
        $stmt = $conn->prepare("INSERT INTO user (name, email, username, password) VALUES (? , ? , ? , ?)");
        $stmt->bind_param("ssss", $name, $email, $username, $hadhedPassword);
        $stmt->execute();

        session_start();
        $_SESSION["flashMessage"] = "User Created Successfully";

        header("Location: login.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        Name: <input type="text" name="name">
        <span><?php echo $nameErr ?></span>
        <br>
        Email: <input type="email" name="email">
        <span><?php echo $emailErr ?></span>
        <br>
        Username : <input type="text" name="username">
        <span><?php echo $usernameErr ?></span>
        <br>
        Password : <input type="text" name="password">
        <span><?php echo $passwordErr ?></span>
        <button type="submit">SignUp</button>
    </form>
    <a href="login.php">Login</a>
</body>

</html>