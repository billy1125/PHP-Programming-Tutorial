<?php
//檢查有沒有來自index.php帳密的POST
if (!isset($_POST["Account"]) || !isset($_POST["Password"])) {
    echo "<h1>你沒有成功利用POST傳資料過來</h1>";
    echo "<p>你的表單裡面沒有設定好相關變數</p>";
    echo "<a href='index.php'>回到登入首頁！</a>";

    exit;
}

session_start();  // 啟用Session

$Account = $_POST["Account"]; //使用者帳號
$Password = $_POST["Password"]; //密碼
$RemeberMe = "";
$AccountCheckResult = false;

if (isset($_POST["RemeberMe"])) 
    $RemeberMe = $_POST["RemeberMe"];

//讀取帳號記錄的CSV檔案
$handle = fopen("account.csv", "r");

while ($data = fgetcsv($handle, 1000, ",")) {
    $num = count($data);
    // 逐一讀取記錄的CSV檔案，並且將帳號密碼和陣列索引值1與2的資料作比對，如果正確$AccountCheckResult存為 true
    if ($Account == $data[1] && $Password == $data[2]) {
        $AccountCheckResult = true;
    }
}

fclose($handle);

if ($AccountCheckResult) {

    $date = "";

    if ($RemeberMe == "YesRememberMe")
        $date = strtotime("+10 days", time()); 
    else
        $date = strtotime("+1 minutes", time());   

    setcookie("LoginOK", "OK", $date); 

    echo "<h1>你已成功登入系統</h1>";
    echo "<p>你的帳號是：" . $Account . "<p>";
    echo "<p>你的密碼是：" . $Password . "<p>";
    echo "<p>5秒後頁面將自動跳轉到會員專屬頁面！</p>";

    header("refresh:5; url=vip.php");
} else {
    echo "<h1>沒有這個帳號或者密碼錯誤</h1>";
    echo "<p>5秒後頁面將自動跳轉到登入首頁！或者你也可以<a href='index.php'>回到登入首頁！</a></p>";

    header("refresh:5; url=index.php");
}
