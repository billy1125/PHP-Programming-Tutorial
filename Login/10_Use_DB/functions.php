<?php
// 基本的函式設計
// 關鍵字一定是「function」
// 取一個名稱，建議要按照一個命名規則
// 括號內，可以設計參數來使用，每一個參數可以看成變數宣告，用逗點隔開

require_once("DB_config.php"); //資料庫連線

function DB_Connect()
{
    // 建立資料庫連線
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

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
    //讀取帳號記錄的檔案
    $AccountCheckResult = false; // $AccountCheckResult 變數用來做回傳值
    $link = DB_Connect(); // 連線函式

    try {
        if ($link === false) {
            die("發生錯誤無法連線，錯誤可能是：" . mysqli_connect_error());
        } else {
            echo "<p>資料庫連線成功</p>";

            $sql = "SELECT * FROM users WHERE account = '" . $_account . "' AND password = '" . $_password . "'"; // 指定SQL查詢字串

            echo "<p>SQL查詢字串: $sql </p>";

            //送出UTF8編碼的MySQL指令
            mysqli_query($link, 'SET NAMES utf8');

            // 送出查詢的SQL指令
            if ($result = mysqli_query($link, $sql)) {
                
                $total_records = mysqli_num_rows($result);
                echo "<p><b>顯示查詢後筆數：</b>" . $total_records . "</p>";  // 顯示查詢結果

                if ($total_records > 0) 
                    $AccountCheckResult = true; //如果帳號密碼正確，$AccountCheckResult就等於「真」                

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

    return $AccountCheckResult; // 跑完讀檔後，最終整個函式會丟出去 $AccountCheckResult 變數
}

//底下你還可以設計更多函式，依照各個程式的需要引入，讓你的程式更為結構化！
