<?php
setcookie("LoginOK", "", time() - 3600); //將Cookie移除的方式是讓它「過期」，所以時間設定為現在時間的一小時前

echo "你已經登出成功，5秒鐘後回到登入畫面";
header("refresh:5; url=index.php");
