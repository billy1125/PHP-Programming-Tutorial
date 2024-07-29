<?php
// 資料庫連線，使用PDO的方式存取資料庫，更好懂，但建議你傳統的寫法別忘掉
function DB_Connect()
{
    // 資料庫連線基本設定
    $dbms = 'mysql';     //資料庫類型
    $host = 'localhost'; //資料庫位址
    $dbName = 'shopping';    //預設資料庫
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

// 查詢所有商品
function Query_All_Items()
{
    $AllItems = array();
    $pdo = DB_Connect(); // 連線函式

    try {
        if ($pdo === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
        } else {
            $sql = "SELECT id, name, price, image FROM items WHERE del = 0";
            $statement = $pdo->query($sql); // 查詢Query的結果

            // PDO::FETCH_ASSOC 能夠把查詢的結果，依照欄位來取值
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                array_push($AllItems, $row);
            }
        }
    } catch (PDOException $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        //關閉資料庫
        unset($PDO);
    }

    return $AllItems;
}

// 查詢特定商品的細節資料
function Query_One_Item(string $_id)
{
    $ItemDetails = array();
    $pdo = DB_Connect(); // 連線函式

    try {
        if ($pdo === false) {
            die("發生錯誤無法連線");
        } else {
            $data = [$_id]; // 用一個簡單的陣列來綁定參數，有沒有比較簡單呢？
            $sql = "SELECT id, name, price, detail, image FROM items WHERE id = ? AND del = 0"; // 只會查出某個特定商品資料
            $statement = $pdo->prepare($sql);

            if ($statement->execute($data)) {
                // PDO::FETCH_ASSOC 能夠把查詢的結果，依照欄位來取值
                $ItemDetails = $statement->fetch(PDO::FETCH_ASSOC);
            }
        }
    } catch (PDOException $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        unset($PDO);
    }

    return $ItemDetails;
}