<?php
require_once 'db_connect.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>美食東華</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/detail_page_style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
</head>

<body>
<section class="hero is-primary is-medium is-bold">
    <div class="hero-head">
        <div id="nav-placeholder"></div>
        <script>
            $(function () {
                $("#nav-placeholder").load("ui_navbar.php");
            });
        </script>
    </div>
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title">
                發現並分享東華四周美好的食物吧！
            </h1>
            <h2 class="subtitle">
                <br>美食無所不在，只是缺少發現；
                <br> 註冊、登入並分享，讓美食得以進入眾人的眼光。
            </h2>
        </div>
    </div>
</section>
<div class="container">
    <section class="hero">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    滿分推薦美食
                </h1>
                <h2 class="subtitle">
                    被使用者們評選為滿分的奇幻餐點
                </h2>
            </div>
        </div>
    </section>
    <div class="columns is-multiline">
        <?php
        $five_star_foods_query = "SELECT * FROM `food_comments` WHERE `food_rate` = 5 ";
        $five_star_foods_result = mysqli_query($db_link, $five_star_foods_query);
        if (!$five_star_foods_result) {
            echo "資料庫發生異常，請稍後再試或聯絡網站管理者。";
        } else {
            if ($five_star_foods_result->num_rows == 0) {
                echo "目前還沒有滿分的食物。等待奇蹟的出現吧！";
            } else {
                while ($five_star_food = mysqli_fetch_assoc($five_star_foods_result)) {
                    $five_star_food_data_query = "SELECT * FROM `food` WHERE `food_id` = " . $five_star_food['food_id'];
                    $five_star_food_data_result = mysqli_query($db_link, $five_star_food_data_query);
                    if ($five_star_food_data_result->num_rows != 0) {
                        $five_star_food_data = mysqli_fetch_assoc($five_star_food_data_result);

                        $five_star_food_restaurant_query = "SELECT * FROM `restaurant` WHERE `store_id` = " . $five_star_food_data['restaurant_id'];
                        $five_star_food_restaurant_result = mysqli_query($db_link, $five_star_food_restaurant_query);
                        if ($five_star_food_restaurant_result->num_rows != 0) {
                            $five_star_food_restaurant = mysqli_fetch_assoc($five_star_food_restaurant_result);

                            echo '<div class="column is-one-third"><div class="box">';
                            //TODO use star icon instead
                            echo '<p class="title"><a href="detail_food.php?food_id=' . $five_star_food['food_id'] . '">' .
                                $five_star_food_data['food_name'] . '</a></p>';
                            echo '<p class="subtitle">' . $five_star_food_restaurant['restaurant_name'] . '</p>';
                            echo '<p class="wordwrap">' . $five_star_food['food_comment'] . '</p>';
                            echo '</div></div>';
                        }
                    }
                    //TODO multi-page selector
                }
            }
        }
        ?>
    </div>
</div>

</html>