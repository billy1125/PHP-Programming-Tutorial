<?php
require_once("DB_config.php"); //資料庫連線

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

function Account_Check(string $_account, string $_password)
{
    $AccountCheckResult = false; // $AccountCheckResult 變數用來做回傳值
    $link = DB_Connect(); // 執行連線函式

    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
        } else {
            echo "<p>資料庫連線成功</p>";

            // SQL查詢指令，請特別注意： WHERE後以參數的方式設計，避免SQL注入！
            $sql = "SELECT * FROM users WHERE account = ? AND password = ?";

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
                    if (mysqli_stmt_num_rows($stmt) == 1) 
                        $AccountCheckResult = true; //如果帳號密碼正確，$AccountCheckResult就等於「真」 
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

    return $AccountCheckResult; // 跑完讀檔後，最終整個函式會丟出去 $AccountCheckResult 變數
}
