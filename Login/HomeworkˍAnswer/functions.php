<?php
// 基本的函式設計
// 關鍵字一定是「function」
// 取一個名稱，建議要按照一個命名規則
// 括號內，可以設計參數來使用，每一個參數可以看成變數宣告，用逗點隔開



function Account_Check(string $_account, string $_password, string $_checkword, string $_date)
{
    //讀取帳號記錄的檔案
    $AccountCheckResult = false; // $AccountCheckResult 變數用來做回傳值

    if (!empty($_SESSION['check_word']) && $_checkword == $_SESSION['check_word']) {
        $handle = fopen("account.csv", "r");

        while ($data = fgetcsv($handle, 1000, ",")) {
            $num = count($data);
            if ($_account == $data[1] && $_password == $data[2]) {
                setcookie("UserName", $data[3], $_date);
                setcookie("Authority", $data[4], $_date);
                setcookie("LoginOK", "OK", $_date);
                $AccountCheckResult = true; //如果帳號密碼正確，$AccountCheckResult就等於「真」
            }
        }

        fclose($handle);
    }

    return $AccountCheckResult; // 跑完讀檔後，最終整個函式會丟出去 $AccountCheckResult 變數
}

//底下你還可以設計更多函式，依照各個程式的需要引入，讓你的程式更為結構化！
