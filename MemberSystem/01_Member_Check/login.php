<?php
//檢查有沒有來自index.php帳密的POST
if (!isset($_POST["Account"]) || !isset($_POST["Password"])) {
    echo "<h1>你沒有成功利用POST傳資料過來</h1>";
    echo "<p>你的表單裡面沒有設定好相關變數</p>";
    echo "<a href='index.php'>回到登入首頁！</a>";

    exit;
}

session_start();  // 啟用Session，因為我們要將使用者資料存起來

require("functions.php"); // require() 引用別的PHP檔案

$Account = $_POST["Account"]; //使用者帳號
$Password = $_POST["Password"]; //密碼
$RemeberMe = isset($_POST["RemeberMe"]) ? $_POST["RemeberMe"] : ""; // 記住我。簡化過的判斷式，你可以跟以下原來的程式作個比較
$AccountCheckResult = Account_Check($Account, $Password); // 帳號密碼驗證

if (!empty($AccountCheckResult)) {
    // 設定SESSION，將使用者的資料記錄起來
    $_SESSION["id"] = $AccountCheckResult['id'];
    $_SESSION["account"] = $AccountCheckResult['account'];
    $_SESSION["password"] = $AccountCheckResult['password'];
    $_SESSION["name"] = $AccountCheckResult['name'];
    $_SESSION["admin"] = $AccountCheckResult['admin'];
    
    // 依據有沒有勾選記住我？來設定LoginOK的Cookie的期限
    if ($RemeberMe == "YesRememberMe")
        $date = strtotime("+10 days", time());
    else
        $date = strtotime("+1 minutes", time());

    setcookie("LoginOK", "OK", $date); // 建立LoginOK的Cookie，用來辨識使用者是否已經成功驗證帳號密碼   
    
    echo "<h1>你已成功登入系統</h1>";
    echo "<p>你的帳號是：" . $Account . "<p>";
    echo "<p>你的密碼是：" . $Password . "<p>";
    echo "<p>5秒後頁面將自動跳轉到你的專屬頁面！</p>";

    Check_Member_Authority(); // 導引到會員分流頁面
} else {
    echo "<h1>沒有這個帳號或者密碼錯誤</h1>";
    echo "<p>5秒後頁面將自動跳轉到登入首頁！或者你也可以<a href='index.php'>回到登入首頁！</a></p>";

    header("refresh:5; url=index.php");
}
