<?php
//檢查有沒有來自index.php帳密的POST
if (!isset($_POST["Account"]) || !isset($_POST["Password"])) {
    echo "<h1>你沒有成功利用POST傳資料過來</h1>";
    echo "<p>你的表單裡面沒有設定好相關變數</p>";
    echo "<a href='index.php'>回到登入首頁！</a>";
    
    exit; //exit指令出現的話，底下的PHP程式碼都會忽略不執行
} 

$Account = $_POST["Account"]; //使用者帳號，建議POST的資料要預先抓出來放到變數裡來處理，不要直接處理
$Password = $_POST["Password"]; //密碼

echo "<h1>你有成功利用POST傳資料過來</h1>";
echo "<p>你的帳號是：" . $Account;
echo "<p>你的密碼是：" . $Password;
echo "<p>我們利用HTTP標頭處理的方法，5秒後將頁面自動跳轉到登入首頁！</p>";

header("refresh:5; url=index.php");
