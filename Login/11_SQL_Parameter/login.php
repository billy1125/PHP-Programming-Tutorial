<?php
//檢查有沒有來自index.php帳密的POST
if (!isset($_POST["Account"]) || !isset($_POST["Password"])) {
    echo "<h1>你沒有成功利用POST傳資料過來</h1>";
    echo "<p>你的表單裡面沒有設定好相關變數</p>";
    echo "<a href='index.php'>回到登入首頁！</a>";

    exit;
}

require("functions.php"); // require() 引用別的PHP檔案

$Account = $_POST["Account"]; //使用者帳號
$Password = $_POST["Password"]; //密碼
$RemeberMe = "";
$AccountCheckResult = null;

if (isset($_POST["RemeberMe"]))
    $RemeberMe = $_POST["RemeberMe"];

// 函式：查詢是否具有特定帳密
$AccountCheckResult = Account_Check($Account, $Password); 

// 確認回傳的查詢結果是否有資料？有代表帳號密碼的配對在資料庫有資料，沒有代表帳密查不到相對應的資料，也就是帳號密碼是錯誤的
if (!empty($AccountCheckResult)) {

    $date = "";

    if ($RemeberMe == "YesRememberMe")
        $date = strtotime("+10 days", time());
    else
        $date = strtotime("+1 minutes", time());

    setcookie("LoginOK", "OK", $date); 

    echo "<h1>你已成功登入系統</h1>";
    echo "<p>你的帳號是：$Account<p>";
    echo "<p>你的密碼是：$Password<p>";
    echo "<p>5秒後頁面將自動跳轉到會員專屬頁面！</p>";

    header("refresh:5; url=vip.php");
} else {
    echo "<h1>沒有這個帳號或者密碼錯誤</h1>";
    echo "<p>5秒後頁面將自動跳轉到登入首頁！或者你也可以<a href='index.php'>回到登入首頁！</a></p>";

    header("refresh:5; url=index.php");
}
