<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>美食東華</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.min.css"/>
    <link rel="stylesheet" type="text/css" href="css/index.css">
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
<center>評價功能尚未開放</center>
<!--  automatic tiles / php code puts here -->

</html>