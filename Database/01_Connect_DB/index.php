<?php
// 資料庫連線基本設定
define('DB_SERVER', 'localhost'); // MySQL主機名稱 
define('DB_USERNAME', 'root');    // 使用者名稱 
define('DB_PASSWORD', '');        // 密碼
define('DB_NAME', 'login');       // 預設使用的資料庫名稱

// 建立資料庫連線
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP資料庫</title>
</head>

<body>
    <h1>PHP資料庫</h1>
    <p>資料庫連線基礎</p>
    <hr>
    <?php
    // 確認是否有連線成功？
    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
        } else {
            echo "<p>資料庫連線成功</p>";
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        // 關閉資料庫連結，一定要做！
        mysqli_close($link);
        echo "<p>關閉資料庫連結成功</p>";
    }
    ?>
</body>

</html>