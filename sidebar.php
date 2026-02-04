<?php
include "dbconnection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $min = $_POST['minimum'] ?? 0;
    $max = $_POST['maximum'] ?? 50000;
    echo "Hello";
    echo "PHP received: min = $min, max = $max";
    $stmt = $conn->prepare("SELECT * from products WHERE price BETWEEN ? AND ?");
    $stmt->bind_param("ii", $min, $max);
    $stmt->execute();
    $result = $stmt->get_result();
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);
    exit; // IMPORTANT for fetch responses
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SideBar</title>
</head>
<style>
    .sidebar {
        margin-top: 50px;
        height: 100vh;
        background-color: #D4D7DE;
        width: 150px;
        position: fixed;
        /* z-index: 2; */
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        /* justify-content: center; */
        align-items: center;
        overflow-y: scroll;
    }

    .top-bar {
        display: flex;
        flex-direction: column;
        /* width: 100%; */
        /* margin-top: 50px; */
        /* border: 1px solid blue; */
        align-items: center;
        margin-top: 10px;
    }

    .sidebar .top-bar ul {
        font-size: 15px;
        list-style: none;

    }

    .top-bar ul li label {
        vertical-align: top;
    }

    .top-bar ul li {
        margin: 8px 0;
    }

    .top-bar ul li input {
        margin-right: 5px;
        width: 18px;
        height: 18px;
    }

    .price-range {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20px;
    }

    .price-range div input[type="number"] {
        width: 60px;
        margin: 10px 0px;
    }

    .price-range input[type="range"] {
        -webkit-appearance: none;
        width: 90%;
        height: 10px;
        background: black;
        border-radius: 5px;
        outline: none;


    }

    input[type="range"]::-webkit-slider-thumb {
        /* transform: scale(1.15); */
        -webkit-appearance: none;
        color: red;
        width: 10px;
        height: 15px;
        background-color: #704d4d;
        /* green */
        /* border-radius: 50%; */
        border: 2px solid #f8f8f8;
        cursor: pointer;
        /* margin-top: -6px; centers thumb on track */
    }
</style>

<body>
    <div class="sidebar">
        <div class="top-bar">

            <h3>Categories</h3>
            <ul>
                <li><input type="checkbox" id="mountain"><label for="mountain">Mountain Bikes</label></li>
                <li><input type="checkbox" name="" id="road"><label for="road">Road Bikes</label></li>
                <li><input type="checkbox" name="" id="electric"><label for="electric">Electric Bikes</label></li>
                <li><input type="checkbox" name="" id="hybrid"><label for="hybrid">Hybrid Bikes</label></li>
                <li><input type="checkbox" name="" id="kids"><label for="kids">Kids Bikes</label></li>
            </ul>
        </div>
        <div class="price-range">
            <h3>Price Range</h3>
            <div>
                <input type="number" name="" id="minimum" placeholder="min" value="0"> - <input type="number" name="" id="maximum" placeholder="max" value="50000">
            </div>
            Min
            <input type="range" name="" id="minprice-dragger" min="0" max="50000" value="0" step="10">
            Max
            <input type="range" name="" id="maxprice-dragger" min="0" max="50000" value="50000" step="10">
        </div>

    </div>

</body>
<script>
    let minValue = document.querySelector("#minimum");
    let maxValue = document.querySelector("#maximum");
    let minrange = document.querySelector("#minprice-dragger");
    let maxrange = document.querySelector("#maxprice-dragger");

    minrange.addEventListener("input", () => {

        minValue.value = minrange.value;
        console.log(minValue.value)
        if (minValue.value >= maxValue.value) {
            minValue.value = maxValue.value
        }
        console.log("Minimum : " + minValue.value + " and " + minrange.value);
        console.log("Maximun : " + maxValue.value + " and " + maxrange.value);
        let minimum = minValue.value;
        let maximum = maxValue.value;
        fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'minimum=' + encodeURIComponent(minimum) +
                    '&maximum=' + encodeURIComponent(maximum)
            })
            .then(res => res.text())
            .then(data => {
                console.log(data); // Logs: PHP received: min = 10, max = 100
            });
    })
    maxrange.addEventListener("input", () => {
        maxValue.value = maxrange.value;
        if (maxValue.value <= minValue.value) {
            maxValue.value = minValue.value
        }
        console.log("Minimum : " + minValue.value + " and " + minrange.value);
        console.log("Maximun : " + maxValue.value + " and " + maxrange.value);
        let minimum = minValue.value;
        let maximum = maxValue.value;
        fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'minimum=' + encodeURIComponent(minimum) +
                    '&maximum=' + encodeURIComponent(maximum)
            })
            .then(res => res.text())
            .then(data => {
                console.log(data); // Logs: PHP received: min = 10, max = 100
            });
    })
</script>

</html>