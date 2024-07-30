<?php
function DB_Connect()
{
    // 資料庫連線基本設定
    $dbms = 'mysql';     //資料庫類型
    $host = 'localhost'; //資料庫位址
    $dbName = 'login';   //預設資料庫
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

// 查詢是否具有特定帳密
function Account_Check(string $_account, string $_password)
{
    //讀取帳號記錄的檔案
    $result = null; // $result 變數用來做回傳值
    $pdo = DB_Connect(); // 連線函式

    try {
        if ($pdo === false) {
            die("發生錯誤無法連線");
        } else {
            echo "<p>資料庫連線成功</p>";
            $sql = "SELECT * FROM users WHERE account = :account AND password = :password"; // SQL查詢指令，請特別注意： WHERE後以參數的方式設計，避免SQL注入！
            $statement = $pdo->prepare($sql);
            // 綁定變數值，這個綁定與SQL查詢指令是相對應的，請特別注意順序
            $statement->bindParam(':account', $_account, PDO::PARAM_STR);   // PARAM_STR 這是指參數是字串
            $statement->bindParam(':password', $_password, PDO::PARAM_STR);

            // 判斷查詢指令有沒有成功
            if ($statement->execute()) {
                $result = $statement->fetch(PDO::FETCH_ASSOC); // 將查詢結果存到 $result
            }
        }
    } catch (PDOException $e) {
        echo '資料庫錯誤: ',  $e->getMessage(), "\n";
    } finally {
        unset($PDO);
    }

    return $result;
}