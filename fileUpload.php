<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // print_r($_FILES["uploadedFile"]);
    $file = $_FILES["uploadedFile"];
    $fullpath = "images/".time() . "_" . $_FILES["uploadedFile"]["name"];
    echo $file["name"];
    move_uploaded_file($_FILES["uploadedFile"]["tmp_name"],$fullpath);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="uploadedFile">
        <button>Submit</button>
    </form>

    <h1>Displaying the image</h1>
</body>

</html>