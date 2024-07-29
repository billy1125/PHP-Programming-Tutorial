<?php
//檢查有沒有名稱是"LoginOK"的Cookie，也檢查值是不是OK，沒有就直接把使用者帶到登入首頁
if (isset($_COOKIE["LoginOK"]) && $_COOKIE["LoginOK"] == "OK") {
    header("location:vip.php"); //直接跳到會員頁面
}
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入系統</title>
</head>

<body>
    <h1>登入系統 Ver 8.0</h1>
    <p>使用檔案來存帳號密碼，讀取檔案，並且解讀內容</p>
    <hr>
    <form name="login" method="post" action="login.php">
        帳號: <input type="text" name="Account" size="15" /><br />
        密碼: <input type="password" name="Password" size="15" /><br />
        <input type="checkbox" name="RemeberMe" value="YesRememberMe" />記住我
        <input type="submit" value="登入" />
    </form>
</body>

</html>