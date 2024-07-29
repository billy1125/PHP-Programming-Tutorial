<?php
session_start(); // 只要你需要存取Session，一定要有這一段！

session_destroy(); //將SESSION變數整個清除掉

echo "你已經登出成功，5秒鐘後回到登入畫面";
header("refresh:5; url=index.php");
