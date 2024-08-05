<?php
if (isset($_POST["Account"]) && isset($_POST["Password"])) {
    session_start();
    require("functions.php"); // require() 引用別的PHP檔案
    
    $Account = $_POST["Account"];                                       // 使用者帳號
    $Password = $_POST["Password"];                                     // 密碼
    $RemeberMe = isset($_POST["RemeberMe"]) ? $_POST["RemeberMe"] : ""; // 記住我
    $AccountCheckResult = Account_Check($Account, $Password);           // 帳號密碼驗證
    
    if (!empty($AccountCheckResult)) {
        $_SESSION["id"] = $AccountCheckResult['id'];
        $_SESSION["account"] = $AccountCheckResult['account'];
        $_SESSION["password"] = $AccountCheckResult['password'];
        $_SESSION["name"] = $AccountCheckResult['name'];
        $_SESSION["admin"] = $AccountCheckResult['admin'];
        
        if ($RemeberMe == "YesRememberMe")
            $date = strtotime("+10 days", time());
        else
            $date = strtotime("+1 minutes", time());
    
        setcookie("LoginOK", "OK", $date);   
        
        echo "<h1>你已成功登入系統</h1>";
        echo "<p>你的帳號是：" . $Account . "<p>";
        echo "<p>你的密碼是：" . $Password . "<p>";
        echo "<p>5秒後頁面將自動跳轉到你的專屬頁面！</p>";
    
        header("refresh:5; url=index.php");
    } else {
        echo "<h1>沒有這個帳號或者密碼錯誤</h1>";
        echo "<p>5秒後頁面將自動跳轉到登入首頁！或者你也可以<a href='index.php'>回到登入首頁！</a></p>";
    
        header("refresh:5; url=index.php");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>簡易討論板 登入</title>
</head>

<body>
    <h1>簡易討論板</h1>
    <h2>您尚未登入，請輸入您的帳號密碼</h2>
    <hr>
    <form name="login" method="post" action="login.php">
        帳號: <input type="text" name="Account" size="15" /><br />
        密碼: <input type="password" name="Password" size="15" /><br />
        <input type="checkbox" name="RemeberMe" value="YesRememberMe" />記住我
        <input type="submit" value="登入" />
    </form>
</body>

</html>