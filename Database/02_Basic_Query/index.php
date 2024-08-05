<?php
function DB_Connect()
{
    // 資料庫連線基本設定
    $dbms = 'mysql';     //資料庫類型
    $host = 'localhost'; //資料庫位址
    $dbName = 'forum';   //預設資料庫
    $user = 'root';      //帳號
    $pass = '';          //密碼
    $dsn = "$dbms:host=$host;dbname=$dbName";

    try {
        $pdo = new PDO($dsn, $user, $pass); // 建立資料庫連線
        $pdo->exec('SET CHARACTER SET utf8mb4');

        if ($pdo === false) {
            die("發生錯誤無法連線");
            exit;
        }
    } catch (PDOException $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }

    return $pdo;
}

function Query_All_Members()
{
    $result = null; // $result 變數用來做回傳值
    $pdo = DB_Connect(); // 連線函式

    try {
        if ($pdo === false) {
            die("發生錯誤無法連線");
        } else {
            echo "<p>資料庫連線成功</p>";
            $sql = "SELECT id, account, password, name, admin FROM users";
            $statement = $pdo->prepare($sql);

            // 判斷查詢指令有沒有成功
            if ($statement->execute()) {
                $result = $statement->fetchAll(PDO::FETCH_ASSOC); // 將查詢結果存到 $result
            }
        }
    } catch (PDOException $e) {
        echo '資料庫錯誤: ',  $e->getMessage(), "\n";
    } finally {
        unset($PDO);
        echo "<p>資料庫斷線</p>"; 
    }

    return $result;
}
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
    <table border="1">
        <tr>
            <th>ID</th>
            <th>帳號</th>
            <th>密碼</th>
            <th>姓名</th>
            <th>權限</th>
        </tr>
        <?php
        $temp = Query_All_Members();

        foreach ($temp as $row) { // 依序讀取每一行
            echo "<tr>";
            echo "<td>{$row["id"]}</td>";
            echo "<td>{$row["account"]}</td>";
            echo "<td>{$row["password"]}</td>";
            echo "<td>{$row["name"]}</td>";
            echo "<td>{$row["admin"]}</td>";
            echo "</tr>";
        }

        ?>
    </table>
</body>

</html>