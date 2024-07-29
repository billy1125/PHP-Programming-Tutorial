<?php
require_once("DB_config.php"); //資料庫連線

// 資料庫連線
function DB_Connect()
{
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME); // 建立資料庫連線

    // 確認是否有連線成功？
    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
            exit;
        } else {
            echo "<p>資料庫連線成功</p>";
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    }

    return $link;
}

// 帳號密碼確認
function Account_Check(string $_account, string $_password)
{
    $AccountCheckResult = false; // $AccountCheckResult 變數用來做回傳值
    $link = DB_Connect(); // 執行連線函式

    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
        } else {
            // SQL查詢指令，請特別注意：SELECT 只抓取五個欄位值 id, account, password, name, admin，這個順序會和以下的查詢結果相對應，別弄混
            $sql = "SELECT id, account, password, name, admin FROM users WHERE account = ? AND password = ?";

            echo "<p>SQL查詢字串: $sql </p>";

            // mysqli_prepare()用來準備一個SQL查詢預處理，這是最正式的作法，避免被SQL注入攻擊！
            if ($stmt = mysqli_prepare($link, $sql)) {
                // 綁定變數值，這個綁定與SQL查詢指令是相對應的，請特別注意順序
                // 第二個參數指的是參數值是哪一種資料型態？s => string、i => integer、d => double、b => boolean
                // "ss" 意思就是指後面兩個參數值都是字串
                mysqli_stmt_bind_param($stmt, "ss", $param_account, $param_password);

                // 設定參數值
                $param_account = $_account;
                $param_password = $_password;

                // 完成SQL查詢預處理後，就用mysqli_stmt_execute來執行SQL指令
                if (mysqli_stmt_execute($stmt) == true) {
                    // 如果能夠執行，把結果存到暫存區（和之前的範例不同，不是放到特定變數中）
                    mysqli_stmt_store_result($stmt);

                    // 如果查詢的結果有資料列，而且剛好一筆（不能使用大於1筆，一定要剛好）！
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $id, $account, $password, $name, $admin);
                        if (mysqli_stmt_fetch($stmt)) {
                            // 第二次查核：確定傳進來的密碼和查詢的密碼是一模一樣！
                            if ($password == $_password) {
                                // 將所查詢出來的欄位值，存到相關的SESSION變數中
                                $_SESSION["id"] = $id; // id
                                $_SESSION["account"] = $account; // 帳號
                                $_SESSION["password"] = $password; // 密碼
                                $_SESSION["name"] = $name; // 姓名
                                $_SESSION["admin"] = $admin; // 使用權限設定，如果是Y代表為管理者帳號
                                $AccountCheckResult = true; //如果帳號密碼正確，$AccountCheckResult就等於「真」 
                            }
                        }
                    }
                }
            }
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        // 關閉資料庫連結，一定要做！
        mysqli_close($link);
        echo "<p>關閉資料庫連結成功</p>";
    }

    return $AccountCheckResult; // 最終整個函式會丟出去 $AccountCheckResult 變數
}

// 依照使用者的權限分流到不同頁面
function Check_Member_Authority()
{    
    if (isset($_SESSION["admin"])) {
        if ($_SESSION["admin"] == "Y") {
            header("refresh:5; url=admin.php"); // 如果SESSION['admin']是Y的，代表使用者有管理者權限
        } else {
            header("refresh:5; url=edit_member.php?id={$_SESSION["id"]}"); // 一般使用者
        }
    }
}

// 查詢所有使用者資料
function Query_All_Members()
{
    $AllMembers = array() ; // 用陣列建立所有使用者資料
    $link = DB_Connect(); // 連線函式

    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
        } else {
            $sql = "SELECT * FROM users";
            mysqli_query($link, 'SET NAMES utf8');

            // 送出查詢的SQL指令
            if ($result = mysqli_query($link, $sql)) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $temp = array("id" => $row["id"],
                                  "account" => $row["account"],
                                  "password" => $row["password"],
                                  "name" => $row["name"],
                                  "admin" => $row["admin"]);
                    array_push($AllMembers, $temp); // array_push()可以將特定陣列「加進」另一個既有的陣列中
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

    return $AllMembers; // 最終整個函式會丟出去 $AllMembers 變數
}

