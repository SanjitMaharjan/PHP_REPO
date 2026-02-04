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

            if(file_exists($deleteImage["image"])){
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
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="uploadImage">
        <br>
        Name: <input type="text" name="name" value="<?php echo $addProduct ? null : $myrows["name"] ?>">
        <br>
        Company: <input type="text" name="company" value="<?php echo $addProduct ? null : $myrows["company"] ?>">
        <br>
        CC: <input type="text" name="cc" value="<?php echo $addProduct ? null : $myrows["cc"] ?>">
        <br>
        Price: Rs.<input type="number" name="price" value="<?php echo $addProduct ? null : $myrows["price"] ?>">
        <br>
        <button type="submit" name="<?php echo $addProduct == true ? "Add" : "Edit" ?>"><?php echo $addProduct == true ? "Add" : "Edit" ?> </button>
        <?php if (!$addProduct): ?>
            <a href="<?= $_SERVER['PHP_SELF'] ?>">Cancel</a>
        <?php endif; ?>

    </form>

    <table style="width: 100%; text-align: center;">
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
</body>

</html>