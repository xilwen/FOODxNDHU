
<link rel="stylesheet" type="text/css" href="css/navbar.css">
<nav class="navbar">
        <div class="container">
          <div class="navbar-brand">
            <a class="navbar-item logo" href="../">
              美食東華
            </a>
            
          </div>
          <div id="navbarMenu" class="navbar-menu is-active">
            <div class="navbar-end">
              <a class="navbar-item" href="../">
                首頁
              </a>
              <a class="navbar-item" href="ui_favorite.php">
                關注清單
              </a>
              <a class="navbar-item" href="ui_search.php">
                搜尋
              </a>
              <a class="navbar-item" href="new_restaurant.php">
                新增店家
              </a>
              <a class="navbar-item" href="new_food.php">
                新增餐點
              </a>
              <span class="navbar-item">
                <a class="button is-white is-outlined is-small" href="ui_login.php">
                  <span><?php
                  session_start();
                  if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
                    echo('登入/註冊');
                  }else{
                    echo('登出');
                  }
                  ?></span>
                </a>
              </span>
            </div>
          </div>
        </div>
      </nav>