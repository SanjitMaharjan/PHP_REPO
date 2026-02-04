
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<style>
    *{
        margin: 0;
        padding: 0;
    }
.container{
    background-color: rgb(202, 201, 201);
    /* width: 180%; */
    max-width: none;
    display: grid;
    /* grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); */

    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    
}
</style>

<body>

    <!-- <div class="main-container"> -->

     <!-- <form action="" method="get">
            Search: <input type="text" name="search">
            <select name="select" id="">
                <?php while ($row = $uniqueValues->fetch_assoc()) { ?>
                    <option value="<?php echo $row["cc"] ?>"><?php echo $row["cc"] ?></option>
                <?php } ?>
            </select>
            <button type="submit" name="submit">
                Search
            </button>
        </form> -->

    <div class="container">
        <?php while ($row = $result->fetch_assoc()) {
            // include "productsCard.php";
            include "test.php";
        }
        ?>
    </div>
    <!-- 
    </div> -->
</body>

</html>