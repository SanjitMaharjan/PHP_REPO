<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
include "dbconnection.php";
$addProduct = true;

$displayProduct = $conn->prepare("SELECT * from products");
$displayProduct->execute();
$result = $displayProduct->get_result();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // $image = $_POST["image"];
    $file = $_FILES["uploadImage"];
    $fullpath = "images/" . time() . "_" . $file["name"];
    move_uploaded_file($file["tmp_name"], $fullpath);
    $name = $_POST["name"];
    $company = $_POST["company"];
    $cc = $_POST["cc"];
    $price = $_POST["price"];
    if (isset($_POST["Add"])) {


        // echo $file["name"];
        // echo "THis is add";
        $productAdd = $conn->prepare("INSERT INTO products (image, name, company, cc, price ) VALUES (?,?,?,?,?)");
        $productAdd->bind_param("sssii", $fullpath, $name, $company, $cc, $price);
        $productAdd->execute();


        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    if (isset($_POST["Edit"])) {
        if ($file["name"] == null) {
            $productAdd = $conn->prepare("UPDATE products SET name=?, company=?, cc=?, price=? WHERE id = ?");
            $productAdd->bind_param("ssiii", $name, $company, $cc, $price, $_GET["edit"]);
        } else {

            $deletePre = $conn->prepare("SELECT image FROM products where id = ?");
            $deletePre->bind_param("i", $_GET["edit"]);
            $deletePre->execute();
            $delete = $deletePre->get_result();
            $deleteImage = $delete->fetch_assoc();

            if (file_exists($deleteImage["image"])) {
                unlink($deleteImage["image"]);
            }


            $productAdd = $conn->prepare("UPDATE products SET image=?, name=?, company=?, cc=?, price=? WHERE id = ?");
            $productAdd->bind_param("sssiii", $fullpath, $name, $company, $cc, $price, $_GET["edit"]);
        }

        $productAdd->execute();
        echo $file["name"];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
if (isset($_GET["edit"])) {
    echo "This is edit";
    $addProduct = false;

    // $requiredData = $result->fetch_assoc();
    $singleData = $conn->prepare("SELECT * from products WHERE id = ?");
    $singleData->bind_param("i", $_GET["edit"]);
    $singleData->execute();
    $output = $singleData->get_result();
    $myrows = $output->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        .addProduct-container {
            background: #d9d99a;
            background: linear-gradient(264deg, rgba(217, 217, 154, 1) 0%, rgba(181, 177, 177, 1) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            /* justify-content: center; */
            /* width: 100%; */
            gap: 10px;
            padding-top: 60px;
        }

        .addProduct {
            width: 70%;
        }

        .addProduct-container .addProduct form {
            width: 100%;
            display: flex;
            flex-direction: column;
            /* background-color: red; */

        }

        .addProduct-container .addProduct form input[type="text"],
        input[type="number"] {
            font-size: 20px;
            padding: 3px;
            border-radius: 15px;
            padding-left: 10px;
            border: none;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;

        }

        .addProduct-container .addProduct form input[type="text"],
        input[type="number"]:focus {
            outline: none;
        }

        .addProduct-container .addProduct form span {
            font-size: 22px;
        }

        .addProduct-container .addProduct form button {
            margin-top: 10px;
            font-size: 20px;
            border-radius: 15px;
            border: none;
            box-shadow: rgba(0, 0, 0, 0.35) 0px -50px 36px -28px inset;
            transition: padding 0.3s ease, margin-top 0.3s ease, transform 0.3s ease;
            cursor: pointer;
            /* align-self: center; */
        }

        .addProduct-container .addProduct form button:hover {
            transform: scale(0.9);
            margin-top: 5px;
            padding: 10px;

        }

        .addProduct-container .displayProduct {

            /* background-color: #d9d99a; */
            width: 100%;


        }

        .addProduct-container .displayProduct table {
            width: 100%;
            text-align: center;
            font-size: 22px;

        }

        .addProduct-container .displayProduct table thead tr th {
            box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
            padding: 10px;
            font-weight: bold;
            color: #f4f4ee;
            font-family: 'Courier New', Courier, monospace;
            background-color: #4f4d4d;
        }

        .addProduct-container .displayProduct table tbody tr td {
            /* border: 1px solid red; */
            box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;

        }
        .addProduct-container .displayProduct table tbody tr:hover{
            background-color: #585854;
        }

        *{
            margin: 0;
            padding: 0;
        }
        a{
            text-decoration: none;
            color: black;
        }
    </style>
</head>

<body>
    <?php include "navBar.php" ?>
    <div class="addProduct-container">
        <div class="addProduct">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="file" name="uploadImage" style="font-size: 20px;">

                <span>Name:</span> <input type="text" name="name" placeholder="Product Name" value="<?php echo $addProduct ? null : $myrows["name"] ?>">

                <span>Company:</span> <input type="text" name="company" placeholder="Company" value="<?php echo $addProduct ? null : $myrows["company"] ?>">

                <span>CC:</span> <input type="text" name="cc" placeholder="CC" value="<?php echo $addProduct ? null : $myrows["cc"] ?>">

                <span>Price:</span> <input type="number" name="price" placeholder="Price" value="<?php echo $addProduct ? null : $myrows["price"] ?>">

                <button type="submit" name="<?php echo $addProduct == true ? "Add" : "Edit" ?>"><?php echo $addProduct == true ? "Add" : "Edit" ?> </button>
                <?php if (!$addProduct): ?>
                    <a href="<?= $_SERVER['PHP_SELF'] ?>">Cancel</a>
                <?php endif; ?>

            </form>
        </div>

        <div class="displayProduct">
            <table>
                <!-- <th>S.N</th> -->
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Company</th>
                        <th>CC</th>
                        <th>Price</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><img src="<?php echo $row["image"] ?>" alt="" height="150px"></td>
                            <td><?php echo $row["name"] ?></td>
                            <td><?php echo $row["company"] ?></td>
                            <td><?php echo $row["cc"] ?></td>
                            <td>Rs.<?php echo $row["price"] ?></td>
                            <td><a href="?edit=<?php echo $row["id"] ?>">Edit</a></td>
                            <td><a href="delete.php?delete=<?php echo $row["id"] ?>">Delete</a></td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</body>

</html>