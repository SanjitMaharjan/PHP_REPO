<?php
include "dbconnection.php";
// echo "Hello From Login <br>";

session_start();



if (isset($_SESSION["username"])) {

    header("Location: dashboard.php");
    exit();
}

if (isset($_SESSION["flashMessage"])) {
    $display = $_SESSION["flashMessage"];
    echo "$display";
    unset($_SESSION["flashMessage"]);
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $stmt = $conn->prepare("SELECT username, password from user where username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        // echo "User found successful";
        $row = $result->fetch_assoc();
        // echo $row["username"];
        // echo $row["password"];

        if (password_verify($password, $row["password"])) {
            echo "Login SUccessful";

            // session_start();
            $_SESSION["username"] = $username;

            header("Location: dashboard.php");
        } else {
            echo "Username or password not matched";
        }
    } else {
        echo "Username or password not matched";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
        Username: <input type="text" name="username">
        Password: <input type="text" name="password">
        <button type="submit">Login</button>
    </form>
    <a href="./">Register</a>
</body>

</html>