// 查詢單一使用者
function Query_One_Member(string $_id)
{
    $link = DB_Connect(); // 執行連線函式
    $MemberData = array();

    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
        } else {
            // SQL查詢指令，請特別注意：SELECT 只抓取五個欄位值 id, account, password, name, admin，這個順序會和以下的查詢結果相對應，別弄混
            $sql = "SELECT id, account, password, name, admin FROM users WHERE id = ?";

            echo "<p>SQL查詢字串: $sql </p>";

            // mysqli_prepare()用來準備一個SQL查詢預處理，這是最正式的作法，避免被SQL注入攻擊！
            if ($stmt = mysqli_prepare($link, $sql)) {
                // 綁定變數值，這個綁定與SQL查詢指令是相對應的，請特別注意順序
                // 第二個參數指的是參數值是哪一種資料型態？s => string、i => integer、d => double、b => boolean
                // "ss" 意思就是指後面兩個參數值都是字串
                mysqli_stmt_bind_param($stmt, "s", $param_account);

                // 設定參數值
                $param_account = $_id;

                // 完成SQL查詢預處理後，就用mysqli_stmt_execute來執行SQL指令
                if (mysqli_stmt_execute($stmt) == true) {
                    // 如果能夠執行，把結果存到暫存區（和之前的範例不同，不是放到特定變數中）
                    mysqli_stmt_store_result($stmt);

                    // 如果查詢的結果有資料列，而且剛好一筆（不能使用大於1筆，一定要剛好）！
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $id, $account, $password, $name, $admin);
                        if (mysqli_stmt_fetch($stmt)) {
                            $MemberData = array("id" => $id,
                                                "account" => $account,
                                                "password" => $password,
                                                "name" => $name,
                                                "admin" => $admin);                            
                        }
                    }
                }
            }
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        // 關閉資料庫連結，一定要做！
        mysqli_close($link);
        echo "<p>關閉資料庫連結成功</p>";
    }

    return $MemberData; // 跑完讀檔後，最終整個函式會丟出去 $MemberData 變數
}

// 更新使用者資料
function Update_Member(string $_account, string $_password, string $_name, string $_admin, string $_id)
{
    $link = DB_Connect(); // 執行連線函式
    $UpdateResult = false;

    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
        } else {
            $sql = "UPDATE users SET account = ?,
                                     password = ?,
                                     name = ?,
                                     admin = ?
                    WHERE id = ?";

            echo "<p>SQL查詢字串: $sql </p>";

            if ($stmt = mysqli_prepare($link, $sql)) {
                // 綁定變數值，這個綁定與SQL查詢指令是相對應的，請特別注意順序
                // 第二個參數指的是參數值是哪一種資料型態？s => string、i => integer、d => double、b => boolean
                // "ss" 意思就是指後面兩個參數值都是字串
                mysqli_stmt_bind_param($stmt, "sssss", $param_account, $param_password, $param_name, $param_admin, $param_id);

                // 設定參數值
                $param_id = $_id;
                $param_account = $_account;
                $param_password = $_password;
                $param_name = $_name;
                $param_admin = $_admin;

                // 完成SQL查詢預處理後，就用mysqli_stmt_execute來執行SQL指令
                if (mysqli_stmt_execute($stmt) == true) {
                    $UpdateResult = true;
                }
            }
        }
    } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
    } finally {
        // 關閉資料庫連結，一定要做！
        mysqli_close($link);
        echo "<p>關閉資料庫連結成功</p>";
    }

    return $UpdateResult; // 跑完讀檔後，最終整個函式會丟出去 $UpdateResult 變數
}
