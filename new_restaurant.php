<?php
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error_message = "";
    //check must fill-in data
    if (empty(trim($_POST["restaurant_name"])) || empty(trim($_POST["restaurant_address"]))) {
        $error_message .= "請填入必要欄位";
    } else {
        $new_restaurant_query = "INSERT INTO `restaurant` (`store_id`, `restaurant_name`, `restaurant_address`, `restaurant_phone`, `restaurant_takeout`, `restaurant_fbpage`, `restaurant_lineid`) VALUES (NULL, '";
        $new_restaurant_query .= trim($_POST["restaurant_name"]) . "', '";
        $new_restaurant_query .= trim($_POST["restaurant_address"]) . "', '";
        $new_restaurant_query .= trim($_POST["restaurant_phone"]) . "', '";
        $new_restaurant_query .= trim($_POST["restaurant_takeout"]) . "', '";
        $new_restaurant_query .= trim($_POST["restaurant_fbpage"]) . "', '";
        $new_restaurant_query .= trim($_POST["restaurant_lineid"]) . "')";
        if ($new_restaurant_result = mysqli_query($db_link, $new_restaurant_query)) {
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
    <title>新增店家 - 美食東華</title>
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

<section class="hero is-success is-medium">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h3 class="title has-text-grey">新增店家</h3>
                <p class="subtitle has-text-grey">請輸入關於店家的基本資訊</p>
                <div class="box">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="restaurant_name" type="text" placeholder="店家名稱(必填)"
                                       autofocus="">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="restaurant_address" type="text"
                                       placeholder="地址(必填)">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="restaurant_phone" type="text" placeholder="聯絡電話">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="restaurant_takeout" type="text" placeholder="外送規定">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="restaurant_fbpage" type="text"
                                       placeholder="Facebook">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="restaurant_lineid" type="text"
                                       placeholder="LINE ID">
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