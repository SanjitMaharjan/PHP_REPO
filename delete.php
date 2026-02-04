<?php
include "dbconnection.php";
$id = $_GET["delete"];

$deletePre = $conn->prepare("SELECT image FROM products where id = ?");
$deletePre->bind_param("i", $id);
$deletePre->execute();
$delete = $deletePre->get_result();
$deleteImage = $delete->fetch_assoc();

if (file_exists($deleteImage["image"])) {
    unlink($deleteImage["image"]);
}

$delete = $conn->prepare("DELETE FROM products WHERE id = ?");
$delete->bind_param("i", $id);
$delete->execute();



header("Location: addProduct.php")
?>