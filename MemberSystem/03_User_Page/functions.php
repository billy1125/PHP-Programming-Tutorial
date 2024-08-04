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

// 帳號密碼確認
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
            // SQL查詢指令，請特別注意：SELECT 只抓取五個欄位值 id, account, password, name, admin，這個順序會和以下的查詢結果相對應，別弄混
            $sql = "SELECT id, account, password, name, admin FROM users WHERE account = :account AND password = :password";
            $statement = $pdo->prepare($sql);
            // 綁定變數值
            $statement->bindParam(':account', $_account, PDO::PARAM_STR);   
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

// 依照使用者的權限分流到不同頁面
function Check_Member_Authority()
{    
    if (isset($_SESSION["admin"])) {
        echo "<p>你過去已經登入過，5秒後頁面將自動跳轉到你的專屬頁面！</p>";
        if ($_SESSION["admin"] == "Y") {
            header("refresh:5; url=admin.php"); // 如果SESSION['admin']是Y，代表使用者有管理者權限，導引到管理者頁面
        } else {
            header("refresh:5; url=member.php?id={$_SESSION["id"]}"); // 一般使用者，導引到一般會員頁面
        }
    }
}

// 查詢所有使用者資料
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
    }

    return $result;
}

// 查詢單一使用者
function Query_One_Member(string $_id)
{
    $result = null; // $result 變數用來做回傳值
    $pdo = DB_Connect(); // 連線函式

    try {
        if ($pdo === false) {
            die("發生錯誤無法連線");
        } else {
            echo "<p>資料庫連線成功</p>";
            $sql = "SELECT id, account, password, name, admin FROM users WHERE id = :id";
            $statement = $pdo->prepare($sql);
            // 綁定變數值
            $statement->bindParam(':id', $_id, PDO::PARAM_STR);   

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

// 更新使用者資料
function Update_Member(string $_account, string $_password, string $_name, string $_admin, string $_id)
{
    $result = false; // $result 變數用來做回傳值
    $pdo = DB_Connect(); // 連線函式

    try {
        if ($pdo === false) {
            die("發生錯誤無法連線");
        } else {
            echo "<p>資料庫連線成功</p>";
            $sql = "UPDATE users SET account = :account,
                                     password = :password,
                                     name = :name,
                                     admin = :admin
                    WHERE id = :id";

            $statement = $pdo->prepare($sql);
            // 綁定變數值
            $statement->bindParam(':account', $_account, PDO::PARAM_STR); 
            $statement->bindParam(':password', $_password, PDO::PARAM_STR); 
            $statement->bindParam(':name', $_name, PDO::PARAM_STR); 
            $statement->bindParam(':admin', $_admin, PDO::PARAM_STR); 
            $statement->bindParam(':id', $_id, PDO::PARAM_STR);   

            // 判斷查詢指令有沒有成功
            if ($statement->execute()) {
                $result = true; // 將查詢結果存到 $result
            }
        }
    } catch (PDOException $e) {
        echo '資料庫錯誤: ',  $e->getMessage(), "\n";
    } finally {
        unset($PDO);
    }

    return $result;
}
