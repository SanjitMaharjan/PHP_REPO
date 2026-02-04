<?php
include "dbconnection.php";

$allCC = $conn->prepare("SELECT DISTINCT cc FROM products;");
$allCC->execute();
$uniqueValues = $allCC->get_result();

if (isset($_GET["submit"])) {
    $search = $_GET["search"];
    $filterProduct = $conn->prepare("SELECT * FROM products WHERE name LIKE ?");
    $like = "%$search%";
    // $cc = $_GET["select"];
    $filterProduct->bind_param("s", $like);
    $filterProduct->execute();
    $result = $filterProduct->get_result();
} else {
    $displayProduct = $conn->prepare("SELECT * from products");
    $displayProduct->execute();
    $result = $displayProduct->get_result();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NavBar</title>
</head>
<style>
    nav {
        position: fixed;
        width: 100%;
        height: 50px;
        display: grid;
        grid-template-columns: 1fr 2fr 2fr;
        background-color: #D4D7DE;
        z-index: 1;
    }

    .logo-container {
        height: 100%;
        /* width: 50px; */
        /* background-color: rebeccapurple; */
    }

    .logo {
        height: 46px;
        width: 50px;
        border-radius: 50%;
        overflow: hidden;
        margin: 2px 2px 2px;
    }

    .logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .search {
        display: flex;
        /* background-color: purple; */
        justify-content: center;
        align-items: center;
    }

    .search .searchbar  {
        display: flex;
        height: 80%;
        width: 80%;
        background-color: red;
        position: relative;
        box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;


    }

    .search .searchbar form input {
        font-size: 20px;
        width: 100%;
        border: none;
    }

    .search .searchbar form input:focus {
        outline: none;
    }
.search .searchbar form{
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
}
    .search .searchbar button {
        position: absolute;
        height: 100%;
        right: 0;
    }

    .navigation ul {
        display: flex;
        list-style: none;
        justify-content: flex-end;
        /* background-color: red; */
        height: 100%;
        margin-top: 0;
        align-items: center;
    }
    .navigation ul li{
        display: flex;
        vertical-align: bottom;
        height: 100%;
        align-items: center;
        padding: 0px 10px;
    }
    .navigation ul li:hover{
        /* background-color: wheat; */
        box-shadow: rgba(188, 4, 4, 0.25) 0px 14px 28px, rgba(0, 0, 0, 0.22) 0px 10px 10px;
    }
</style>

<body>
    <nav>
        <div class="logo-container">
            <div class="logo"><img src="bike1.jpg" alt=""></div>
        </div>

        <div class="search">
            <div class="searchbar">
                <form action="" method="get">
                <input type="text" placeholder="Search" name="search">
                <button type="submit" name="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="navigation">
            <ul>
                <li>Home</li>
                <li>About Us</li>
                <li>Products</li>
                <li>Contact Us</li>

            </ul>
        </div>
    </nav>

</body>

</html>