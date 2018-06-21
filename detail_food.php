<?php
if (!isset($_GET["food_id"])) {
    header("location: index.php");
}
require_once 'db_connect.php';

$food_detail_query = "SELECT * FROM `food` WHERE `food_id` = " . $_GET["food_id"];
$food_detail_result = mysqli_query($db_link, $food_detail_query);
if (!$food_detail_result) {
    header("location: not_found.php");
}
$food_detail = mysqli_fetch_assoc($food_detail_result);

$restaurant_detail_query = "SELECT * FROM `restaurant` WHERE `store_id` = " . $food_detail['restaurant_id'];
$restaurant_detail_result = mysqli_query($db_link, $restaurant_detail_query);
if (!$restaurant_detail_result) {
    header("location: not_found.php");
}
$restaurant_detail = mysqli_fetch_assoc($restaurant_detail_result);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $food_detail['food_name'] ?> - 美食東華</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
</head>
<body>
<div id="nav-placeholder"></div>
<script>
    $(function () {
        $("#nav-placeholder").load("ui_navbar.php");
    });
</script>

<section class="hero is-light">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                <?php echo $food_detail['food_name'] ?>
            </h1>
            <h2 class="subtitle">
                <?php echo $restaurant_detail['restaurant_name'] ?>
            </h2>
        </div>
    </div>
</section>
<div style="width:71%; margin: 0 auto;">
    <br>
    <h1 class="title">餐點資訊</h1>

    <div class="columns is-multiline">
        <div class="column is-one-third">
            <div class="box">
                <p class="title">價格</p>
                <p class="subtitle"><?php echo $food_detail['food_price'] ?></p>
            </div>
        </div>
    </div>

</div>

<div style="width:71%; margin: 0 auto;">
    <br>
    <h1 class="title">評論</h1>

    <div class="columns is-multiline">
        <div class="column is-one-third">
            <div class="box">
                <p class="title">留言標題</p>
                <p class="subtitle">留言內容</p>
            </div>
        </div>
    </div>

</div>
<!-- automatic comment tiles here -->
<!-- new comment field here-->

</body>