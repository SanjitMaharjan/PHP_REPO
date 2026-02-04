<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Compact Bike Card</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bungee&family=Oswald:wght@200..700&display=swap');
    </style>
    <style>
        .productCard-container {
            /* display: flex;
            flex-direction: column; */
            display: grid;
            grid-template-rows: auto 1fr;
            /* background-color: red; */
            margin: 10px;
            max-width: 350px;

        }

        .productCard-container:hover .productImage img {
            transform: scale(1.1);
        }

        .productImage {
            width: 100%;
            /* height: 300px; */
            height: auto;
            overflow: hidden;
            max-height: 250px;
            align-items: center;
            justify-content: center;
            box-shadow: rgba(0, 0, 0, 0.15) 2.4px 2.4px 3.2px;
        }

        .productImage img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform 0.4s ease;

        }

        .productDetail-container h2 {
            font-size: 30px;
            font-family: "Bungee", sans-serif;
            font-weight: bold;
            color: #464141;
        }
        .productDetail-container{
            box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
            display: flex;
            flex-direction: column;
            
            padding-left: 20px;
            padding-bottom: 4px;
        }
        .productDetail-container .productDetail table tr > td:first-of-type {
            color: #1e0e0e;
            padding-right: 10px;
            font-weight: bold;
            font-family: "Bungee", sans-serif;
        }
        .productDetail-container .productDetail table tr > td:not(:first-of-type){
            color: #ad0a0a;
            font-family: "Bungee", sans-serif;
        }
    </style>
</head>

<body>

    <div class="productCard-container">
        <div class="productImage">
            <img
                src="<?php echo $row["image"] ?>"
                alt="Honda Bike"
                class="" />
        </div>
        <div class="productDetail-container">
            <h2 class="">
                <?php echo $row["name"] ?>
            </h2>
            <div class="productDetail">
                <table>
                    <tr>
                        <td class="">Company</td>
                        <td class=""><?php echo $row["company"] ?></td>
                    </tr>
                    <tr>
                        <td class="">CC</td>
                        <td class=""><?php echo $row["cc"] ?></td>
                    </tr>
                    <tr>
                        <td class="">Price</td>
                        <td class="">
                            <?php echo $row["price"] ?>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    </div>

</body>

</html>