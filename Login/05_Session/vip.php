<?php
session_start(); // 只要你需要存取Session，一定要有這一段！

//檢查有沒有名稱是"LoginOK"的Session，也檢查值是不是true，沒有就直接把使用者帶到登入首頁
if (!isset($_SESSION["LoginOK"]) || $_SESSION["LoginOK"] !== true) {
    echo "<h1>這是一個秘密網頁，你不是會員，不能進來</h1>";
    echo "<a href='index.php'>回到登入首頁！</a>";

    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>這是會員頁面！</h1>
    <a href='logout.php'>登出</a>
</body>

</html>