<?php
if (!isset($_GET["store_id"])) {
    header("location: index.php");
}
require_once 'db_connect.php';

//add comment things here
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $error_message = "";
    $new_comment_query = "INSERT INTO `restaurant_comments` (`restaurant_comment_id`, `restaurant_id`, `user_id`, `restaurant_comment`, `restaurant_rate`)" .
        " VALUES (NULL, " . $_GET["store_id"] . "," . $_SESSION['user_id'] . ",'" . $_POST['new_comment'] . "'," .
        $_POST['new_rate'] . ")";
    if (!($new_food_result = mysqli_query($db_link, $new_comment_query))) {
        $error_message = "發生不明的錯誤，請聯絡網站管理員。" . mysqli_error($db_link);
    }
    if (!empty($error_message)) {
        echo "<script language=\"javascript\">\n";
        echo "alert(\"$error_message\")\n";
        echo "</script>\n";
    }
}

//load data from database
$restaurant_detail_query = "SELECT * FROM `restaurant` WHERE `store_id` = " . $_GET["store_id"];
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
    <title><?php echo $restaurant_detail['restaurant_name'] ?> - 美食東華</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/detail_page_style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
</head>
<body>
<div id="nav-placeholder"></div>
<script>
    $(function () {
        $("#nav-placeholder").load("ui_navbar.php");
    });
</script>

<div class="container">
    <section class="hero is-light">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">
                    <?php echo $restaurant_detail['restaurant_name'] ?>
                </h1>
                <h2 class="subtitle">
                    <?php
                    echo $restaurant_detail['restaurant_address'];
                    ?>
                </h2>
            </div>
        </div>
    </section>

    <div>
        <br>
        <h1 class="title">餐廳資訊</h1>
        <div class="columns is-multiline">
            <div class="column is-one-third">
                <div class="box">
                    <p class="title">連絡電話</p>
                    <p class="subtitle"><?php echo $restaurant_detail['restaurant_phone'] ?></p>
                </div>
            </div>

            <div class="column is-one-third">
                <div class="box">
                    <p class="title">外送規定</p>
                    <p class="subtitle"><?php echo $restaurant_detail['restaurant_takeout'] ?></p>
                </div>
            </div>

            <div class="column is-one-third">
                <div class="box">
                    <p class="title">Facebook 粉絲專頁</p>
                    <p class="subtitle"><?php echo $restaurant_detail['restaurant_fbpage'] ?></p>
                </div>
            </div>

            <div class="column is-one-third">
                <div class="box">
                    <p class="title">LINE ID</p>
                    <p class="subtitle"><?php echo $restaurant_detail['restaurant_lineid'] ?></p>
                </div>
            </div>

            <div class="column is-one-third">
                <div class="box">
                    <p class="title">Review</p>
                    <p class="subtitle">
                        <?php echo '<a href="' . $restaurant_detail['restaurant_review_url'] . '">' .
                            $restaurant_detail['restaurant_review_url'] . '</a>'
                        ?></p>
                </div>
            </div>
        </div>
    </div>

    <br>
    <h1 class="title">評論</h1>

    <div class="columns is-multiline">
        <?php
        $restaurant_comments_query = "SELECT * FROM `restaurant_comments` WHERE `restaurant_id` = " . $_GET["store_id"];
        $restaurant_comments_result = mysqli_query($db_link, $restaurant_comments_query);
        if (!$restaurant_comments_result) {
            echo "資料庫發生異常，請稍後再試或聯絡網站管理者。";
        } else {
            if ($restaurant_comments_result->num_rows == 0) {
                echo "還沒有人新增留言。來搶頭香吧！";
            } else {
                while ($restaurant_comment = mysqli_fetch_assoc($restaurant_comments_result)) {
                    echo '<div class="column is-one-third"><div class="box">';
                    //TODO use star icon instead
                    echo '<p class="title">' . $restaurant_comment['restaurant_rate'] . '/5</p>';
                    echo '<p class="wordwrap subtitle">' . $restaurant_comment['restaurant_comment'] . '</p>';
                    echo '</div></div>';
                    //TODO multi-page selector
                }
            }
        }
        ?>
    </div>
    <br>
    <h1 class="title">分享留言和評價</h1>
    <form action="" method="POST">

        <div class="control">
            評分：
            <div class="select">
                <select name="new_rate">
                    <option value=5>5</option>
                    <option value=4>4</option>
                    <option value=3>3</option>
                    <option value=2>2</option>
                    <option value=1>1</option>
                </select>
            </div>
        </div>
        <br>
        <div class="control">
            <textarea class="textarea" name="new_comment" type="text" placeholder="分享您對這間餐廳的看法..."></textarea>
        </div>
        <br>
        <input class="button is-block is-success is-medium" type="submit" value="新增">
    </form>
    <br>

</div>


<!-- restaurant name, contact info and other information here -->
<!-- automatic comment tiles here -->
<!-- new comment field/form here-->

</body>