<?php
// 資料庫連線基本設定
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'login');

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
    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
        } else {
            echo "<p>資料庫連線成功</p>";

            $sql = "SELECT * FROM users WHERE account = 'abc' AND password = '123'"; // 指定SQL查詢字串

            echo "<p>SQL查詢字串: $sql </p>";

            //送出UTF8編碼的MySQL指令
            mysqli_query($link, 'SET NAMES utf8');

            // 送出查詢的SQL指令
            if ($result = mysqli_query($link, $sql)) {

                echo "<p><b>顯示查詢結果：</b></p>";  // 顯示查詢結果

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "ID：" . $row["id"] . "<br/>";
                    echo "帳號" . $row["account"] . "<br/>";
                    echo "密碼：" . $row["password"] . "<br/>";
                    echo "名稱：" . $row["name"] . "<br/>";
                    echo "權限：" . $row["authority"] . "<br/>";
                }

                mysqli_free_result($result); // 釋放佔用記憶體
            }
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