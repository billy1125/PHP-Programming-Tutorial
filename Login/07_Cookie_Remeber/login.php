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
$RemeberMe = "";

if (isset($_POST["RemeberMe"])) //取得是不是有勾選「記住我」，建議要先確定有傳過來POST再記錄
    $RemeberMe = $_POST["RemeberMe"]; 

if ($Account == "abc" && $Password == "123"){
    
    $date = "";
    
    if ($RemeberMe == "YesRememberMe")
        $date = strtotime("+10 days", time()); //如果有勾選「記住我」，設定一個十天後的日期
    else
        $date = strtotime("+1 minutes", time()); //如果沒有勾選「記住我」，設定一個1分鐘後的日期，也就是說你將Cookie設定1分鐘後過期    

    //建立一個名稱叫"LoginOK"的Cookie裡面，並且我們賦值為OK
    setcookie("LoginOK", "OK", $date); // 新增Cookie
    
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
