<?php
require_once 'db_connect.php';
$error_message = "";
$user_id = 0;
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["user_favorite_id"])) {
        $delete_query = 'DELETE FROM `users_favorite` WHERE `users_favorite`.`user_favorite_id` = ' . $_POST["user_favorite_id"];
        if ($user_id_query_result = mysqli_query($db_link, $delete_query)) {
            $error_message .= "刪除成功";
        } else {
            $error_message .= "刪除失敗" . mysqli_error($db_link);
        }
    }
}

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("location: ui_login.php");
}
$user_id_query = "SELECT `id` FROM `users` WHERE `email` ='";
$user_id_query .= $_SESSION['username'] . "'";
if ($user_id_query_result = mysqli_query($db_link, $user_id_query)) {
    $row = mysqli_fetch_assoc($user_id_query_result);
    $user_id = $row['id'];
} else {
    $error_message .= "發生意外的錯誤。" . mysqli_error($db_link);
}
if (!empty($error_message)) {
    echo "<script language=\"javascript\">\n";
    echo "alert(\"$error_message\")\n";
    echo "</script>\n";
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>關注清單 - 美食東華</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
</head>

<body>
<div id="nav-placeholder"></div>
<script>
    $(function () {
        $("#nav-placeholder").load("ui_navbar.php");
    });
</script>
<section class="hero">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                關注清單
            </h1>
            <h2 class="subtitle">
                持續追蹤、關注或取消關注有興趣的餐點
            </h2>
        </div>
    </div>
</section>
<div class="tile is-ancestor">
    <div class="tile is-parent is-vertical">
        <?php
        if (!empty($user_id)) {
            $user_favorite_query = "SELECT `user_favorite_id`, `food_id` FROM `users_favorite` WHERE `user_id`=";
            $user_favorite_query .= $user_id;
            if ($user_favorite_query_result = mysqli_query($db_link, $user_favorite_query)) {
                if (mysqli_num_rows($user_favorite_query_result) == 0) {
                    echo '<article class="tile is-child notification is-primary">目前沒有任何關注中的項目。</article>';
                } else {
                    while (($data = mysqli_fetch_assoc($user_favorite_query_result))) {
                        echo '<article class="tile is-child notification is-primary">';
                        $food_id = $data['food_id'];
                        $restaurant_name = "";
                        $food_query = "SELECT `restaurant_id`,`food_name`,`food_price` FROM `food` WHERE `food_id`=" . $food_id;
                        if ($food_query_result = mysqli_query($db_link, $food_query)) {
                            if (mysqli_num_rows($food_query_result) == 0) {
                                echo '哎呀，這個餐點的資訊不見了！<br>';
                            } else {
                                $food_data = mysqli_fetch_assoc($food_query_result);
                                $restaurant_query = "SELECT `restaurant_name` FROM `restaurant` WHERE `store_id`=" . $food_data['restaurant_id'];
                                if ($restaurant_query_result = mysqli_query($db_link, $restaurant_query)) {
                                    if (mysqli_num_rows($restaurant_query_result) == 0) {
                                        echo '哎呀，這間餐廳的資訊不見了！<br>';
                                    } else {
                                        $row = mysqli_fetch_assoc($restaurant_query_result);
                                        $restaurant_name = $row['restaurant_name'];
                                        $food_name = $food_data['food_name'];
                                        $food_price = $food_data['food_price'];
                                    }
                                } else {
                                    echo '讀取餐廳資訊時發生錯誤';
                                }

                            }
                        } else {
                            echo '讀取餐點資訊時發生錯誤';
                        }
                        $user_favorite_id = $data['user_favorite_id'];
                        echo "$food_name<br>餐廳：$restaurant_name<br>$food_price 元<br>";
                        echo '<form action="';
                        echo htmlspecialchars($_SERVER["PHP_SELF"]);
                        echo '" method="POST">';
                        echo '<input class="button is-block is-danger" type="submit" value="刪除">';
                        echo "<input type=\"hidden\" name=\"user_favorite_id\" value=$user_favorite_id>";
                        echo '</form>';
                        echo '</article>';
                    }
                }
            } else {
                echo '存取清單時發生錯誤。';
            }
        }
        ?>
    </div>
</div>
</body>

</html>