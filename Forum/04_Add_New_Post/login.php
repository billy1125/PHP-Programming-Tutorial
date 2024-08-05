<!DOCTYPE html>
<html lang="zh-tw">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>簡易討論板 登入</title>

    <script>
        // 結合JavaScript
        function alertSuccessEvent() {
            alert("你已登入成功!");
            document.location.href = "index.php"; 
        }
        function alertFailEvent() {
            alert("你的帳號密碼有誤!");
            document.location.href = "login.php"; 
        }
    </script>

    <?php
    //檢查有沒有來自index.php帳密的POST
    if (isset($_POST["Account"]) && isset($_POST["Password"])) {
        session_start();  // 啟用Session
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
            
            echo "<script type='text/javascript'>alertSuccessEvent();</script>";
        } else {
            echo "<script type='text/javascript'>alertFailEvent();</script>";
        }
        exit;
    }
    ?>
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