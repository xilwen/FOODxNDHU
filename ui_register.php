<?php
require_once 'db_connect.php';
$email = $password = $confirm_password = "";
$register_error_message = $register_success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"]))) {
        $register_error_message .= "電子郵件不得為空白";
    } else {
        $register_duplicate_query = "SELECT id FROM users WHERE email='";
        $register_duplicate_query .= trim($_POST["email"]) . "'";
        //check email
        if ($register_duplicate_result = mysqli_query($db_link, $register_duplicate_query)) {
            if (mysqli_num_rows($register_duplicate_result) > 0) {
                $register_error_message .= "電子郵件已被註冊過";
            }
        } else {
            $register_error_message .= "發生錯誤，請稍後再試" . mysqli_error($db_link);
        }
        //check password and confirm
        //TODO Shadow Password
        if (empty(trim($_POST['password']))) {
            $register_error_message .= "請輸入密碼";
        } elseif (strlen(trim($_POST['password'])) < 6) {
            $register_error_message .= "密碼請至少輸入6個字";
        }
        if (empty(trim($_POST["confirm_password"]))) {
            $register_error_message .= '請確認密碼';
        } else {
            if ($password != $confirm_password) {
                $register_error_message .= '兩次輸入的密碼不相符';
            }
        }

        if (empty($register_error_message)) {
            $register_query = "INSERT INTO `users` (`id`, `email`, `password`) VALUES (NULL, '";
            $register_query .= trim($_POST["email"]) . "','";
            $register_query .= trim($_POST["password"]) . "')";
            if ($register_duplicate_result = mysqli_query($db_link, $register_query)) {
                $register_success_message = "註冊成功，前往登入畫面。";
            } else {
                $register_success_message = "發生不明的錯誤，請聯絡網站管理員。" . mysqli_error($db_link);
            }
        }
    }
    if (!empty($register_error_message)) {
        echo "<script language=\"javascript\">\n";
        echo "alert(\"$register_error_message\")\n";
        echo "</script>\n";
    } elseif (!empty($register_success_message)) {
        echo '<script language="javascript">';
        echo "alert(\"$register_success_message\")\n";
        echo 'window.location.href = "ui_login.php";';
        echo '</script>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>註冊 - 美食東華</title>
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

<section class="hero is-success is-large">
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h3 class="title has-text-grey">註冊新的帳號</h3>
                <p class="subtitle has-text-grey">註冊帳號以發表評論、或新增店家或餐點</p>
                <div class="box">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="email" type="email" placeholder="您的電子郵件信箱"
                                       autofocus="">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="password" type="password" placeholder="要使用的密碼">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="confirm_password" type="password"
                                       placeholder="請再輸入一次密碼">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="button is-block is-primary is-large" type="submit" value="註冊">
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script async type="text/javascript" src="js/bulma.js"></script>
</body>

</html>