<?php
//檢查有沒有名稱是"LoginOK"的Cookie，也檢查值是不是OK，沒有就直接把使用者帶到登入首頁
if (isset($_COOKIE["LoginOK"]) && $_COOKIE["LoginOK"] == "OK") {
    session_start();  // 啟用Session
    require("functions.php"); // require() 引用別的PHP檔案
    Check_Member_Authority(); // 導引到會員分流頁面
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員系統</title>
</head>

<body>
    <h1>會員系統 Ver 2.0</h1>
    <p>設計管理者頁面</p>
    <hr>
    <form name="login" method="post" action="login.php">
        帳號: <input type="text" name="Account" size="15" /><br />
        密碼: <input type="password" name="Password" size="15" /><br />
        <input type="checkbox" name="RemeberMe" value="YesRememberMe" />記住我
        <input type="submit" value="登入" />
    </form>
</body>

</html>