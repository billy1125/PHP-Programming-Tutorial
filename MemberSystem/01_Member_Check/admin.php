<?php
session_start();

// 檢查有沒有Login的Cookie，也檢查是不是管理員？
if ((!isset($_COOKIE["LoginOK"]) || $_COOKIE["LoginOK"] !== "OK") &&
   (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== "Y")) {
    echo "<h1>這是一個秘密網頁，你不是管理員，不能進來</h1>";
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
    <title>管理者頁面</title>
</head>

<body>
    <h1><?php echo $_SESSION["name"]; ?> 你好！這是管理者頁面！</h1>

    <a href='logout.php'>登出</a>
</body>

</html>