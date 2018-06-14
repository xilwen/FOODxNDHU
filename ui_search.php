<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>搜尋 - 美食東華</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>

<body>
<div id="nav-placeholder"></div>
<script>
    $(function () {
        $("#nav-placeholder").load("ui_navbar.php");
    });
</script>

<section class="hero is-success">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h3 class="title has-text-grey">搜尋</h3>
                <p class="subtitle has-text-grey">請輸入至少一個項目來搜尋餐點，<br>或留白以列出全部項目</p>
                <div class="box">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="restaurant_name" type="text" placeholder="店家名稱"
                                       autofocus="">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="food_name" type="text" placeholder="餐點名稱">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="price_higher_than" type="text" placeholder="價位高於">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="price_lower_than" type="text" placeholder="價位低於">
                            </div>
                        </div>
                        <input type="hidden" name="action" value="search">
                        <input class="button is-block is-success is-large" type="submit" value="搜尋">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script async type="text/javascript" src="js/bulma.js"></script>
</body>
</html>
<?php
$error_message = "";
$user_id = 0;
session_start();
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["action"] == "addFav") {
        $user_id_query = "SELECT `id` FROM `users` WHERE `email` ='";
        $user_id_query .= $_SESSION['username'] . "'";
        if ($user_id_query_result = mysqli_query($db_link, $user_id_query)) {
            $row = mysqli_fetch_assoc($user_id_query_result);
            $user_id = $row['id'];
        } else {
            $error_message .= "發生意外的錯誤。" . mysqli_error($db_link);
        }
        $addfav_query = 'INSERT INTO `users_favorite` (`user_favorite_id`, `user_id`, `food_id`) VALUES (NULL, ';
        $addfav_query .= $user_id . ',' . $_POST["food_id"] . ')';
        if ($addfav_query_result = mysqli_query($db_link, $addfav_query)) {
            echo('<center>已經新增到關注清單。</center>');
        } else {
            echo('<center>新增到關注清單時發生意外</center>');
        }

    } else {
        $where = "";

        if (!empty($_POST["restaurant_name"])) {
            $where .= "`restaurant_name` LIKE '%" . $_POST["restaurant_name"] . "%'";
        }
        if (!empty($_POST["food_name"])) {
            if (!empty($where)) {
                $where .= " OR ";
            }
            $where .= "`food_name` LIKE '%" . $_POST["food_name"] . "%'";
        }
        if (!empty($_POST["price_higher_than"])) {
            if (!empty($where)) {
                $where .= " OR ";
            }
            $where .= "`food_price` > '" . $_POST["price_higher_than"] . "'";
        }
        if (!empty($_POST["price_lower_than"])) {
            if (!empty($where)) {
                $where .= " OR ";
            }
            $where .= "`food_price` < '" . $_POST["price_lower_than"] . "'";
        }

        if (empty($where)) {
            $where = "1";
        }
        $integrate_query = "SELECT * FROM `food` JOIN `restaurant` ON `restaurant_id` = `store_id` WHERE " . $where;
        if ($integrate_query_result = mysqli_query($db_link, $integrate_query)) {
            if (mysqli_num_rows($integrate_query_result) == 0) {
                echo '<center>沒有找到結果。</center>';
            } else {
                echo '<center><table class="table"><thead><tr><th>店家名稱</th><th>餐點名稱</th><th>餐點價位</th><th>加入關注清單</th></tr></thead><tbody>';
                while ($data = mysqli_fetch_assoc($integrate_query_result)) {
                    echo '<tr>';
                    echo '<td>' . $data['restaurant_name'] . '</td>';
                    echo '<td>' . $data['food_name'] . '</td>';
                    echo '<td>' . $data['food_price'] . '</td>';
                    echo '<td><form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) .
                        '" method="POST"><input class="button is-block is-primary" type="submit" value="加入"><input type="hidden" name="action" value="addFav">' .
                        '<input type="hidden" name="food_id" value=' . $data['food_id'] . '></form>'
                        . '</td>';
                    echo '</tr>';
                }

                echo '</tbody></table></center>';
            }

        } else {
            echo '<center> 系統錯誤 </center><br>' . mysqli_error($db_link);
        }
    }
}

?>