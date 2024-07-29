<?php
//檢查有沒有來自index.php帳密的GET
if (!isset($_GET["Account"]) || !isset($_GET["Password"])) {
    echo "<h1>你沒有成功利用GET傳資料過來</h1>";
    echo "<p>你的表單裡面沒有設定好相關變數</p>";
    echo "<a href='index.php'>回到登入首頁！</a>";
    
    exit;
}

$Account = $_GET["Account"]; //使用者帳號，建議GET的資料要預先抓出來放到變數裡來處理，不要直接處理
$Password = $_GET["Password"]; //密碼

echo "<h1>你有成功利用GET傳資料過來</h1>";
echo "<p>你的帳號是：" . $_GET["Account"];
echo "<p>你的密碼是：" . $_GET["Password"];
echo "<p>我們利用HTTP標頭處理的方法，5秒後將頁面自動跳轉到登入首頁！</p>";

header("refresh:5; url=index.php");
