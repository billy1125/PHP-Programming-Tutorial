<?php
// 基本的函式設計
// 關鍵字一定是「function」
// 取一個名稱，建議要按照一個命名規則
// 括號內，可以設計參數來使用，每一個參數可以看成變數宣告，用逗點隔開

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
    $result = null;      // $result 變數用來做回傳值
    $pdo = DB_Connect(); // 連線函式

    try {
        if ($pdo === false) {
            die("發生錯誤無法連線");
        } else {
            echo "<p>資料庫連線成功</p>";
            $sql = "SELECT * FROM users WHERE account = '" . $_account . "' AND password = '" . $_password . "'";
            $statement = $pdo->prepare($sql);

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

//底下你還可以設計更多函式，依照各個程式的需要引入，讓你的程式更為結構化！
