<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入系統</title>
</head>

<body>
    <h1>登入系統 Ver 2.0 HTTP標頭處理</h1>
    <p>我們利用HTTP標頭處理的方法，將頁面自動跳轉到登入首頁！</p>
    <hr>
    <form name="login" method="post" action="login.php">
        帳號: <input type="text" name="Account" size="15" /><br />
        密碼: <input type="password" name="Password" size="15" /><br />
        <input type="checkbox" name="RemeberMe" checked="True" value="YesRememberMe" />記住我
        <input type="submit" value="登入" />
    </form>
</body>

</html>