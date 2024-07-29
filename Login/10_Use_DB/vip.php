<?php
//檢查有沒有名稱是"LoginOK"的Cookie，也檢查值是不是OK，沒有就直接把使用者帶到登入首頁
if (!isset($_COOKIE["LoginOK"]) || $_COOKIE["LoginOK"] !== "OK") {
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
    <title>會員頁面</title>
</head>

<body>
    <h1>這是會員頁面！</h1>
    <a href='logout.php'>登出</a>
</body>

</html>