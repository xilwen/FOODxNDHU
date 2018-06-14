<?php
require_once 'db_connect.php';
$email = $password = "";
$login_error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"]))) {
        $login_error_message .= "請輸入電子郵件信箱";
    }
    if (empty(trim($_POST["password"]))) {
        $login_error_message .= "請輸入密碼";
    }
    if (empty($login_error_message)) {
        $login_query = "SELECT email, password FROM users WHERE email ='";
        $login_query .= trim($_POST["email"]) . "'";
        if ($login_query_result = mysqli_query($db_link, $login_query)) {
            if (mysqli_num_rows($login_query_result) == 0) {
                $login_error_message .= "此電子郵件信箱尚未註冊，請註冊新帳號。";
            } else {
                $row = mysqli_fetch_assoc($login_query_result);
                //shadow password and prevent SQL Injection
                //DEBUG, can be safely deleted
                //$login_error_message .= $row['password'];
                if ($row['password'] != trim($_POST["password"])) {
                    $login_error_message .= "密碼錯誤，請再試一次。";
                } else {
                    session_start();
                    $_SESSION['username'] = trim($_POST["email"]);
                    header("location: index.php");
                }
            }
        } else {
            $login_error_message .= "發生未知的錯誤。";
        }
    }
    if (!empty($login_error_message)) {
        echo "<script language=\"javascript\">\n";
        echo "alert(\"$login_error_message\")\n";
        echo "</script>\n";
    }
} else {
    session_start();
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    } else {
        $_SESSION = array();
    }
    session_destroy();
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登入 - 美食東華</title>
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
                <h3 class="title has-text-grey">登入您的帳號</h3>
                <p class="subtitle has-text-grey">登入以發表評論、或新增店家或餐點</p>
                <div class="box">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="email" type="email" placeholder="電子郵件信箱"
                                       autofocus="">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input class="input is-large" name="password" type="password" placeholder="密碼">
                            </div>
                        </div>

                        <input class="button is-block is-primary is-large" type="submit" value="登入">
                    </form>
                </div>
                <p class="has-text-grey">
                    <a href="ui_register.php">註冊新帳號</a>
                </p>
            </div>
        </div>
    </div>
</section>
<script async type="text/javascript" src="js/bulma.js"></script>
</body>
</html>