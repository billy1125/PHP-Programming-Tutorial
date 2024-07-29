<?php
//檢查有沒有來自index.php帳密的POST
if (!isset($_POST["Account"]) || !isset($_POST["Password"])) {
    echo "<h1>你沒有成功利用POST傳資料過來</h1>";
    echo "<p>你的表單裡面沒有設定好相關變數</p>";
    echo "<a href='index.php'>回到登入首頁！</a>";
    
    exit;
} 

$Account = $_POST["Account"]; //使用者帳號
$Password = $_POST["Password"]; //密碼

//以下是帳號密碼判斷的機制，請注意：帳號密碼是寫死的，實務上不會這樣搞。
if ($Account == "abc" && $Password == "123"){ 
    echo "<h1>你已成功登入系統</h1>";
    echo "<p>你的帳號是：" . $Account . "<p>";
    echo "<p>你的密碼是：" . $Password . "<p>";
    echo "<p>5秒後頁面將自動跳轉到會員專屬頁面！</p>";
    
    header("refresh:5; url=vip.php");
}else{
    echo "<h1>沒有這個帳號或者密碼錯誤</h1>";
    echo "<p>5秒後頁面將自動跳轉到登入首頁！或者你也可以<a href='index.php'>回到登入首頁！</a></p>";
    
    header("refresh:5; url=index.php");
}
