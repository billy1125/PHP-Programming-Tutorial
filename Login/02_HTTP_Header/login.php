<?php

echo "<h1>5秒鐘後進入登入畫面</h1>";
echo "<p>我們利用HTTP標頭處理的方法，將頁面自動跳轉到登入首頁！</p>";

header("refresh:5; url=index.php"); //5秒鐘後跳回前一頁
// header("location:index.php"); //直接跳回前一頁
