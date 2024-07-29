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

// 新增訂單資料
function Add_Order(string $_user_id, string $_name, string $_telphone, string $_email, string $_address)
{
    $pdo = DB_Connect(); // 執行連線函式
    $AddResult = false;

    $pdo->beginTransaction(); // 開啟一個交易

    try {
        if ($pdo === false) {
            die("發生錯誤無法連線");
        } else {
            $OrdersId = "";
            // 新增一筆訂單
            $data = [$_user_id, $_name, $_telphone, $_email, $_address];
            $sql = "INSERT INTO orders (user_id, name, telephone, email, address) VALUES (?, ?, ?, ?, ?)";
            $statement = $pdo->prepare($sql);

            if ($statement->execute($data)) {
                $OrdersId = $pdo->lastInsertId(); // 取得最新的訂單編號（orders.id）
            }           
            // 依照購物車Cookie逐一新增訂單細項
            foreach ($_COOKIE["CartItems"] as $key => $value) {
                $data = [$OrdersId, $key, $value];
                $sql = "INSERT INTO orders_detail (order_id, item_id, numbers) VALUES (?, ?, ?)";
                $statement = $pdo->prepare($sql);
                $statement->execute($data);
            }

            $pdo->commit(); // 如果資料都成功新增，進行commit，才會真正的把資料寫進資料庫中
            $AddResult = true;
        }
    } catch (PDOException $e) {
        $pdo->rollBack(); // 如果有SQL語法無法正常執行，就rollback，取消資料庫資料的更動
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        unset($PDO);
    }

    return $AddResult;
}

// 計算購物車裡面有多少商品
function Count_Cart_Items()
{
    $Total = 0;
    if (isset($_COOKIE["CartItems"])) {
        foreach ($_COOKIE["CartItems"] as $key => $value) {
            $Total += (int)$value;
        }
    }
    return $Total;
}

// 查詢訂單清單
function Query_Orders(string $_user_id, string $_is_admin)
{
    $Orders = array();
    $pdo = DB_Connect();

    try {
        if ($pdo === false) {
            die("發生錯誤無法連線");
        } else {
            $data = [$_user_id];
            // 判斷是不是管理員，如果是管理員則是查詢「全部的訂單」
            $sql = ($_is_admin == "Y") ? "SELECT * FROM orders" : "SELECT * FROM orders WHERE user_id = ?";  
            $statement = $pdo->prepare($sql);

            if ($statement->execute($data)) {
                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    array_push($Orders, $row);
                }
            }
        }
    } catch (PDOException $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        unset($PDO);
    }

    return $Orders;
}

// 查詢訂單細項
function Query_Orders_Detail(string $_order_id)
{
    $OrderDetail = array();
    $pdo = DB_Connect();

    try {
        if ($pdo === false) {
            die("發生錯誤無法連線");
        } else {
            $data = [$_order_id];
            // 進階的SQL聯合查詢，使用代碼與簡單的運算
            $sql = "SELECT b.name, a.numbers, b.price, b.price * a.numbers subtotal FROM orders_detail a, items b WHERE a.item_id = b.id AND a.order_id = ?";  
            $statement = $pdo->prepare($sql);

            if ($statement->execute($data)) {
                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    array_push($OrderDetail, $row);
                }
            }
        }
    } catch (PDOException $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        unset($PDO);
    }

    return $OrderDetail;
}
