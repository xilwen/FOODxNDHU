<?php
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error_message = "";
    if (empty(trim($_POST["food_name"])) || empty(trim($_POST["food_price"]))) {
        $error_message .= "請填入必要欄位";
    } elseif ($_POST["restaurant_id"] == 0)
        $error_message .= "請選擇店家";
    else {
        $new_food_query = "INSERT INTO `food` (`food_id`, `restaurant_id`, `food_name`, `food_price`) VALUES (NULL, '";
        $new_food_query .= trim($_POST["restaurant_id"]) . "', '";
        $new_food_query .= trim($_POST["food_name"]) . "', '";
        $new_food_query .= trim($_POST["food_price"]) . "')";
        if ($new_food_result = mysqli_query($db_link, $new_food_query)) {
            $error_message .= "新增成功";
        } else {
            $error_message = "發生不明的錯誤，請聯絡網站管理員。" . mysqli_error($db_link);
        }
    }
    if (!empty($error_message)) {
        echo "<script language=\"javascript\">\n";
        echo "alert(\"$error_message\")\n";
        echo "</script>\n";
    }
} else {
    session_start();
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        header("location: ui_login.php");
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>新增餐點 - 美食東華</title>
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

<section class="hero is-success is-large">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h3 class="title has-text-grey">新增餐點</h3>
                <p class="subtitle has-text-grey">請選擇店家並輸入關於餐點的相關資訊</p>
                <div class="box">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="field">
                            <div class="control">
                                <div class="select is-large">
                                    <select name="restaurant_id">
                                        <option value=0>請選擇店家</option>
                                        <?php
                                        $restaurant_list_result = mysqli_query($db_link, "SELECT `store_id`,`restaurant_name` FROM `restaurant` ");
                                        //for($i=0; $i<mysqli_num_rows($restaurant_list_result) ; $i++){
                                        while (($data = mysqli_fetch_assoc($restaurant_list_result))) {
                                            echo '<option value=' . $data['store_id'] . '>' . $data['restaurant_name'] . '</option>';
                                        }
                                        //}
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="food_name" type="text" placeholder="餐點名稱">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="food_price" type="text" placeholder="餐點價位">
                            </div>
                        </div>
                        <input class="button is-block is-success is-large" type="submit" value="新增">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script async type="text/javascript" src="js/bulma.js"></script>
</body>

</html>